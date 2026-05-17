<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        //get all posts from Models
        $users = User::all();

        //return view with data
        return view('pengguna.index', compact('users'));
    }
    public function create()
    {
        $wilayah = Wilayah::all();
        return view('pengguna.create', compact('wilayah'));
    }

    public function store(Request $request)
    {
       
        //upload image
        $foto_name = null;
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $foto->storeAs('public/foto', $foto->hashName());
            $foto_name = $foto->hashName();
        }


       $user = User::create([
            'foto'     => $foto_name,
            'name'   => $request->name,
            'email'   => $request->email,
            'password'   => bcrypt($request->password),
            'level'   => $request->level,
            'dinas'   => $request->dinas,
            'wilayah'   => $request->wilayah,
            'no_hp'   => $request->no_hp,
            'status' => 1,

        ]);
    
       //if($berita){
            //redirect dengan pesan sukses
            
         return redirect()->route('user.index')->with(['success' => 'Data Berhasil Disimpan!']);
        //}
            //redirect dengan pesan error
            
          //  return redirect()->route('sertifikat.list',Crypt::encryptString($request->order_id))->with(['error' => 'Data Gagal Disimpan!']);
       // }
    }

    public function show(User $user)
    {
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Instansi',
            'data'    => $user
        ]); 
    }

    public function edit($id)
    {
        $id=Crypt::decryptString($id);
        $user = User::findOrFail($id);
        $wilayah = Wilayah::all();
        return view('pengguna.edit', compact('user', 'wilayah'));
    }
    public function umum($id)
    {
        $id=Crypt::decryptString($id);
        $user = User::findOrFail($id);
        return view('pengguna.umum', compact('user'));
    }
    public function akun($id)
    {
        $id=Crypt::decryptString($id);
        $user = User::findOrFail($id);
        $wilayah = Wilayah::all();
        return view('pengguna.akun', compact('user', 'wilayah'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); 
        if(!$request->hasFile('foto')){
            $user->update([
                'name'   => $request->name,
                'email'   => $request->email,
                'password'   => bcrypt($request->password),
                'level'   => $request->level,
                'dinas'   => $request->dinas,
                'wilayah'   => $request->wilayah,
                'no_hp'   => $request->no_hp,
                'status' => 1,
            ]);
        }else{
            //hapus old image
            if ($user->foto) {
                Storage::disk('local')->delete('public/foto/'.$user->foto);
            }
                
            //upload new image
            $foto = $request->file('foto');
            $foto->storeAs('public/foto', $foto->hashName());

            $user->update([
                'foto'     => $foto->hashName(),
                'name'   => $request->name,
                'email'   => $request->email,
                'password'   => bcrypt($request->password),
                'level'   => $request->level,
                'dinas'   => $request->dinas,
                'wilayah'   => $request->wilayah,
                'no_hp'   => $request->no_hp,
                'status' => 1,
            ]);
        }
        return redirect()->route('user.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    public function perbaharui(Request $request, $id)
    {
       $id=Crypt::decryptString($id);
       $user = User::findOrFail($id); 

        $user->update([
            'email'   => $request->email,
            'no_hp'   => $request->no_hp,
        ]);

       return back();
    }

    public function perbaiki(Request $request, $id)
    {
       $id=Crypt::decryptString($id);
       $user = User::findOrFail($id); 
       if(!$request->hasFile('foto')){
      
        $user->update([
            'name'   => $request->name,
            'email'   => $request->email,
            'password'   => bcrypt($request->password),
            'level'   => $request->level,
            'dinas'   => $request->dinas,
            'wilayah'   => $request->wilayah,
            'no_hp'   => $request->no_hp,
            'status' => 1,
        ]);
       }else{
        //hapus old image
        if ($user->foto) {
            Storage::disk('local')->delete('public/foto/'.$user->foto);
        }
            
        //upload new image
        $foto = $request->file('foto');
        $foto->storeAs('public/foto', $foto->hashName());
       

        $user->update([
            'foto'     => $foto->hashName(),
            'name'   => $request->name,
            'email'   => $request->email,
            'password'   => bcrypt($request->password),
            'level'   => $request->level,
            'dinas'   => $request->dinas,
            'wilayah'   => $request->wilayah,
            'no_hp'   => $request->no_hp,
            'status' => 1,
        ]);
       }
        

       return back();
    }

    public function destroy($id)
    {
      $id=Crypt::decryptString($id);
      $user = User::findOrFail($id);

      if ($user->foto) {
        Storage::disk('local')->delete('public/foto/'.$user->foto);
      }
     
      $user->delete();
    
      if($user){
        //redirect dengan pesan sukses
        return back();
            //return redirect()->route('pemohon.index')->with(['success' => 'Data Berhasil Dihapun!']);
        }else{
            //redirect dengan pesan error
        return back();   
           // return redirect()->route('pemohon.index')->with(['error' => 'Data Gagal Dihapus!']);
        }
    }
}
