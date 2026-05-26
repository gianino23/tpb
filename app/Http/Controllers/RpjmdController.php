<?php

namespace App\Http\Controllers;

use App\Models\Tpb;
use App\Models\Target;
use App\Models\Indikator;
use App\Models\Rpjmd;
use App\Models\Capaian;
use App\Models\CapaianKabupaten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class RpjmdController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Rpjmd::with('indikator');

        if ($user->level == 'Operator Kabupaten/Kota') {
            $userWilayah = '';
            if (str_contains(strtolower($user->wilayah), 'barito kuala')) {
                $userWilayah = 'Barito Kuala';
            } elseif (str_contains(strtolower($user->wilayah), 'banjar')) {
                $userWilayah = 'Banjar';
            } elseif (str_contains(strtolower($user->wilayah), 'tapin')) {
                $userWilayah = 'Tapin';
            }
            $query->where('wilayah', $userWilayah);
        } else {
            if ($request->wilayah) {
                $cleanReq = str_replace(['Kabupaten ', 'Kab. ', 'Kota ', 'kabupaten ', 'kota '], '', $request->wilayah);
                $query->where('wilayah', 'LIKE', '%' . $cleanReq . '%');
            }
        }

        $rpjmds = $query->get();

        // Ambil semua data indikator untuk dropdown relasi RPJMD
        $indikators = Indikator::orderByRaw("LENGTH(no_indikator) ASC, no_indikator ASC")->get();
        
        $wilayahList = \App\Models\Wilayah::all();

        //return view with data
        return view('rpjmd.index', compact('rpjmds', 'indikators', 'wilayahList'));
    }

    public function list($id)
    {
        $id=Crypt::decryptString($id);
        $rpjmds = Rpjmd::findOrFail($id);
        return view('rpjmd.list', compact('rpjmds'));
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->level == 'Operator Kabupaten/Kota') {
            $userWilayah = '';
            if (str_contains(strtolower($user->wilayah), 'barito kuala')) {
                $userWilayah = 'Barito Kuala';
            } elseif (str_contains(strtolower($user->wilayah), 'banjar')) {
                $userWilayah = 'Banjar';
            } elseif (str_contains(strtolower($user->wilayah), 'tapin')) {
                $userWilayah = 'Tapin';
            }
            $request->merge(['wilayah' => $userWilayah]);
        }

        //define validation rules
        $validator = Validator::make($request->all(), [
            'wilayah'              => 'required',
            'no_indikator_rpjmd'   => 'required',
            'indikator_kinerja'    => 'required',
            'spm'                  => 'required',
            'jenis_urusan'         => 'required',
            'kategori_urusan'      => 'required',
            'kekhususan_indikator' => 'required',
            'referensi'            => 'required',
            'indikator_sama'       => 'nullable',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

        if ($request->indikator_sama && $request->indikator_sama !== '-') {
            $exists = Indikator::where('no_indikator', $request->indikator_sama)->exists();
            if (!$exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Error',
                    'errors'  => ['indikator_sama' => ['Kode Indikator Sama tidak ditemukan di Data Target.']]
                ], 422);
            }
        }

        //create post
        $rpjmd = Rpjmd::create([
            'wilayah'              => $request->wilayah,
            'no_indikator_rpjmd'   => $request->no_indikator_rpjmd,
            'indikator_kinerja'    => $request->indikator_kinerja,
            'spm'                  => $request->spm, 
            'jenis_urusan'         => $request->jenis_urusan, 
            'kategori_urusan'      => $request->kategori_urusan, 
            'kekhususan_indikator' => $request->kekhususan_indikator, 
            'referensi'            => $request->referensi, 
            'indikator_sama'       => $request->indikator_sama ?? '-',
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $rpjmd
        ]);
    }

    public function show($id)
    {
        //return response
        $rpjmd = Rpjmd::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Target',
            'data'    => $rpjmd
        ]); 
    }

    public function update(Request $request, $id)
    {
        $rpjmd = Rpjmd::findOrFail($id);
        $user = Auth::user();
        if ($user->level == 'Operator Kabupaten/Kota') {
            $userWilayah = '';
            if (str_contains(strtolower($user->wilayah), 'barito kuala')) {
                $userWilayah = 'Barito Kuala';
            } elseif (str_contains(strtolower($user->wilayah), 'banjar')) {
                $userWilayah = 'Banjar';
            } elseif (str_contains(strtolower($user->wilayah), 'tapin')) {
                $userWilayah = 'Tapin';
            }
            $request->merge(['wilayah' => $userWilayah]);

            if ($rpjmd->wilayah !== $userWilayah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk mengubah data wilayah ini.'
                ], 403);
            }
        }

        //define validation rules
        $validator = Validator::make($request->all(), [
            'wilayah'              => 'required',
            'no_indikator_rpjmd'   => 'required',
            'indikator_kinerja'    => 'required',
            'spm'                  => 'required',
            'jenis_urusan'         => 'required',
            'kategori_urusan'      => 'required',
            'kekhususan_indikator' => 'required',
            'referensi'            => 'required',
            'indikator_sama'       => 'nullable',
        ]);
        
        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

        if ($request->indikator_sama && $request->indikator_sama !== '-') {
            $exists = Indikator::where('no_indikator', $request->indikator_sama)->exists();
            if (!$exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation Error',
                    'errors'  => ['indikator_sama' => ['Kode Indikator Sama tidak ditemukan di Data Target.']]
                ], 422);
            }
        }

        //update post
        $rpjmd->update([
            'wilayah'              => $request->wilayah,
            'no_indikator_rpjmd'   => $request->no_indikator_rpjmd,
            'indikator_kinerja'    => $request->indikator_kinerja,
            'spm'                  => $request->spm, 
            'jenis_urusan'         => $request->jenis_urusan, 
            'kategori_urusan'      => $request->kategori_urusan, 
            'kekhususan_indikator' => $request->kekhususan_indikator, 
            'referensi'            => $request->referensi, 
            'indikator_sama'       => $request->indikator_sama ?? '-',
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dirubah !',
            'data'    => $rpjmd
        ]);
    }

    public function destroy($id)
    {
        $rpjmd = Rpjmd::findOrFail($id);
        $user = Auth::user();
        if ($user->level == 'Operator Kabupaten/Kota') {
            $userWilayah = '';
            if (str_contains(strtolower($user->wilayah), 'barito kuala')) {
                $userWilayah = 'Barito Kuala';
            } elseif (str_contains(strtolower($user->wilayah), 'banjar')) {
                $userWilayah = 'Banjar';
            } elseif (str_contains(strtolower($user->wilayah), 'tapin')) {
                $userWilayah = 'Tapin';
            }
            if ($rpjmd->wilayah !== $userWilayah) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses untuk menghapus data wilayah ini.'
                ], 403);
            }
        }

        $rpjmd->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]); 
    }

    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Import RPJMD');

        // Main Title
        $sheet->setCellValue('A1', 'TEMPLATE UPLOAD EXCEL — DATA RPJMD | SI-PEMANTAU TPB (E-TPB)');
        // Row 2 Instructions
        $sheet->setCellValue('A2', '[PROGRAMMER ] Baris 4 = nama field API/database (api_key). Baris 5 = label tampilan. Baris 6 = tipe data. Data aktual mulai baris 8. Diisi oleh: Operator Kabupaten/Kota. Akses dibatasi per wilayah.');
        // Row 3 Instructions
        $sheet->setCellValue('A3', '[OPERATOR KAB/KOTA ] Kolom wajib (header gelap). Kolom opsional boleh dikosongkan. Dropdown tersedia di kolom Wilayah, Jenis Urusan, dan Kategori Urusan. Hapus baris CONTOH (baris 7) sebelum upload.');
        
        // Row 4 - API Keys
        $sheet->setCellValue('A4', 'wilayah');
        $sheet->setCellValue('B4', 'no_indikator_rpjmd');
        $sheet->setCellValue('C4', 'nama_indikator_kinerja');
        $sheet->setCellValue('D4', 'spm');
        $sheet->setCellValue('E4', 'jenis_urusan');
        $sheet->setCellValue('F4', 'kategori_urusan');
        $sheet->setCellValue('G4', 'kekhususan_indikator');
        $sheet->setCellValue('H4', 'referensi');
        $sheet->setCellValue('I4', 'indikator_sama');

        // Row 5 - Display Labels
        $sheet->setCellValue('A5', 'WILAYAH (Kab/Kota)');
        $sheet->setCellValue('B5', 'NOMOR INDIKATOR RPJMD');
        $sheet->setCellValue('C5', 'NAMA INDIKATOR KINERJA');
        $sheet->setCellValue('D5', 'SPM (Standar Pelayanan Minimal)');
        $sheet->setCellValue('E5', 'JENIS URUSAN');
        $sheet->setCellValue('F5', 'KATEGORI URUSAN');
        $sheet->setCellValue('G5', 'KEKHUSUSAN INDIKATOR');
        $sheet->setCellValue('H5', 'REFERENSI (Dasar Hukum)');
        $sheet->setCellValue('I5', 'INDIKATOR SAMA (Kode TPB)');

        // Row 6 - Data Types
        $sheet->setCellValue('A6', 'ENUM REQUIRED');
        $sheet->setCellValue('B6', 'INT REQUIRED');
        $sheet->setCellValue('C6', 'TEXT REQUIRED');
        $sheet->setCellValue('D6', 'TEXT NULLABLE');
        $sheet->setCellValue('E6', 'VARCHAR(50) REQUIRED');
        $sheet->setCellValue('F6', 'VARCHAR(100) REQUIRED');
        $sheet->setCellValue('G6', 'TEXT NULLABLE');
        $sheet->setCellValue('H6', 'TEXT NULLABLE');
        $sheet->setCellValue('I6', 'VARCHAR(50) NULLABLE');

        // Row 7 - Example data
        $sheet->setCellValue('A7', 'Kabupaten Barito Kuala');
        $sheet->setCellValue('B7', '1');
        $sheet->setCellValue('C7', 'Persentase RT yang memiliki akses layanan sumber air minum layak dan berkelanjutan');
        $sheet->setCellValue('D7', 'SPM Bidang Pekerjaan Umum dan Penataan Ruang');
        $sheet->setCellValue('E7', 'Urusan Wajib');
        $sheet->setCellValue('F7', 'Lingkungan Hidup');
        $sheet->setCellValue('G7', 'Berlaku untuk daerah dengan kawasan lahan basah (Kab. Barito Kuala)');
        $sheet->setCellValue('H7', 'Permendagri No.7 Tahun 2018 | Perpres No.59 Tahun 2017');
        $sheet->setCellValue('I7', '6.1.1.(a)');

        // Row 8 - Start message
        $sheet->setCellValue('A8', '▼ MULAI ISI DATA DI BAWAH BARIS INI ▼');

        // Styling
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');
        $sheet->mergeCells('A8:I8');

        $styleTitle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '0F4C81']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ];
        $sheet->getStyle('A1:I1')->applyFromArray($styleTitle);

        $styleInstruct1 = [
            'font' => ['bold' => true, 'color' => ['rgb' => '9ED5FF'], 'size' => 10],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '0D3C66']]
        ];
        $sheet->getStyle('A2:I2')->applyFromArray($styleInstruct1);

        $styleInstruct2 = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFE57F'], 'size' => 10],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '0A2F50']]
        ];
        $sheet->getStyle('A3:I3')->applyFromArray($styleInstruct2);

        $styleAPIKey = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 9],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '333333']]
        ];
        $sheet->getStyle('A4:I4')->applyFromArray($styleAPIKey);

        // Header column styling
        $sheet->getStyle('A5')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1B5E20']]]);
        $sheet->getStyle('B5')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '0D47A1']]]);
        $sheet->getStyle('C5')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'BF360C']]]);
        $sheet->getStyle('D5')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E65100']]]);
        $sheet->getStyle('E5')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '0D47A1']]]);
        $sheet->getStyle('F5')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1A237E']]]);
        $sheet->getStyle('G5')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1B5E20']]]);
        $sheet->getStyle('H5')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '2E7D32']]]);
        $sheet->getStyle('I5')->applyFromArray(['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E65100']]]);

        $styleTypes = [
            'font' => ['italic' => true, 'color' => ['rgb' => '666666'], 'size' => 9],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER]
        ];
        $sheet->getStyle('A6:I6')->applyFromArray($styleTypes);

        $styleStart = [
            'font' => ['bold' => true, 'color' => ['rgb' => '000000']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E1F2']]
        ];
        $sheet->getStyle('A8:I8')->applyFromArray($styleStart);

        foreach (range('A', 'I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'template_import_rpjmd.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName) .'"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $successCount = 0;
        $failedCount = 0;
        $errors = [];

        $user = Auth::user();
        $userWilayah = '';
        if ($user->level == 'Operator Kabupaten/Kota') {
            if (str_contains(strtolower($user->wilayah), 'barito kuala')) {
                $userWilayah = 'Barito Kuala';
            } elseif (str_contains(strtolower($user->wilayah), 'banjar')) {
                $userWilayah = 'Banjar';
            } elseif (str_contains(strtolower($user->wilayah), 'tapin')) {
                $userWilayah = 'Tapin';
            }
        }

        $validRows = [];

        for ($i = 7; $i < count($rows); $i++) {
            $row = $rows[$i];
            
            $wilayahRaw = trim($row[0] ?? '');
            $noIndikatorRpjmd = trim($row[1] ?? '');
            
            // Skip empty rows
            if (empty($wilayahRaw) && empty($noIndikatorRpjmd) && empty($row[2])) {
                continue;
            }

            if (str_contains($wilayahRaw, 'MULAI ISI DATA') || str_contains($noIndikatorRpjmd, 'MULAI ISI DATA')) {
                continue;
            }

            $indikatorKinerja = trim($row[2] ?? '');
            $spm = trim($row[3] ?? '');
            $jenisUrusan = trim($row[4] ?? '');
            $kategoriUrusan = trim($row[5] ?? '');
            $kekhususanIndikator = trim($row[6] ?? '');
            $referensi = trim($row[7] ?? '');
            $indikatorSama = trim($row[8] ?? '');

            // Validate Wilayah
            $rowWilayah = '';
            if (str_contains(strtolower($wilayahRaw), 'barito kuala')) {
                $rowWilayah = 'Barito Kuala';
            } elseif (str_contains(strtolower($wilayahRaw), 'banjar')) {
                $rowWilayah = 'Banjar';
            } elseif (str_contains(strtolower($wilayahRaw), 'tapin')) {
                $rowWilayah = 'Tapin';
            }

            if (empty($rowWilayah)) {
                $failedCount++;
                $errors[] = "Baris " . ($i+1) . ": Wilayah '$wilayahRaw' tidak valid. Pilihan: Banjar, Barito Kuala, Tapin.";
                continue;
            }

            if ($user->level == 'Operator Kabupaten/Kota' && $rowWilayah !== $userWilayah) {
                $failedCount++;
                $errors[] = "Baris " . ($i+1) . ": Wilayah '$wilayahRaw' tidak sesuai dengan wilayah Anda ($userWilayah).";
                continue;
            }

            // Validate Required Columns
            if (empty($noIndikatorRpjmd) || empty($indikatorKinerja) || empty($jenisUrusan) || empty($kategoriUrusan)) {
                $failedCount++;
                $errors[] = "Baris " . ($i+1) . ": Kolom WILAYAH, NOMOR INDIKATOR RPJMD, NAMA INDIKATOR KINERJA, JENIS URUSAN, dan KATEGORI URUSAN tidak boleh kosong.";
                continue;
            }

            // Validate Indikator Sama relation if not empty
            if (!empty($indikatorSama) && $indikatorSama !== '-') {
                $exists = Indikator::where('no_indikator', $indikatorSama)->exists();
                if (!$exists) {
                    $failedCount++;
                    $errors[] = "Baris " . ($i+1) . ": Kode Indikator Sama '$indikatorSama' tidak ditemukan di Data Target.";
                    continue;
                }
            }

            $validRows[] = [
                'wilayah' => $rowWilayah,
                'no_indikator_rpjmd' => $noIndikatorRpjmd,
                'indikator_kinerja' => $indikatorKinerja,
                'spm' => $spm ?: '-',
                'jenis_urusan' => $jenisUrusan,
                'kategori_urusan' => $kategoriUrusan,
                'kekhususan_indikator' => $kekhususanIndikator ?: '-',
                'referensi' => $referensi ?: '-',
                'indikator_sama' => $indikatorSama ?: '-',
            ];
        }

        // Jika terdapat data yang valid untuk diimport
        if (!empty($validRows)) {
            $wilayahsToWipe = array_unique(array_column($validRows, 'wilayah'));

            // Dapatkan ID RPJMD yang akan dihapus
            $rpjmdIdsToWipe = Rpjmd::whereIn('wilayah', $wilayahsToWipe)->pluck('id');

            if ($rpjmdIdsToWipe->count() > 0) {
                // Hapus data capaian berelasi
                Capaian::whereIn('rpjmd_id', $rpjmdIdsToWipe)->delete();
                CapaianKabupaten::whereIn('rpjmd_id', $rpjmdIdsToWipe)->delete();
                
                // Hapus data RPJMD lama
                Rpjmd::whereIn('id', $rpjmdIdsToWipe)->delete();
            }

            // Simpan seluruh data baru
            foreach ($validRows as $validRow) {
                Rpjmd::create($validRow);
                $successCount++;
            }
        }

        $request->session()->put('import_summary', [
            'success' => $successCount,
            'warning' => 0,
            'failed'  => $failedCount,
            'errors'  => $errors
        ]);

        return redirect()->back()->with('success', 'Proses import selesai.');
    }
}

