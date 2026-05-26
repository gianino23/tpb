<?php

namespace App\Http\Controllers;

use App\Models\CapaianKabupaten;
use App\Models\Tpb;
use App\Models\Target;
use App\Models\Indikator;
use App\Models\Rpjmd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\CapaianNotification;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CapaianKabupatenController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = CapaianKabupaten::query();

        // Only show Capaian if the target (indikator) is verified
        $query->whereHas('indikator', function ($q) {
            $q->where('status', 'Terverifikasi');
        });

        if ($user->level == 'Operator Kabupaten/Kota') {
            $query->where('user_id', $user->id);
        }

        // Apply wilayah filter if exists (using flexible partial matching)
        if ($request->wilayah) {
            $cleanReq = str_replace(['Kabupaten ', 'Kab. ', 'Kota ', 'kabupaten ', 'kota '], '', $request->wilayah);
            $query->where('wilayah', 'LIKE', '%' . $cleanReq . '%');
        }

        // Stats for cards (before status filtering)
        $statsQuery = clone $query;
        $countMenunggu = (clone $statsQuery)->where('status', 'Menunggu Verifikasi')->count();
        $countTerverifikasi = (clone $statsQuery)->where('status', 'Terverifikasi')->count();
        $countDitolak = (clone $statsQuery)->where('status', 'Ditolak')->count();

        // Per-wilayah recap (only for Admin/Provinsi level)
        $rekapWilayah = [];
        if ($user->level != 'Operator Kabupaten/Kota') {
            $allCapaian = (clone $statsQuery)->get(['wilayah', 'status']);
            $grouped = $allCapaian->groupBy('wilayah');
            foreach ($grouped as $wil => $items) {
                $rekapWilayah[] = [
                    'wilayah'       => $wil ?: '-',
                    'menunggu'      => $items->where('status', 'Menunggu Verifikasi')->count(),
                    'terverifikasi' => $items->where('status', 'Terverifikasi')->count(),
                    'ditolak'       => $items->where('status', 'Ditolak')->count(),
                    'total'         => $items->count(),
                ];
            }
            usort($rekapWilayah, fn($a, $b) => strcmp($a['wilayah'], $b['wilayah']));
        }

        // Apply filter if exists
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $capaians = $query->orderBy('created_at', 'desc')->get();

        $tpbs = Tpb::orderByRaw('LENGTH(no_tpb) ASC, no_tpb ASC')->get();
        $targets = Target::all();
        $indikators = Indikator::where('status', 'Terverifikasi')->get();
        
        if ($user->level == 'Operator Kabupaten/Kota') {
            $userWilayah = '';
            if (str_contains(strtolower($user->wilayah), 'barito kuala')) {
                $userWilayah = 'Barito Kuala';
            } elseif (str_contains(strtolower($user->wilayah), 'banjar')) {
                $userWilayah = 'Banjar';
            } elseif (str_contains(strtolower($user->wilayah), 'tapin')) {
                $userWilayah = 'Tapin';
            }
            $rpjmds = Rpjmd::where('wilayah', $userWilayah)->get();
        } else {
            $rpjmds = Rpjmd::all();
        }

        $wilayahList = \App\Models\Wilayah::all();

        return view('capaian_kabupaten.index', compact(
            'capaians', 'tpbs', 'targets', 'indikators', 'rpjmds',
            'countMenunggu', 'countTerverifikasi', 'countDitolak', 'wilayahList', 'rekapWilayah'
        ));
    }

    public function store(Request $request)
    {
        $currentYear = (int)date('Y');
        $request->validate([
            'tpb_id' => 'required',
            'target_id' => 'required',
            'indikator_id' => 'required',
            'rpjmd_id' => 'required',
            'opd' => 'required',
            'year' => 'required|integer|min:' . ($currentYear - 4) . '|max:' . $currentYear,
            'capaian_manual' => 'required',
            'gap' => 'required',
            'kategori_capaian' => 'required|in:SS,SB,BB',
            'nama_dokumen' => 'nullable',
            'jenis_dokumen' => 'nullable',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $user = Auth::user();
        $tahunData = $this->mapCapaianToYearFields((int)$request->year, $request->capaian_manual);
        
        // Generate No Tiket: #DOC-tahun bulan tanggal urutan
        $date = Carbon::now()->format('Ymd');
        $count = CapaianKabupaten::whereDate('created_at', Carbon::today())->count() + 1;
        $no_tiket = '#DOC-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $filePaths = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('capaian_dokumen', $filename, 'public');
                $filePaths[] = $filename;
            }
        }

        $capaian = CapaianKabupaten::create([
            'no_tiket' => $no_tiket,
            'user_id' => $user->id,
            'wilayah' => $user->wilayah ?? '-',
            'tpb_id' => $request->tpb_id,
            'target_id' => $request->target_id,
            'indikator_id' => $request->indikator_id,
            'rpjmd_id' => $request->rpjmd_id,
            'opd' => $request->opd,
            'tahun_n4' => $tahunData['tahun_n4'],
            'tahun_n3' => $tahunData['tahun_n3'],
            'tahun_n2' => $tahunData['tahun_n2'],
            'tahun_n1' => $tahunData['tahun_n1'],
            'tahun_n' => $tahunData['tahun_n'],
            'gap' => $request->gap,
            'kategori_capaian' => $request->kategori_capaian,
            'nama_dokumen' => $request->nama_dokumen ?: '-',
            'jenis_dokumen' => $request->jenis_dokumen ?: '-',
            'tanggal_kirim' => Carbon::now(),
            'status' => 'Menunggu Verifikasi',
            'files' => json_encode($filePaths),
        ]);

        // Send Email Notification to both Kabupaten Operator and Province Operators
        try {
            $recipients = [$user->email];
            $provinsiEmails = \App\Models\User::where('level', 'Operator Provinsi')->pluck('email')->toArray();
            if (!empty($provinsiEmails)) {
                $recipients = array_merge($recipients, $provinsiEmails);
            }
            Mail::to($recipients)->send(new CapaianNotification($capaian));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Data Capaian berhasil dikirim.');
    }

    public function verify(Request $request, $id)
    {
        $capaian = CapaianKabupaten::with('user')->findOrFail($id);
        $capaian->update([
            'tanggal_terima' => Carbon::now(),
            'status' => 'Terverifikasi',
            'keterangan_verifikasi' => $request->keterangan_verifikasi
        ]);

        // Send Email Notification
        try {
            Mail::to($capaian->user->email)->send(new CapaianNotification($capaian));
        } catch (\Exception $e) { 
            \Illuminate\Support\Facades\Log::error('Mail Error (Verify): ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Data Capaian berhasil diverifikasi.');
    }

    public function reject(Request $request, $id)
    {
        $capaian = CapaianKabupaten::with('user')->findOrFail($id);
        $capaian->update([
            'status' => 'Ditolak',
            'keterangan_verifikasi' => $request->keterangan_verifikasi
        ]);

        // Send Email Notification
        try {
            Mail::to($capaian->user->email)->send(new CapaianNotification($capaian));
        } catch (\Exception $e) { 
            \Illuminate\Support\Facades\Log::error('Mail Error (Reject): ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Data Capaian telah ditolak dengan keterangan.');
    }

    public function edit($id)
    {
        $capaian = CapaianKabupaten::with(['tpb', 'target', 'indikator', 'rpjmd'])->findOrFail($id);
        return response()->json($capaian);
    }

    public function update(Request $request, $id)
    {
        $currentYear = (int)date('Y');
        $request->validate([
            'tpb_id' => 'required',
            'target_id' => 'required',
            'indikator_id' => 'required',
            'rpjmd_id' => 'required',
            'opd' => 'required',
            'year' => 'required|integer|min:' . ($currentYear - 4) . '|max:' . $currentYear,
            'capaian_manual' => 'required',
            'gap' => 'required',
            'kategori_capaian' => 'required|in:SS,SB,BB',
            'nama_dokumen' => 'nullable',
            'jenis_dokumen' => 'nullable',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $capaian = CapaianKabupaten::findOrFail($id);
        $tahunData = $this->mapCapaianToYearFields((int)$request->year, $request->capaian_manual);
        
        $filePaths = json_decode($capaian->files, true) ?: [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('capaian_dokumen', $filename, 'public');
                $filePaths[] = $filename;
            }
        }

        $capaian->update([
            'tpb_id' => $request->tpb_id,
            'target_id' => $request->target_id,
            'indikator_id' => $request->indikator_id,
            'rpjmd_id' => $request->rpjmd_id,
            'opd' => $request->opd,
            'tahun_n4' => $tahunData['tahun_n4'],
            'tahun_n3' => $tahunData['tahun_n3'],
            'tahun_n2' => $tahunData['tahun_n2'],
            'tahun_n1' => $tahunData['tahun_n1'],
            'tahun_n' => $tahunData['tahun_n'],
            'gap' => $request->gap,
            'kategori_capaian' => $request->kategori_capaian,
            'nama_dokumen' => $request->nama_dokumen ?: '-',
            'jenis_dokumen' => $request->jenis_dokumen ?: '-',
            'files' => json_encode($filePaths),
            'status' => 'Menunggu Verifikasi',
            'keterangan_verifikasi' => null,
            'tanggal_kirim' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Data Capaian berhasil diperbarui dan dikirim ulang untuk verifikasi.');
    }

    private function mapCapaianToYearFields(int $year, string $capaian): array
    {
        $currentYear = (int)date('Y');
        $offset = $currentYear - $year;
        $tahunFieldMap = [0 => 'tahun_n', 1 => 'tahun_n1', 2 => 'tahun_n2', 3 => 'tahun_n3', 4 => 'tahun_n4'];
        $tahunData = ['tahun_n' => '-', 'tahun_n1' => '-', 'tahun_n2' => '-', 'tahun_n3' => '-', 'tahun_n4' => '-'];

        if (isset($tahunFieldMap[$offset])) {
            $tahunData[$tahunFieldMap[$offset]] = $capaian;
        }

        return $tahunData;
    }

    public function destroy($id)
    {
        $capaian = CapaianKabupaten::findOrFail($id);
        
        // Delete files
        $files = json_decode($capaian->files, true);
        if ($files) {
            foreach ($files as $file) {
                Storage::delete('public/capaian_dokumen/' . $file);
            }
        }

        $capaian->delete();
        return redirect()->back()->with('success', 'Data Capaian berhasil dihapus.');
    }

    public function downloadTemplate(Request $request)
    {
        $year = (int)($request->year ?? date('Y'));
        $currentYear = (int)date('Y');
        $offset = $currentYear - $year;

        if ($offset < 0 || $offset > 4) {
            return back()->with('error', 'Tahun tidak valid. Pilih antara ' . ($currentYear - 4) . ' hingga ' . $currentYear . '.');
        }

        $indikators = Indikator::with('target.tpb')
            ->where('status', 'Terverifikasi')
            ->orderByRaw("LENGTH(no_indikator) ASC, no_indikator ASC")
            ->get();

        $spreadsheet = new Spreadsheet();

        // ===== Sheet 1: Input Capaian =====
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Input_Capaian_' . $year);

        // Row 1 — Title
        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', 'TEMPLATE INPUT CAPAIAN INDIKATOR TPB ' . $year . '  |  SI-PEMANTAU TPB  |  [NAMA KABUPATEN/KOTA]');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1A1A2E']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(28);

        // Row 2 — Info
        $sheet->mergeCells('A2:J2');
        $sheet->setCellValue('A2', 'Data target sudah diisi oleh Admin  ·  Anda HANYA perlu mengisi kolom biru (★ CAPAIAN ' . $year . ')  ·  GAP dan Status akan terhitung otomatis');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['color' => ['rgb' => '1E3A8A'], 'size' => 9],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EEF2FF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Row 3 — Column guide
        $sheet->setCellValue('A3', '★ Isi di sini');
        $sheet->mergeCells('C3:D3');
        $sheet->setCellValue('C3', 'Dari Admin - jangan ubah');
        $sheet->mergeCells('G3:H3');
        $sheet->setCellValue('G3', 'Otomatis (formula)');
        $sheet->setCellValue('I3', 'Opsional');
        $sheet->getStyle('A3:B3')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => '1E40AF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DBEAFE']]]);
        $sheet->getStyle('C3:D3')->applyFromArray(['font' => ['color' => ['rgb' => '166534']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D1FAE5']], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);
        $sheet->getStyle('G3:H3')->applyFromArray(['font' => ['color' => ['rgb' => '92400E']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFBEB']], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);
        $sheet->getStyle('I3:J3')->applyFromArray(['font' => ['color' => ['rgb' => '6B7280']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F9FAFB']]]);

        // Row 4 — Column Headers
        $headers = [
            'A' => 'No',
            'B' => 'Kode Indikator',
            'C' => "Nama Indikator\n(dari Admin - jangan ubah)",
            'D' => "Target Nasional\n(dari Admin - jangan ubah)",
            'E' => "★ CAPAIAN " . $year . "\n← ISI DI SINI",
            'F' => "Satuan\n(dari Admin)",
            'G' => "GAP\n(otomatis)",
            'H' => "STATUS\n(otomatis)",
            'I' => "Sumber Data\n(opsional)",
            'J' => "Catatan Tambahan\n(opsional)",
        ];
        foreach ($headers as $col => $label) {
            $sheet->setCellValue($col . '4', $label);
        }
        $sheet->getStyle('A4:D4')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F3364']], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true]]);
        $sheet->getStyle('E4')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E40AF']], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true]]);
        $sheet->getStyle('F4')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F3364']], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true]]);
        $sheet->getStyle('G4:H4')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '166534']], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true]]);
        $sheet->getStyle('I4:J4')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '92400E']], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER, 'wrapText' => true]]);
        $sheet->getRowDimension(4)->setRowHeight(38);

        // Rows 4+ — Data
        $row = 5;
        $no = 1;
        $currentPilar = null;
        $currentTpb = null;
        foreach ($indikators as $ind) {
            $tpb = optional(optional($ind->target)->tpb);
            $pilar = $tpb->pilar ?: 'PILAR TPB';
            $tpbLabel = trim(($tpb->no_tpb ? 'TPB ' . $tpb->no_tpb . ' - ' : '') . ($tpb->nama_tpb ?: 'Tanpa TPB'));

            if ($pilar !== $currentPilar) {
                $sheet->mergeCells('A' . $row . ':J' . $row);
                $sheet->setCellValue('A' . $row, '▌  ' . strtoupper($pilar));
                $sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1A6B3C']]]);
                $sheet->getRowDimension($row)->setRowHeight(24);
                $row++;
                $currentPilar = $pilar;
                $currentTpb = null;
            }

            if ($tpbLabel !== $currentTpb) {
                $sheet->mergeCells('A' . $row . ':J' . $row);
                $sheet->setCellValue('A' . $row, '    ' . $tpbLabel);
                $sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '27AE60']]]);
                $row++;
                foreach ($headers as $col => $label) {
                    $sheet->setCellValue($col . $row, str_replace(["\n(dari Admin - jangan ubah)", "\n(dari Admin)", "\n(otomatis)", "\n(opsional)", "\n← ISI DI SINI"], '', $label));
                }
                $sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '2C3E50']], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);
                $row++;
                $currentTpb = $tpbLabel;
            }

            $targetNasional = $ind->target_perpres59 ?: '-';
            $satuan = str_contains($targetNasional, '%') ? '%' : '-';

            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $ind->no_indikator);
            $sheet->setCellValue('C' . $row, $ind->nama_indikator_tpb);
            $sheet->setCellValue('D' . $row, $targetNasional);
            $sheet->setCellValue('F' . $row, $satuan);
            $sheet->setCellValue('G' . $row, '=IFERROR(NUMBERVALUE(SUBSTITUTE(D' . $row . ',"%",""))-NUMBERVALUE(E' . $row . '),"")');
            $sheet->setCellValue('H' . $row, '=IF(E' . $row . '="","",IF(G' . $row . '="","NA",IF(G' . $row . '<=0,"SS",IF(G' . $row . '<=10,"SB","BB"))))');

            $sheet->getStyle('E' . $row)->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => '003399']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DBEAFE']],
            ]);
            $sheet->getRowDimension($row)->setRowHeight(31);
            $row++;
        }

        // Column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(16);
        $sheet->getColumnDimension('C')->setWidth(62);
        $sheet->getColumnDimension('D')->setWidth(28);
        $sheet->getColumnDimension('E')->setWidth(16);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(12);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(28);
        $sheet->getColumnDimension('J')->setWidth(32);

        $lastRow = max(4, $row - 1);
        $sheet->getStyle('A4:J' . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB']
                ],
            ],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getStyle('A5:B' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('D5:H' . $lastRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('C5:C' . $lastRow)->getAlignment()->setWrapText(true);

        // Freeze pane below headers
        $sheet->freezePane('A5');

        // ===== Sheet 2: Rekap Status =====
        $rekap = $spreadsheet->createSheet();
        $rekap->setTitle('Rekap_Status');
        $rekap->mergeCells('A1:D1');
        $rekap->setCellValue('A1', 'REKAP STATUS CAPAIAN - SI-PEMANTAU TPB');
        $rekap->getStyle('A1')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1A1A2E']], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);
        $rekapRows = [
            ['Keterangan', 'Formula', 'Jumlah', 'Persentase'],
            ['Total Indikator Terisi', '=COUNTA(Input_Capaian_' . $year . '!E5:E' . $lastRow . ')-COUNTIF(Input_Capaian_' . $year . '!E5:E' . $lastRow . ',"")', '=B3', '=IFERROR(C3/' . max(1, $indikators->count()) . ',"")'],
            ['SS - Sudah Tercapai', '=COUNTIF(Input_Capaian_' . $year . '!H5:H' . $lastRow . ',"SS")', '=B4', '=IFERROR(C4/C3,"")'],
            ['SB - Belum Tercapai', '=COUNTIF(Input_Capaian_' . $year . '!H5:H' . $lastRow . ',"SB")', '=B5', '=IFERROR(C5/C3,"")'],
            ['BB - Belum Dilaksanakan', '=COUNTIF(Input_Capaian_' . $year . '!H5:H' . $lastRow . ',"BB")', '=B6', '=IFERROR(C6/C3,"")'],
            ['NA - Tidak Ada Data', '=COUNTIF(Input_Capaian_' . $year . '!H5:H' . $lastRow . ',"NA")', '=B7', '=IFERROR(C7/C3,"")'],
            ['Belum Diisi', '=COUNTBLANK(Input_Capaian_' . $year . '!E5:E' . $lastRow . ')', '=B8', '=IFERROR(C8/' . max(1, $indikators->count()) . ',"")'],
        ];
        foreach ($rekapRows as $idx => $values) {
            $r = $idx + 2;
            foreach (['A', 'B', 'C', 'D'] as $colIdx => $col) {
                $rekap->setCellValue($col . $r, $values[$colIdx]);
            }
        }
        $rekap->getStyle('A2:D2')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '166534']]]);
        $rekap->getStyle('A3:D8')->applyFromArray(['font' => ['color' => ['rgb' => '065F46']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D1FAE5']]]);
        foreach (['A' => 28, 'B' => 46, 'C' => 16, 'D' => 16] as $col => $width) {
            $rekap->getColumnDimension($col)->setWidth($width);
        }

        // ===== Sheet 3: Panduan =====
        $guide = $spreadsheet->createSheet();
        $guide->setTitle('Panduan_Upload');

        $guide->mergeCells('A1:C1');
        $guide->setCellValue('A1', 'PANDUAN UPLOAD EXCEL - SI-PEMANTAU TPB');
        $guide->getStyle('A1')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1A1A2E']], 'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]]);

        $guideRows = [
            ['section' => true,  'A' => 'UNTUK OPERATOR KAB/KOTA - Isi Kolom Capaian'],
            ['section' => false, 'A' => '→', 'B' => 'Buka sheet \'Input_Capaian_' . $year . '\''],
            ['section' => false, 'A' => '→', 'B' => 'Isi HANYA kolom E (★ CAPAIAN ' . $year . ') yang berwarna BIRU'],
            ['section' => false, 'A' => '→', 'B' => 'Numerik: ketik angka saja. Contoh: 74.60'],
            ['section' => false, 'A' => '→', 'B' => 'Dokumen: ketik Ada atau Belum'],
            ['section' => false, 'A' => '→', 'B' => 'Kolom GAP (G) dan STATUS (H) otomatis - JANGAN diubah'],
            ['section' => false, 'A' => '→', 'B' => 'Kolom I (Sumber Data) dan J (Catatan) boleh diisi atau dikosongkan'],
            ['section' => true,  'A' => 'UPLOAD KE SISTEM'],
            ['section' => false, 'A' => '→', 'B' => 'Simpan file: File → Save As → Excel Workbook (.xlsx)'],
            ['section' => false, 'A' => '→', 'B' => 'Buka SI-PEMANTAU TPB → menu Capaian Kab/Kota'],
            ['section' => false, 'A' => '→', 'B' => 'Pilih Tahun Data ' . $year . ' → Pilih file → Proses Upload'],
            ['section' => false, 'A' => '→', 'B' => 'Sistem membaca: kolom B (kode), E (capaian), I (sumber), J (catatan)'],
            ['section' => false, 'A' => '→', 'B' => 'Dashboard Evaluasi Kinerja terupdate otomatis setelah upload berhasil'],
        ];
        $gr = 2;
        foreach ($guideRows as $g) {
            if ($g['section']) {
                $guide->mergeCells('A' . $gr . ':C' . $gr);
                $guide->setCellValue('A' . $gr, $g['A']);
                $guide->getStyle('A' . $gr)->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1D4ED8']]]);
            } else {
                $guide->setCellValue('A' . $gr, $g['A']);
                $guide->setCellValue('B' . $gr, $g['B'] ?? '');
                $guide->setCellValue('C' . $gr, $g['C'] ?? '');
            }
            $gr++;
        }
        foreach (['A', 'B', 'C'] as $c) {
            $guide->getColumnDimension($c)->setAutoSize(true);
        }

        $spreadsheet->setActiveSheetIndex(0);

        $fileName = 'template_capaian_' . $year . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        header('Cache-Control: max-age=0');
        (new Xlsx($spreadsheet))->save('php://output');
        exit;
    }

    public function importExcel(Request $request)
    {
        $currentYear = (int)date('Y');
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'year' => 'required|integer|min:' . ($currentYear - 4) . '|max:' . $currentYear,
        ]);

        $user        = Auth::user();
        $importYear  = (int)$request->year;
        $offset      = $currentYear - $importYear;

        // Map offset → DB column name
        $tahunFieldMap = [0 => 'tahun_n', 1 => 'tahun_n1', 2 => 'tahun_n2', 3 => 'tahun_n3', 4 => 'tahun_n4'];
        $tahunField    = $tahunFieldMap[$offset];

        $spreadsheet = IOFactory::load($request->file('file')->getPathname());
        $rows        = $spreadsheet->getActiveSheet()->toArray();

        $successCount = 0;
        $failedCount  = 0;
        $errors       = [];
        $validRows    = [];

        // Data starts after the title/header rows. Section rows and repeated headers are skipped.
        for ($i = 4; $i < count($rows); $i++) {
            $row        = $rows[$i];
            $noIndikator = trim($row[1] ?? ''); // Column B
            $capaian    = trim($row[4] ?? '');  // Column E
            $gapImport  = trim($row[6] ?? '');  // Column G (automatic)
            $statusImport = strtoupper(trim($row[7] ?? '')); // Column H (automatic)
            $sumberData = trim($row[8] ?? '');  // Column I (optional)
            $catatan    = trim($row[9] ?? '');  // Column J (optional)

            // Skip blank rows
            if (empty($noIndikator) && empty($capaian)) {
                continue;
            }

            if ($noIndikator === 'Kode Indikator' || str_starts_with($noIndikator, 'TPB ')) {
                continue;
            }

            if (empty($capaian)) {
                // No capaian value — skip silently
                continue;
            }

            $indikator = Indikator::where('no_indikator', $noIndikator)
                ->where('status', 'Terverifikasi')
                ->first();

            if (!$indikator) {
                $failedCount++;
                $errors[] = "Baris " . ($i + 1) . ": Kode Indikator '$noIndikator' tidak ditemukan atau belum terverifikasi.";
                continue;
            }

            $target = $indikator->target;
            $gap = $gapImport !== '' ? $gapImport : $this->calculateGap($indikator->target_perpres59, $capaian);
            $statusCapaian = in_array($statusImport, ['SS', 'SB', 'BB'], true)
                ? $statusImport
                : $this->statusFromGap($gap, $capaian);

            $validRows[] = [
                'indikator_id' => $indikator->id,
                'target_id'    => $indikator->target_id,
                'tpb_id'       => $target ? $target->tpb_id : null,
                'capaian'      => $capaian,
                'gap'          => $gap,
                'status_capaian' => $statusCapaian,
                'sumber_data'  => $sumberData,
                'catatan_imp'  => $catatan,
            ];
        }

        if (!empty($validRows)) {
            // Wipe all existing capaian for this user
            CapaianKabupaten::where('user_id', $user->id)->delete();

            $date = Carbon::now()->format('Ymd');

            foreach ($validRows as $idx => $vRow) {
                $no_tiket = '#XLS-' . $importYear . '-' . $date . '-' . str_pad($idx + 1, 3, '0', STR_PAD_LEFT);

                // Set capaian to the correct year field, rest are '-'
                $tahunData = ['tahun_n' => '-', 'tahun_n1' => '-', 'tahun_n2' => '-', 'tahun_n3' => '-', 'tahun_n4' => '-'];
                $tahunData[$tahunField] = $vRow['capaian'];

                CapaianKabupaten::create([
                    'no_tiket'        => $no_tiket,
                    'user_id'         => $user->id,
                    'wilayah'         => $user->wilayah ?? '-',
                    'tpb_id'          => $vRow['tpb_id'],
                    'target_id'       => $vRow['target_id'],
                    'indikator_id'    => $vRow['indikator_id'],
                    'rpjmd_id'        => null,
                    'opd'             => $user->dinas ?? '-',
                    'tahun_n4'        => $tahunData['tahun_n4'],
                    'tahun_n3'        => $tahunData['tahun_n3'],
                    'tahun_n2'        => $tahunData['tahun_n2'],
                    'tahun_n1'        => $tahunData['tahun_n1'],
                    'tahun_n'         => $tahunData['tahun_n'],
                    'gap'             => $vRow['gap'],
                    'kategori_capaian'=> $vRow['status_capaian'],
                    'nama_dokumen'    => $vRow['sumber_data'] ?: 'Import Excel ' . $importYear,
                    'jenis_dokumen'   => $vRow['catatan_imp'] ?: 'Excel',
                    'tanggal_kirim'   => Carbon::now(),
                    'status'          => 'Menunggu Verifikasi',
                    'files'           => json_encode([]),
                ]);

                $successCount++;
            }
        }

        $request->session()->put('import_capaian_summary', [
            'success' => $successCount,
            'failed'  => $failedCount,
            'year'    => $importYear,
            'field'   => $tahunField,
            'errors'  => $errors,
        ]);

        return redirect()->back()->with('success', 'Import capaian selesai. ' . $successCount . ' data berhasil diimport untuk tahun ' . $importYear . '.');
    }

    private function calculateGap($target, $capaian): string
    {
        $targetValue = $this->parseNumericValue($target);
        $capaianValue = $this->parseNumericValue($capaian);

        if ($targetValue === null || $capaianValue === null) {
            return '-';
        }

        return (string)round($targetValue - $capaianValue, 2);
    }

    private function statusFromGap($gap, $capaian): string
    {
        $gapValue = $this->parseNumericValue($gap);
        $capaianValue = $this->parseNumericValue($capaian);

        if ($gapValue === null || $capaianValue === null) {
            return 'BB';
        }

        if ($gapValue <= 0) {
            return 'SS';
        }

        return $gapValue <= 10 ? 'SB' : 'BB';
    }

    private function parseNumericValue($value): ?float
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string)$value);
        if ($value === '' || $value === '-') {
            return null;
        }

        $normalized = str_replace(',', '.', $value);
        if (preg_match('/-?\d+(?:\.\d+)?/', $normalized, $matches)) {
            return (float)$matches[0];
        }

        return null;
    }

    public function bulkAction(Request $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->back()->with('error', 'Pilih data terlebih dahulu.');
        }

        if ($action === 'verify') {
            CapaianKabupaten::whereIn('id', $ids)
                ->where('status', 'Menunggu Verifikasi')
                ->update([
                    'status' => 'Terverifikasi',
                    'tanggal_terima' => \Carbon\Carbon::now(),
                    'keterangan_verifikasi' => $request->input('keterangan_verifikasi') ?: 'Diverifikasi secara massal'
                ]);
            return redirect()->back()->with('success', 'Data capaian terpilih berhasil diverifikasi.');
        }

        if ($action === 'reject') {
            CapaianKabupaten::whereIn('id', $ids)
                ->where('status', 'Menunggu Verifikasi')
                ->update([
                    'status' => 'Ditolak',
                    'keterangan_verifikasi' => $request->input('keterangan_verifikasi') ?: 'Ditolak secara massal'
                ]);
            return redirect()->back()->with('success', 'Data capaian terpilih berhasil ditolak.');
        }

        if ($action === 'delete') {
            $capaians = CapaianKabupaten::whereIn('id', $ids)->get();
            foreach ($capaians as $capaian) {
                $files = json_decode($capaian->files, true);
                if ($files) {
                    foreach ($files as $file) {
                        \Illuminate\Support\Facades\Storage::delete('public/capaian_dokumen/' . $file);
                    }
                }
                $capaian->delete();
            }
            return redirect()->back()->with('success', 'Data capaian terpilih berhasil dihapus.');
        }

        return redirect()->back()->with('error', 'Aksi tidak valid.');
    }
}
