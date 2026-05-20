<?php

namespace App\Http\Controllers;

use App\Models\Tpb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class TpbController extends Controller
{
    public function index()
    {
        //get all posts from Models
        $tpbs = Tpb::orderByRaw('LENGTH(no_tpb) ASC, no_tpb ASC')->get();

        //return view with data
        return view('tpb.index', compact('tpbs'));
    }

    public function list($id)
    {
        $id=Crypt::decryptString($id);
        $tpbs = Tpb::findOrFail($id);
        return view('tpb.list', compact('tpbs'));
    }
    
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'no_tpb'   => 'required',
            'nama_tpb'   => 'required',
            'pilar'   => 'required',
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
        $tpb = Tpb::create([
            'no_tpb'     => $request->no_tpb,
            'nama_tpb'     => $request->nama_tpb,
            'pilar'     => $request->pilar, 
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $tpb
        ]);
    }

    public function show($id)
    {
        //return response
        $tpb = Tpb::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data TPB',
            'data'    => $tpb
        ]); 
    }

    public function update(Request $request, $id)
    {
        $tpb = Tpb::findOrFail($id);
        //define validation rules
        $validator = Validator::make($request->all(), [
            'no_tpb'     => 'required',
            'nama_tpb'   => 'required',
            'pilar'      => 'required',
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
        $tpb->update([
            'no_tpb'     => $request->no_tpb, 
            'nama_tpb'   => $request->nama_tpb, 
            'pilar'     => $request->pilar, 
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dirubah !',
            'data'    => $tpb
        ]);
    }

    public function destroy($id)
    {
        //delete pimpinan by ID
        Tpb::where('id', $id)->delete();

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Dihapus!.',
        ]); 
    }
}
