<?php

namespace App\Http\Controllers;

use App\Models\Tpb;
use App\Models\Target;
use App\Models\Indikator;
use App\Models\Capaian;
use App\Models\CapaianKabupaten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class IndikatorController extends Controller
{
    public function index()
    {
        $indikators = Indikator::with('target')->get();
        $targets = Target::all()->sortBy('no_target', SORT_NATURAL)->values();

        //return view with data
        return view('indikator.index', compact('indikators', 'targets'));
    }

    public function list($id)
    {
        $id=Crypt::decryptString($id);
        $indikators = Indikator::findOrFail($id);
        return view('indikator.list', compact('indikators'));
    }
    
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'target_id'   => 'required',
            'target_rpjmd'   => 'required',
            'dokumen_pendukung'   => 'required',
            'catatan'   => 'required',
            'target_perpres59'   => 'required',
            'ringkasan_target_perpres59'   => 'required',
            'kewenangan_kabupaten'   => 'required',
            'kewenangan_kota'   => 'required',
        ]);
        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $target_rel = Target::find($request->target_id);

        //create post
        $indikator = Indikator::create([
            'target_id'          => $request->target_id,
            'no_indikator'       => $target_rel ? $target_rel->no_target : '',
            'nama_indikator_tpb' => $target_rel ? $target_rel->nama_target : '',
            'indikator_rpjmd'    => $target_rel ? $target_rel->nama_target : '', 
            'target_rpjmd'     => $request->target_rpjmd, 
            'dokumen_pendukung'     => $request->dokumen_pendukung, 
            'catatan'     => $request->catatan, 
            'target_perpres59'     => $request->target_perpres59, 
            'ringkasan_target_perpres59'     => $request->ringkasan_target_perpres59, 
            'kewenangan_kabupaten'     => $request->kewenangan_kabupaten, 
            'kewenangan_kota'     => $request->kewenangan_kota, 
            'user_id'            => Auth::id(),
            'status'             => 'Terverifikasi',
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $indikator
        ]);
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
        $warningCount = 0;
        $failedCount = 0;
        $errors = [];
        $validRows = [];

        for ($i = 4; $i < count($rows); $i++) {
            $row = $rows[$i];
            
            $noIndikator = trim($row[0] ?? '');
            
            // Skip empty rows
            if (empty($noIndikator) && empty($row[1]) && empty($row[2])) {
                continue;
            }
            
            // Skip example rows which usually contain specific text
            if (str_contains($noIndikator, 'MULAI ISI DATA')) {
                continue;
            }

            $indikatorRpjmd = trim($row[1] ?? '');
            $targetRpjmd = trim($row[2] ?? '');
            $dokumenData = trim($row[3] ?? '');
            $catatan = trim($row[4] ?? '');
            $targetPerpres = trim($row[5] ?? '');
            $targetPerpresRingkas = trim($row[6] ?? '');
            $kewenanganKab = trim($row[7] ?? '');
            $kewenanganKota = trim($row[8] ?? '');

            // Validations
            $target = Target::where('no_target', $noIndikator)->first();
            if (!$target) {
                $failedCount++;
                $errors[] = "Baris " . ($i+1) . ": No Indikator '$noIndikator' tidak ditemukan di master data sistem.";
                continue;
            }

            if (empty($targetRpjmd) || empty($dokumenData) || empty($catatan)) {
                $failedCount++;
                $errors[] = "Baris " . ($i+1) . ": Kolom C, D, atau E tidak boleh kosong.";
                continue;
            }

            if (!in_array(strtolower($kewenanganKab), ['ya', 'tidak']) || !in_array(strtolower($kewenanganKota), ['ya', 'tidak'])) {
                $failedCount++;
                $errors[] = "Baris " . ($i+1) . ": Kolom H dan I (Kewenangan) hanya boleh berisi Ya atau Tidak.";
                continue;
            }

            // Cek format catatan untuk warning
            $hasWarning = !preg_match('/Capaian.*\|.*GAP.*\|.*Status:/i', $catatan);

            $validRows[] = [
                '_target_id'                 => $target->id,
                '_has_warning'               => $hasWarning,
                'target_id'                  => $target->id,
                'no_indikator'               => $target->no_target,
                'nama_indikator_tpb'         => $target->nama_target,
                'indikator_rpjmd'            => $target->nama_target,
                'target_rpjmd'               => $targetRpjmd,
                'dokumen_pendukung'          => $dokumenData,
                'catatan'                    => $catatan,
                'target_perpres59'           => $targetPerpres,
                'ringkasan_target_perpres59' => $targetPerpresRingkas,
                'kewenangan_kabupaten'       => (strtolower($kewenanganKab) == 'ya') ? 'Kabupaten' : '-',
                'kewenangan_kota'            => (strtolower($kewenanganKota) == 'ya') ? 'Kota' : '-',
                'user_id'                    => Auth::id(),
                'status'                     => 'Terverifikasi',
            ];
        }

        // Jika terdapat data yang valid untuk diimport
        if (!empty($validRows)) {
            // Hapus SEMUA data Indikator lama beserta relasi capaian-nya
            $semuaIndikatorIds = Indikator::pluck('id');

            if ($semuaIndikatorIds->count() > 0) {
                Capaian::whereIn('indikator_id', $semuaIndikatorIds)->delete();
                CapaianKabupaten::whereIn('indikator_id', $semuaIndikatorIds)->delete();
                Indikator::whereIn('id', $semuaIndikatorIds)->delete();
            }

            // Simpan seluruh data baru
            foreach ($validRows as $validRow) {
                if ($validRow['_has_warning']) {
                    $warningCount++;
                } else {
                    $successCount++;
                }
                unset($validRow['_target_id'], $validRow['_has_warning']);
                Indikator::create($validRow);
            }
        }

        $request->session()->put('import_summary', [
            'success' => $successCount,
            'warning' => $warningCount,
            'failed'  => $failedCount,
            'errors'  => $errors
        ]);

        return redirect()->back()->with('success', 'Proses import selesai.');
    }

    public function verify(Request $request, $id)
    {
        $indikator = Indikator::findOrFail($id);
        $indikator->update([
            'status' => 'Terverifikasi',
            'keterangan_verifikasi' => $request->keterangan_verifikasi
        ]);

        return redirect()->back()->with('success', 'Data Indikator berhasil diverifikasi.');
    }

    public function reject(Request $request, $id)
    {
        $indikator = Indikator::findOrFail($id);
        $indikator->update([
            'status' => 'Ditolak',
            'keterangan_verifikasi' => $request->keterangan_verifikasi
        ]);

        return redirect()->back()->with('success', 'Data Indikator telah ditolak dengan keterangan.');
    }

    public function show($id)
    {
        //return response
        $indikator = Indikator::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Target',
            'data'    => $indikator
        ]); 
    }

    public function update(Request $request, $id)
    {
        $indikator = Indikator::findOrFail($id);

        //define validation rules
        $validator = Validator::make($request->all(), [
            'target_id'                  => 'required',
            'target_rpjmd'               => 'required',
            'dokumen_pendukung'          => 'required',
            'catatan'                    => 'required',
            'target_perpres59'           => 'required',
            'ringkasan_target_perpres59' => 'required',
            'kewenangan_kabupaten'       => 'required',
            'kewenangan_kota'            => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $target_rel = Target::find($request->target_id);

        //update post
        $indikator->update([
            'target_id'                  => $request->target_id,
            'no_indikator'               => $target_rel ? $target_rel->no_target : '',
            'nama_indikator_tpb'         => $target_rel ? $target_rel->nama_target : '',
            'indikator_rpjmd'            => $target_rel ? $target_rel->nama_target : '',
            'target_rpjmd'               => $request->target_rpjmd,
            'dokumen_pendukung'          => $request->dokumen_pendukung,
            'catatan'                    => $request->catatan,
            'target_perpres59'           => $request->target_perpres59,
            'ringkasan_target_perpres59' => $request->ringkasan_target_perpres59,
            'kewenangan_kabupaten'       => $request->kewenangan_kabupaten,
            'kewenangan_kota'            => $request->kewenangan_kota,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dirubah !',
            'data'    => $indikator
        ]);
    }

    public function destroy($id)
    {
        //delete pimpinan by ID
        Indikator::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]); 
    }
}
