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
        //get all posts from Models
        $indikators = Indikator::all();

        //return view with data
        return view('indikator.index', compact('indikators'));
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
            'no_indikator'   => 'required',
            'nama_indikator_tpb'   => 'required',
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

        //create post
        $indikator = Indikator::create([
            'no_indikator'     => $request->no_indikator,
            'nama_indikator_tpb'     => $request->nama_indikator_tpb,
            'indikator_rpjmd'     => $request->indikator_rpjmd, 
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
            'no_indikator'               => 'required',
            'nama_indikator_tpb'         => 'required',
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

        //update post
        $indikator->update([
            'no_indikator'               => $request->no_indikator,
            'nama_indikator_tpb'         => $request->nama_indikator_tpb,
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
