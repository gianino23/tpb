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
        $user = Auth::user();
        $indikators = Indikator::with('target.tpb')
            ->when(request('pilar'), function ($q) {
                return $q->whereHas('target.tpb', function ($q2) {
                    $q2->where('pilar', request('pilar'));
                });
            })
            ->when(request('wilayah'), function ($q) {
                $cleanReq = str_replace(['Kabupaten ', 'Kab. ', 'Kota ', 'kabupaten ', 'kota '], '', request('wilayah'));
                return $q->where('wilayah', 'LIKE', '%' . $cleanReq . '%');
            })
            ->when($user->level == 'Operator Kabupaten/Kota', function ($q) use ($user) {
                $userWilayah = '';
                if (str_contains(strtolower($user->wilayah), 'barito kuala')) {
                    $userWilayah = 'Barito Kuala';
                } elseif (str_contains(strtolower($user->wilayah), 'banjar')) {
                    $userWilayah = 'Banjar';
                } elseif (str_contains(strtolower($user->wilayah), 'tapin')) {
                    $userWilayah = 'Tapin';
                }
                return $q->where('wilayah', $userWilayah);
            })
            ->get();

        $targets = Target::all()->sortBy('no_target', SORT_NATURAL)->values();
        $pilars = Tpb::select('pilar')->distinct()->orderBy('pilar')->pluck('pilar');
        $wilayahList = \App\Models\Wilayah::all();

        //return view with data
        return view('indikator.index', compact('indikators', 'targets', 'pilars', 'wilayahList'));
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
            'wilayah'   => 'required',
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
            'wilayah'     => $request->wilayah, 
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

            \Log::info('Import Indikator dimulai', [
                'filename' => $file->getClientOriginalName(),
                'size'     => $file->getSize(),
            ]);

            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet   = $spreadsheet->getActiveSheet();
            $rows        = $worksheet->toArray();
            $rowCount    = count($rows);

            \Log::info("File Excel berhasil dibaca. Total baris: {$rowCount}");

            $successCount = 0;
            $warningCount = 0;
            $failedCount  = 0;
            $errors       = [];
            $validRows    = [];

            for ($i = 4; $i < $rowCount; $i++) {
                $row = $rows[$i];

                if (!is_array($row)) {
                    continue;
                }

                $noIndikator = trim($row[0] ?? '');

                // Skip baris kosong
                if ($noIndikator === '' && trim($row[1] ?? '') === '' && trim($row[2] ?? '') === '') {
                    continue;
                }

                // Skip baris contoh
                if (str_contains(strtoupper($noIndikator), 'MULAI ISI DATA')) {
                    continue;
                }

                $indikatorRpjmd          = trim($row[1] ?? '');
                $targetRpjmd             = trim($row[2] ?? '');
                $dokumenData             = trim($row[3] ?? '');
                $catatan                 = trim($row[4] ?? '');
                $targetPerpres           = trim($row[5] ?? '');
                $targetPerpresRingkas    = trim($row[6] ?? '');
                $kewenanganKab           = trim($row[7] ?? '');
                $kewenanganKota          = trim($row[8] ?? '');

                // Validasi: No Indikator harus ditemukan di master Target
                $target = Target::where('no_target', $noIndikator)->first();
                if (!$target) {
                    $failedCount++;
                    $errors[] = "Baris " . ($i + 1) . ": No Indikator '$noIndikator' tidak ditemukan di master data sistem.";
                    continue;
                }

                if ($targetRpjmd === '' || $dokumenData === '') {
                    $failedCount++;
                    $errors[] = "Baris " . ($i + 1) . ": Kolom C (Target RPJMD) atau D (Dokumen Data) tidak boleh kosong.";
                    continue;
                }

                // Default catatan
                if ($catatan === '') {
                    $catatan = '-';
                }

                // --- Validasi Kewenangan Kabupaten ---
                $kewenanganKabClean = '-';
                $kewenanganKabLower = strtolower($kewenanganKab);
                if (in_array($kewenanganKabLower, ['ya', 'kabupaten'])) {
                    $kewenanganKabClean = 'Kabupaten';
                } elseif (!in_array($kewenanganKabLower, ['tidak', 'nihil', '-', ''])) {
                    $failedCount++;
                    $errors[] = "Baris " . ($i + 1) . ": Kolom H (Kewenangan Kabupaten) hanya boleh berisi Ya, Tidak, Kabupaten, atau dikosongkan.";
                    continue;
                }

                // --- Validasi Kewenangan Kota ---
                $kewenanganKotaClean = '-';
                $kewenanganKotaLower = strtolower($kewenanganKota);
                if (in_array($kewenanganKotaLower, ['ya', 'kota'])) {
                    $kewenanganKotaClean = 'Kota';
                } elseif (!in_array($kewenanganKotaLower, ['tidak', 'nihil', '-', ''])) {
                    $failedCount++;
                    $errors[] = "Baris " . ($i + 1) . ": Kolom I (Kewenangan Kota) hanya boleh berisi Ya, Tidak, Kota, atau dikosongkan.";
                    continue;
                }

                // Cek format catatan (warning, non-blokir)
                $hasWarning = !preg_match('/Capaian.*\|.*GAP.*\|.*Status:/i', $catatan);

                // Gunakan indikator_rpjmd dari Excel (kolom B), fallback ke nama_target
                $indikatorValue = !empty($indikatorRpjmd) ? $indikatorRpjmd : $target->nama_target;

                $validRows[] = [
                    '_target_id'                 => $target->id,
                    '_has_warning'               => $hasWarning,
                    'target_id'                  => $target->id,
                    'no_indikator'               => $target->no_target,
                    'nama_indikator_tpb'         => $target->nama_target,
                    'indikator_rpjmd'            => $indikatorValue,
                    'target_rpjmd'               => $targetRpjmd,
                    'dokumen_pendukung'          => $dokumenData,
                    'catatan'                    => $catatan,
                    'target_perpres59'           => $targetPerpres,
                    'ringkasan_target_perpres59' => $targetPerpresRingkas,
                    'kewenangan_kabupaten'       => $kewenanganKabClean,
                    'kewenangan_kota'            => $kewenanganKotaClean,
                    'wilayah'                    => $request->wilayah,
                    'user_id'                    => Auth::id(),
                    'status'                     => 'Terverifikasi',
                ];
            }

            // Jika ada data valid, hapus lama & simpan baru
            if (!empty($validRows)) {
                $semuaIndikatorIds = Indikator::where('wilayah', $request->wilayah)->pluck('id');

                if ($semuaIndikatorIds->count() > 0) {
                    Capaian::whereIn('indikator_id', $semuaIndikatorIds)->delete();
                    CapaianKabupaten::whereIn('indikator_id', $semuaIndikatorIds)->delete();
                    Indikator::whereIn('id', $semuaIndikatorIds)->delete();
                }

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

            \Log::info("Import Indikator selesai. Berhasil: {$successCount}, Peringatan: {$warningCount}, Gagal: {$failedCount}");

            $request->session()->put('import_summary', [
                'success' => $successCount,
                'warning' => $warningCount,
                'failed'  => $failedCount,
                'errors'  => $errors,
            ]);

            if ($failedCount > 0 && empty($validRows)) {
                return redirect()->back()
                    ->with('error', 'Import gagal. Tidak ada data valid yang ditemukan. Periksa template dan format file Anda.')
                    ->with('import_summary', [
                        'success' => 0,
                        'warning' => 0,
                        'failed'  => $failedCount,
                        'errors'  => $errors,
                    ]);
            }

            if ($failedCount > 0) {
                return redirect()->back()->with('success', "Import selesai dengan {$failedCount} baris error (lihat detail).");
            }

            return redirect()->back()->with('success', "Import berhasil! {$successCount} data ditambahkan.");

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Import Indikator gagal: ' . $e->getMessage(), [
                'file'  => $e->getFile(),
                'line'  => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses file: ' . $e->getMessage())
                ->with('import_summary', [
                    'success' => 0,
                    'warning' => 0,
                    'failed'  => 0,
                    'errors'  => ['Sistem error: ' . $e->getMessage()],
                ]);
        }
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
            'wilayah'                    => 'required',
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
            'wilayah'                    => $request->wilayah,
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
