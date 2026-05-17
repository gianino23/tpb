<?php

namespace App\Http\Controllers;

use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;

class TargetController extends Controller
{
    public function index()
    {
        //get all posts from Models
        $targets = Target::all();

        //return view with data
        return view('target.index', compact('targets'));
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
}
