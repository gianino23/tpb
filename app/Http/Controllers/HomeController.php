<?php

namespace App\Http\Controllers;

use App\Models\CapaianKabupaten;
use App\Models\Indikator;
use App\Models\Tpb;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $totalData = CapaianKabupaten::count();
        $totalTerverifikasi = CapaianKabupaten::where('status', 'Terverifikasi')->count();
        $totalMenunggu = CapaianKabupaten::where('status', 'Menunggu Verifikasi')->count();
        $totalDitolak = CapaianKabupaten::where('status', 'Ditolak')->count();
        $tpbCount = Tpb::count();
        $indikatorCount = Indikator::where('status', 'Terverifikasi')->count();
        $publikasiRate = $totalData > 0 ? round(($totalTerverifikasi / $totalData) * 100) : 0;

        $highlights = CapaianKabupaten::with(['tpb', 'indikator', 'target'])
            ->where('status', 'Terverifikasi')
            ->latest('tanggal_terima')
            ->take(6)
            ->get();

        return view('public.portal', compact(
            'totalTerverifikasi',
            'totalMenunggu',
            'totalDitolak',
            'totalData',
            'tpbCount',
            'indikatorCount',
            'publikasiRate',
            'highlights'
        ));
    }
}
