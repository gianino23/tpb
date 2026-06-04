<?php

namespace App\Http\Controllers;

use App\Models\Target;
use App\Models\Tpb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class TargetController extends Controller
{
    public function index()
    {
        $targets = Target::with('tpb')
            ->when(request('pilar'), function ($q) {
                return $q->whereHas('tpb', function ($q2) {
                    $q2->where('pilar', request('pilar'));
                });
            })
            ->get()
            ->sortBy('no_target', SORT_NATURAL)
            ->values();

        $tpbs = Tpb::all();
        $pilars = Tpb::select('pilar')->distinct()->orderBy('pilar')->pluck('pilar');

        //return view with data
        return view('target.index', compact('targets', 'tpbs', 'pilars'));
    }

    public function list($id)
    {
        $id=Crypt::decryptString($id);
        $targets = Target::findOrFail($id);
        return view('target.list', compact('targets'));
    }
    
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'tpb_id'      => 'required',
            'no_target'   => 'required',
            'nama_target'   => 'required',
        ]);
        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

        //create post
        $target = Target::create([
            'tpb_id'        => $request->tpb_id,
            'no_target'     => $request->no_target,
            'nama_target'     => $request->nama_target, 
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $target
        ]);
    }

    public function show($id)
    {
        //return response
        $target = Target::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Target',
            'data'    => $target
        ]); 
    }

    public function update(Request $request, $id)
    {
        $target = Target::findOrFail($id);
        //define validation rules
        $validator = Validator::make($request->all(), [
            'tpb_id'      => 'required',
            'no_target'   => 'required',
            'nama_target' => 'required',
        ]);
        
        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }
        //create post
        $target->update([
            'tpb_id'      => $request->tpb_id,
            'no_target'   => $request->no_target, 
            'nama_target'     => $request->nama_target, 
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dirubah !',
            'data'    => $target
        ]);
    }

    public function destroy($id)
    {
        //delete pimpinan by ID
        Target::where('id', $id)->delete();

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
        $sheet->setTitle('Template Import Indikator');

        // Header baris 1 - Judul
        $sheet->setCellValue('A1', 'TEMPLATE UPLOAD EXCEL — DATA INDIKATOR (E-TPB)');
        $sheet->mergeCells('A1:C1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        // Header baris 2 - Petunjuk
        $sheet->setCellValue('A2', 'Isi kolom A (No TPB) dengan kode TPB yang sudah terdaftar di master TPB. Data dimulai dari baris ke-4.');
        $sheet->mergeCells('A2:C2');

        // Header baris 3 - Nama Kolom
        $sheet->setCellValue('A3', 'NO TPB');
        $sheet->setCellValue('B3', 'NO INDIKATOR');
        $sheet->setCellValue('C3', 'NAMA INDIKATOR');

        // Style header
        $headerStyle = $sheet->getStyle('A3:C3');
        $headerStyle->getFont()->setBold(true);
        $headerStyle->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $headerStyle->getFill()->getStartColor()->setRGB('4472C4');
        $headerStyle->getFont()->getColor()->setRGB('FFFFFF');

        // Baris contoh
        $sheet->setCellValue('A4', 'TPB 1');
        $sheet->setCellValue('B4', '1.1');
        $sheet->setCellValue('C4', 'Contoh Nama Target');

        // Auto width kolom
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);

        // Download
        $filename = 'template_import_indikator.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit;
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => [
                    'required',
                    function ($attribute, $value, $fail) {
                        if (!$value instanceof \Illuminate\Http\UploadedFile) {
                            $fail('File tidak valid.');
                            return;
                        }
                        $extension = strtolower($value->getClientOriginalExtension());
                        if (!in_array($extension, ['xlsx', 'xls'])) {
                            $fail('File harus berupa dokumen Excel (.xlsx atau .xls).');
                        }
                    },
                ],
            ]);

            $file = $request->file('file');

            // Pastikan tidak timeout untuk file besar
            set_time_limit(300);

            Log::info('Import Target dimulai', [
                'filename' => $file->getClientOriginalName(),
                'size'     => $file->getSize(),
            ]);

            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet   = $spreadsheet->getActiveSheet();
            $rows        = $worksheet->toArray();
            $rowCount    = count($rows);

            Log::info("File Excel berhasil dibaca. Total baris: {$rowCount}");

            $successCount = 0;
            $skippedCount = 0;
            $failedCount  = 0;
            $errors       = [];
            $warnings     = [];

            for ($i = 3; $i < $rowCount; $i++) {
                $row = $rows[$i];

                if (!is_array($row)) {
                    continue;
                }

                $noTpb    = trim($row[0] ?? '');
                $noTarget = trim($row[1] ?? '');
                $namaTarget = trim($row[2] ?? '');

                // Skip baris kosong
                if ($noTarget === '' && $namaTarget === '') {
                    continue;
                }

                // Validasi: No TPB harus diisi
                if ($noTpb === '') {
                    $failedCount++;
                    $errors[] = "Baris " . ($i + 1) . ": Kolom A (No TPB) tidak boleh kosong.";
                    continue;
                }

                // Validasi: No Target harus diisi
                if ($noTarget === '') {
                    $failedCount++;
                    $errors[] = "Baris " . ($i + 1) . ": Kolom B (No Target) tidak boleh kosong.";
                    continue;
                }

                // Validasi: Nama Target harus diisi
                if ($namaTarget === '') {
                    $failedCount++;
                    $errors[] = "Baris " . ($i + 1) . ": Kolom C (Nama Target) tidak boleh kosong.";
                    continue;
                }

                // Cari TPB berdasarkan no_tpb (handle format "TPB 1" atau "1")
                $searchTpb = $noTpb;
                // Jika user input hanya angka, tambahkan prefix "TPB "
                if (is_numeric($noTpb)) {
                    $searchTpb = 'TPB ' . $noTpb;
                }
                $tpb = Tpb::where('no_tpb', $searchTpb)->first();
                if (!$tpb) {
                    $failedCount++;
                    $errors[] = "Baris " . ($i + 1) . ": No TPB '$noTpb' tidak ditemukan di master data TPB.";
                    continue;
                }

                // Cek apakah No Target sudah ada
                $existingTarget = Target::where('no_target', $noTarget)->first();
                if ($existingTarget) {
                    $skippedCount++;
                    $warnings[] = "Baris " . ($i + 1) . ": No Target '$noTarget' sudah ada, dilewati.";
                    continue;
                }

                // Simpan data target baru
                Target::create([
                    'tpb_id'      => $tpb->id,
                    'no_target'   => $noTarget,
                    'nama_target' => $namaTarget,
                ]);

                $successCount++;
            }

            Log::info("Import Target selesai. Berhasil: {$successCount}, Dilewati: {$skippedCount}, Gagal: {$failedCount}");

            return redirect()->route('target.index')
                ->with('success', "Import selesai. Berhasil: {$successCount}, Dilewati: {$skippedCount}, Gagal: {$failedCount}.")
                ->with('import_summary', [
                    'success'  => $successCount,
                    'skipped'  => $skippedCount,
                    'failed'   => $failedCount,
                    'errors'   => $errors,
                    'warnings' => $warnings,
                ]);

        } catch (\Exception $e) {
            Log::error('Import Target error: ' . $e->getMessage(), [
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
