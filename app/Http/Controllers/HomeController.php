<?php

namespace App\Http\Controllers;

use App\Models\CapaianKabupaten;
use App\Models\Indikator;
use App\Models\Tpb;
use App\Models\Rpjmd;
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

        // Calculate dynamic dashboard statistics from database, perfectly synchronized with DashboardController
        $regions = [
            'Banjar', 'Barito Kuala', 'Banjarbaru', 'Banjarmasin', 
            'Hulu Sungai Selatan', 'Hulu Sungai Tengah', 'Hulu Sungai Utara', 
            'Kotabaru', 'Tabalong', 'Tanah Bumbu', 'Tanah Laut', 'Tapin'
        ];
        
        $years = [2022, 2023, 2024, 2025, 2026];
        
        // Initialize the structure
        $dashboardData = [];
        foreach ($regions as $r) {
            foreach ($years as $y) {
                $dashboardData[$r][$y] = [
                    'year' => $y,
                    'total' => 0,
                    'ab' => 0,
                    'sb' => 0,
                    'bb' => 0,
                    'percent' => 0,
                    'trend' => '—'
                ];
            }
        }
        
        // Retrieve all verified capaian kabupatens with verified indicators, same as admin dashboard
        $capaians = CapaianKabupaten::where('status', 'Terverifikasi')
            ->whereHas('indikator', function ($q) {
                $q->where('status', 'Terverifikasi');
            })
            ->with(['indikator'])
            ->get();
            
        $yearFieldMap = [
            2026 => 'tahun_n',
            2025 => 'tahun_n1',
            2024 => 'tahun_n2',
            2023 => 'tahun_n3',
            2022 => 'tahun_n4',
        ];

        foreach ($capaians as $c) {
            $matchedRegion = null;
            $cleanC = trim(str_ireplace(['kabupaten', 'kota', 'kab.', 'kab ', 'kota '], '', $c->wilayah));
            foreach ($regions as $r) {
                if (strcasecmp($cleanC, $r) === 0 || strcasecmp(trim($c->wilayah), $r) === 0) {
                    $matchedRegion = $r;
                    break;
                }
            }
            if (!$matchedRegion) {
                continue;
            }

            foreach ($years as $yr) {
                $field = $yearFieldMap[$yr];
                $capaianValue = $this->parseNumericValue($c->{$field});
                
                // If achievement data doesn't exist for this year, skip it
                if ($capaianValue === null) {
                    continue;
                }
                
                $targetValue = $this->parseNumericValue($c->indikator->target_perpres59 ?? null);
                $gap = ($targetValue !== null) ? round($targetValue - $capaianValue, 2) : null;
                
                $status = in_array($c->kategori_capaian, ['SS', 'SB', 'BB'], true)
                    ? $c->kategori_capaian
                    : $this->statusFromGap($gap, $capaianValue);
                    
                $dashboardData[$matchedRegion][$yr]['total'] += 1;
                
                if ($status === 'SS') {
                    $dashboardData[$matchedRegion][$yr]['ab'] += 1;
                } elseif ($status === 'SB') {
                    $dashboardData[$matchedRegion][$yr]['sb'] += 1;
                } else {
                    $dashboardData[$matchedRegion][$yr]['bb'] += 1;
                }
            }
        }
        
        // Calculate percentages and trends
        foreach ($regions as $r) {
            $prevPercent = null;
            foreach ($years as $y) {
                $total = $dashboardData[$r][$y]['total'];
                $ab = $dashboardData[$r][$y]['ab'];
                
                if ($total > 0) {
                    $dashboardData[$r][$y]['percent'] = (int)round(($ab / $total) * 100);
                }
                
                if ($prevPercent !== null) {
                    $diff = $dashboardData[$r][$y]['percent'] - $prevPercent;
                    $dashboardData[$r][$y]['trend'] = $diff >= 0 ? "↑ +{$diff}%" : "↓ {$diff}%";
                }
                
                $prevPercent = $dashboardData[$r][$y]['percent'];
            }
        }

        // Convert to sequential list array for JS compatibility (array instead of object with stringified numeric keys)
        foreach ($regions as $r) {
            $dashboardData[$r] = array_values($dashboardData[$r]);
        }

        return view('public.portal', compact(
            'totalTerverifikasi',
            'totalMenunggu',
            'totalDitolak',
            'totalData',
            'tpbCount',
            'indikatorCount',
            'publikasiRate',
            'highlights',
            'dashboardData'
        ));
    }

    private function parseNumericValue($value): ?float
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string)$value);
        if ($value === '' || $value === '-') {
            return null;
        }

        $normalized = str_replace(',', '.', $value);
        if (preg_match('/-?\d+(?:\.\d+)?/', $normalized, $matches)) {
            return (float)$matches[0];
        }

        return null;
    }

    private function statusFromGap(?float $gap, ?float $capaian): string
    {
        if ($capaian === null || $gap === null) {
            return 'NA';
        }

        if ($gap <= 0) {
            return 'SS';
        }

        return $gap <= 10 ? 'SB' : 'BB';
    }
}


