<?php

namespace App\Http\Controllers;

use App\Models\CapaianKabupaten;
use App\Models\Tpb;
use App\Models\Target;
use App\Models\Indikator;
use App\Models\Rpjmd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\CapaianNotification;
use Carbon\Carbon;

class CapaianKabupatenController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = CapaianKabupaten::query();

        if ($user->level == 'Operator Kabupaten/Kota') {
            $query->where('user_id', $user->id);
        }

        // Stats for cards (before filtering)
        $statsQuery = clone $query;
        $countMenunggu = (clone $statsQuery)->where('status', 'Menunggu Verifikasi')->count();
        $countTerverifikasi = (clone $statsQuery)->where('status', 'Terverifikasi')->count();
        $countDitolak = (clone $statsQuery)->where('status', 'Ditolak')->count();

        // Apply filter if exists
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $capaians = $query->orderBy('created_at', 'desc')->get();

        $tpbs = Tpb::orderByRaw('LENGTH(no_tpb) ASC, no_tpb ASC')->get();
        $targets = Target::all();
        $indikators = Indikator::all();
        $rpjmds = Rpjmd::all();

        return view('capaian_kabupaten.index', compact(
            'capaians', 'tpbs', 'targets', 'indikators', 'rpjmds',
            'countMenunggu', 'countTerverifikasi', 'countDitolak'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tpb_id' => 'required',
            'target_id' => 'required',
            'indikator_id' => 'required',
            'rpjmd_id' => 'required',
            'opd' => 'required',
            'tahun_n4' => 'required',
            'tahun_n3' => 'required',
            'tahun_n2' => 'required',
            'tahun_n1' => 'required',
            'tahun_n' => 'required',
            'gap' => 'required',
            'kategori_capaian' => 'required',
            'nama_dokumen' => 'required',
            'jenis_dokumen' => 'required',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $user = Auth::user();
        
        // Generate No Tiket: #DOC-tahun bulan tanggal urutan
        $date = Carbon::now()->format('Ymd');
        $count = CapaianKabupaten::whereDate('created_at', Carbon::today())->count() + 1;
        $no_tiket = '#DOC-' . $date . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $filePaths = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('capaian_dokumen', $filename, 'public');
                $filePaths[] = $filename;
            }
        }

        $capaian = CapaianKabupaten::create([
            'no_tiket' => $no_tiket,
            'user_id' => $user->id,
            'wilayah' => $user->wilayah ?? '-',
            'tpb_id' => $request->tpb_id,
            'target_id' => $request->target_id,
            'indikator_id' => $request->indikator_id,
            'rpjmd_id' => $request->rpjmd_id,
            'opd' => $request->opd,
            'tahun_n4' => $request->tahun_n4,
            'tahun_n3' => $request->tahun_n3,
            'tahun_n2' => $request->tahun_n2,
            'tahun_n1' => $request->tahun_n1,
            'tahun_n' => $request->tahun_n,
            'gap' => $request->gap,
            'kategori_capaian' => $request->kategori_capaian,
            'nama_dokumen' => $request->nama_dokumen,
            'jenis_dokumen' => $request->jenis_dokumen,
            'tanggal_kirim' => Carbon::now(),
            'status' => 'Menunggu Verifikasi',
            'files' => json_encode($filePaths),
        ]);

        // Send Email Notification
        try {
            Mail::to($user->email)->send(new CapaianNotification($capaian));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Data Capaian berhasil dikirim.');
    }

    public function verify(Request $request, $id)
    {
        $capaian = CapaianKabupaten::with('user')->findOrFail($id);
        $capaian->update([
            'tanggal_terima' => Carbon::now(),
            'status' => 'Terverifikasi',
            'keterangan_verifikasi' => $request->keterangan_verifikasi
        ]);

        // Send Email Notification
        try {
            Mail::to($capaian->user->email)->send(new CapaianNotification($capaian));
        } catch (\Exception $e) { 
            \Illuminate\Support\Facades\Log::error('Mail Error (Verify): ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Data Capaian berhasil diverifikasi.');
    }

    public function reject(Request $request, $id)
    {
        $capaian = CapaianKabupaten::with('user')->findOrFail($id);
        $capaian->update([
            'status' => 'Ditolak',
            'keterangan_verifikasi' => $request->keterangan_verifikasi
        ]);

        // Send Email Notification
        try {
            Mail::to($capaian->user->email)->send(new CapaianNotification($capaian));
        } catch (\Exception $e) { 
            \Illuminate\Support\Facades\Log::error('Mail Error (Reject): ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Data Capaian telah ditolak dengan keterangan.');
    }

    public function edit($id)
    {
        $capaian = CapaianKabupaten::with(['tpb', 'target', 'indikator', 'rpjmd'])->findOrFail($id);
        return response()->json($capaian);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tpb_id' => 'required',
            'target_id' => 'required',
            'indikator_id' => 'required',
            'rpjmd_id' => 'required',
            'opd' => 'required',
            'tahun_n4' => 'required',
            'tahun_n3' => 'required',
            'tahun_n2' => 'required',
            'tahun_n1' => 'required',
            'tahun_n' => 'required',
            'gap' => 'required',
            'kategori_capaian' => 'required',
            'nama_dokumen' => 'required',
            'jenis_dokumen' => 'required',
            'files.*' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $capaian = CapaianKabupaten::findOrFail($id);
        
        $filePaths = json_decode($capaian->files, true) ?: [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('capaian_dokumen', $filename, 'public');
                $filePaths[] = $filename;
            }
        }

        $capaian->update([
            'tpb_id' => $request->tpb_id,
            'target_id' => $request->target_id,
            'indikator_id' => $request->indikator_id,
            'rpjmd_id' => $request->rpjmd_id,
            'opd' => $request->opd,
            'tahun_n4' => $request->tahun_n4,
            'tahun_n3' => $request->tahun_n3,
            'tahun_n2' => $request->tahun_n2,
            'tahun_n1' => $request->tahun_n1,
            'tahun_n' => $request->tahun_n,
            'gap' => $request->gap,
            'kategori_capaian' => $request->kategori_capaian,
            'nama_dokumen' => $request->nama_dokumen,
            'jenis_dokumen' => $request->jenis_dokumen,
            'files' => json_encode($filePaths),
            'status' => 'Menunggu Verifikasi',
            'keterangan_verifikasi' => null,
            'tanggal_kirim' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Data Capaian berhasil diperbarui dan dikirim ulang untuk verifikasi.');
    }

    public function destroy($id)
    {
        $capaian = CapaianKabupaten::findOrFail($id);
        
        // Delete files
        $files = json_decode($capaian->files, true);
        if ($files) {
            foreach ($files as $file) {
                Storage::delete('public/capaian_dokumen/' . $file);
            }
        }

        $capaian->delete();
        return redirect()->back()->with('success', 'Data Capaian berhasil dihapus.');
    }
}
