<?php

namespace App\Http\Controllers;

use App\Models\Tpb;
use App\Models\Target;
use App\Models\Indikator;
use App\Models\Rpjmd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class RpjmdController extends Controller
{
    public function index()
    {
        //get all posts from Models
        $rpjmds = Rpjmd::all();

        //return view with data
        return view('rpjmd.index', compact('rpjmds'));
    }

    public function list($id)
    {
        $id=Crypt::decryptString($id);
        $rpjmds = Rpjmd::findOrFail($id);
        return view('rpjmd.list', compact('rpjmds'));
    }
    
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'no_indikator_rpjmd'   => 'required',
            'indikator_kinerja'   => 'required',
            'spm'   => 'required',
            'jenis_urusan'   => 'required',
            'kategori_urusan'   => 'required',
            'kekhususan_indikator'   => 'required',
            'referensi'   => 'required',
            'indikator_sama'   => 'required',
            
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
        $rpjmd = Rpjmd::create([
            'no_indikator_rpjmd'     => $request->no_indikator_rpjmd,
            'indikator_kinerja'     => $request->indikator_kinerja,
            'spm'     => $request->spm, 
            'jenis_urusan'     => $request->jenis_urusan, 
            'kategori_urusan'     => $request->kategori_urusan, 
            'kekhususan_indikator'     => $request->kekhususan_indikator, 
            'referensi'     => $request->referensi, 
            'indikator_sama'     => $request->indikator_sama, 
           

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
        //define validation rules
         $validator = Validator::make($request->all(), [
            'no_indikator_rpjmd'   => 'required',
            'indikator_kinerja'   => 'required',
            'spm'   => 'required',
            'jenis_urusan'   => 'required',
            'kategori_urusan'   => 'required',
            'kekhususan_indikator'   => 'required',
            'referensi'   => 'required',
            'indikator_sama'   => 'required',
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
        $rpjmd->update([
           'no_indikator_rpjmd'     => $request->no_indikator_rpjmd,
            'indikator_kinerja'     => $request->indikator_kinerja,
            'spm'     => $request->spm, 
            'jenis_urusan'     => $request->jenis_urusan, 
            'kategori_urusan'     => $request->kategori_urusan, 
            'kekhususan_indikator'     => $request->kekhususan_indikator, 
            'referensi'     => $request->referensi, 
            'indikator_sama'     => $request->indikator_sama, 
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
        //delete pimpinan by ID
        Rpjmd::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]); 
    }
}
