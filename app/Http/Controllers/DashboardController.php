<?php

namespace App\Http\Controllers;

use App\Models\Capaian;
use App\Models\CapaianKabupaten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $capaians = Capaian::all();
        
        $queryKab = CapaianKabupaten::query();
        if ($user->level == 'Operator Kabupaten/Kota') {
            $queryKab->where('user_id', $user->id);
        }

        $stats = [
            'menunggu' => (clone $queryKab)->where('status', 'Menunggu Verifikasi')->count(),
            'terverifikasi' => (clone $queryKab)->where('status', 'Terverifikasi')->count(),
            'ditolak' => (clone $queryKab)->where('status', 'Ditolak')->count(),
            'total' => (clone $queryKab)->count(),
        ];

        // For Chart
        $chartData = [
            $stats['terverifikasi'],
            $stats['menunggu'],
            $stats['ditolak']
        ];

        // Recent Activity (last 5 records or logs)
        $recentActivities = CapaianKabupaten::with(['user', 'indikator'])
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        $capaians = $queryKab->with(['tpb', 'target', 'indikator', 'rpjmd'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('dashboard.index', compact('capaians', 'stats', 'chartData', 'recentActivities'));
    }
}
