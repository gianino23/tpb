<?php

namespace App\Http\Controllers;

use App\Models\Tpb;
use App\Models\Target;
use App\Models\Indikator;
use App\Models\Rpjmd;
use App\Models\Capaian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class CapaianController extends Controller
{
    public function index()
    {
        //get all posts from Models
        $tpbs = Tpb::orderByRaw('LENGTH(no_tpb) ASC, no_tpb ASC')->get();
        $targets = Target::all();
        $indikators = Indikator::all();
        $rpjmds = Rpjmd::all();
        $capaians = Capaian::all();

        //return view with data
        return view('capaian.index', compact('tpbs','targets','indikators','rpjmds','capaians'));
    }

    public function list($id)
    {
        $id=Crypt::decryptString($id);
        $capaians = Capaian::findOrFail($id);
        return view('capaian.list', compact('capaians'));
    }
    
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'tpb_id'   => 'required',
            'target_id'   => 'required',
            'indikator_id'   => 'required',
            'rpjmd_id'   => 'required',
            'opd'   => 'required',
            'tahun_n4'   => 'required',
            'tahun_n3'   => 'required',
            'tahun_n2'   => 'required',
            'tahun_n1'   => 'required',
            'tahun_n'   => 'required',
            'gap'   => 'required',
            'kategori_capaian'   => 'required',
            
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
        $capaian = Capaian::create([
            'tpb_id'        => $request->tpb_id,
            'target_id'     => $request->target_id,
            'indikator_id'  => $request->indikator_id, 
            'rpjmd_id'      => $request->rpjmd_id, 
            'opd'           => $request->opd, 
            'tahun_n4'      => $request->tahun_n4, 
            'tahun_n3'      => $request->tahun_n3, 
            'tahun_n2'      => $request->tahun_n2, 
            'tahun_n1'      => $request->tahun_n1,
            'tahun_n'       => $request->tahun_n,
            'gap'           => $request->gap,
            'kategori_capaian'     => $request->kategori_capaian,

        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $capaian
        ]);
    }

    public function show($id)
    {
        //return response
        $capaian = Capaian::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Target',
            'data'    => $capaian
        ]); 
    }

    public function update(Request $request, $id)
    {
        $capaian = Capaian::findOrFail($id);
        //define validation rules
         $validator = Validator::make($request->all(), [
            'tpb_id'   => 'required',
            'target_id'   => 'required',
            'indikator_id'   => 'required',
            'rpjmd_id'   => 'required',
            'opd'   => 'required',
            'tahun_n4'   => 'required',
            'tahun_n3'   => 'required',
            'tahun_n2'   => 'required',
            'tahun_n1'   => 'required',
            'tahun_n'   => 'required',
            'gap'   => 'required',
            'kategori_capaian'   => 'required',
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
        $capaian->update([
           'tpb_id'        => $request->tpb_id,
            'target_id'     => $request->target_id,
            'indikator_id'  => $request->indikator_id, 
            'rpjmd_id'      => $request->rpjmd_id, 
            'opd'           => $request->opd, 
            'tahun_n4'      => $request->tahun_n4, 
            'tahun_n3'      => $request->tahun_n3, 
            'tahun_n2'      => $request->tahun_n2, 
            'tahun_n1'      => $request->tahun_n1,
            'tahun_n'       => $request->tahun_n,
            'gap'           => $request->gap,
            'kategori_capaian'     => $request->kategori_capaian,
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dirubah !',
            'data'    => $capaian
        ]);
    }

    public function destroy($id)
    {
        //delete pimpinan by ID
        Capaian::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]); 
    }
}
