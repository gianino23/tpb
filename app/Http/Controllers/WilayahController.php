<?php

namespace App\Http\Controllers;

use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class WilayahController extends Controller
{
    public function index()
    {
        $wilayahs = Wilayah::all();
        return view('wilayah.index', compact('wilayahs'));
    }

    public function create()
    {
        return view('wilayah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_wilayah' => 'required',
            'kategori' => 'required|in:Provinsi,Kabupaten,Kota'
        ]);

        Wilayah::create($request->all());

        return redirect()->route('wilayah.index')->with(['success' => 'Data Wilayah Berhasil Disimpan!']);
    }

    public function edit($id)
    {
        $id = Crypt::decryptString($id);
        $wilayah = Wilayah::findOrFail($id);
        return view('wilayah.edit', compact('wilayah'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_wilayah' => 'required',
            'kategori' => 'required|in:Provinsi,Kabupaten,Kota'
        ]);

        $wilayah = Wilayah::findOrFail($id);
        $wilayah->update($request->all());

        return redirect()->route('wilayah.index')->with(['success' => 'Data Wilayah Berhasil Diperbarui!']);
    }

    public function destroy($id)
    {
        $id = Crypt::decryptString($id);
        $wilayah = Wilayah::findOrFail($id);
        $wilayah->delete();

        return back()->with(['success' => 'Data Wilayah Berhasil Dihapus!']);
    }
}
