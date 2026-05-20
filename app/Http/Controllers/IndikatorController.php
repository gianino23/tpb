<?php

namespace App\Http\Controllers;

use App\Models\Tpb;
use App\Models\Target;
use App\Models\Indikator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

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
            'indikator_rpjmd'   => 'required',
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
            'indikator_rpjmd'    => $request->indikator_rpjmd, 
            'target_rpjmd'     => $request->target_rpjmd, 
            'dokumen_pendukung'     => $request->dokumen_pendukung, 
            'catatan'     => $request->catatan, 
            'target_perpres59'     => $request->target_perpres59, 
            'ringkasan_target_perpres59'     => $request->ringkasan_target_perpres59, 
            'kewenangan_kabupaten'     => $request->kewenangan_kabupaten, 
            'kewenangan_kota'     => $request->kewenangan_kota, 

        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $indikator
        ]);
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
            'indikator_rpjmd'            => 'required',
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
            'indikator_rpjmd'            => $request->indikator_rpjmd,
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
