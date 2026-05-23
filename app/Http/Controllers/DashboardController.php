<?php

namespace App\Http\Controllers;

use App\Models\CapaianKabupaten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $currentYear = (int)date('Y');
        $selectedYear = (int)($request->year ?? $currentYear);
        if ($selectedYear < $currentYear - 4 || $selectedYear > $currentYear) {
            $selectedYear = $currentYear;
        }

        $yearFieldMap = [
            0 => 'tahun_n',
            1 => 'tahun_n1',
            2 => 'tahun_n2',
            3 => 'tahun_n3',
            4 => 'tahun_n4',
        ];
        $yearField = $yearFieldMap[$currentYear - $selectedYear];
        $previousYear = $selectedYear > $currentYear - 4 ? $selectedYear - 1 : null;
        $previousYearField = $previousYear ? $yearFieldMap[$currentYear - $previousYear] : null;
        $rankBy = $request->rank_by === 'pilar' ? 'pilar' : 'tpb';

        $queryKab = CapaianKabupaten::query();
        $queryKab->whereHas('indikator', function ($q) {
            $q->where('status', 'Terverifikasi');
        });
        $queryKab->where('status', 'Terverifikasi');

        if ($user->level == 'Operator Kabupaten/Kota') {
            $queryKab->where('user_id', $user->id);
        }

        $evaluations = $queryKab->with(['user', 'tpb', 'target', 'indikator', 'rpjmd'])->get()
            ->map(function ($item) use ($yearField, $previousYearField) {
                $targetValue = $this->parseNumericValue($item->indikator->target_perpres59 ?? null);
                $capaianValue = $this->parseNumericValue($item->{$yearField});
                $previousValue = $previousYearField ? $this->parseNumericValue($item->{$previousYearField}) : null;
                $gap = ($targetValue !== null && $capaianValue !== null) ? round($targetValue - $capaianValue, 2) : null;
                $status = in_array($item->kategori_capaian, ['SS', 'SB', 'BB'], true)
                    ? $item->kategori_capaian
                    : $this->statusFromGap($gap, $capaianValue);

                $item->evaluasi_capaian = $capaianValue;
                $item->evaluasi_target = $targetValue;
                $item->evaluasi_gap = $gap;
                $item->evaluasi_status = $status;
                $item->evaluasi_previous = $previousValue;
                $item->evaluasi_delta = ($capaianValue !== null && $previousValue !== null) ? round($capaianValue - $previousValue, 2) : null;

                return $item;
            })
            ->filter(fn ($item) => $item->evaluasi_capaian !== null)
            ->values();

        $totalEvaluated = max(1, $evaluations->count());
        $statusCounts = [
            'SS' => $evaluations->where('evaluasi_status', 'SS')->count(),
            'SB' => $evaluations->where('evaluasi_status', 'SB')->count(),
            'BB' => $evaluations->where('evaluasi_status', 'BB')->count(),
            'NA' => $evaluations->where('evaluasi_status', 'NA')->count(),
        ];

        $stats = [
            'ss_percent' => round(($statusCounts['SS'] / $totalEvaluated) * 100),
            'sb_percent' => round(($statusCounts['SB'] / $totalEvaluated) * 100),
            'bb_percent' => round(($statusCounts['BB'] / $totalEvaluated) * 100),
            'critical' => $statusCounts['BB'] + $statusCounts['NA'],
            'total' => $evaluations->count(),
        ];

        $ranking = $evaluations->groupBy('wilayah')
            ->map(function ($items, $wilayah) use ($previousYearField, $rankBy) {
                $score = $this->rankScore($items, $rankBy);
                $previousScore = null;

                if ($previousYearField) {
                    $previousItems = $items->filter(fn ($item) => $item->evaluasi_previous !== null);
                    if ($previousItems->count() > 0) {
                        $previousItems = $previousItems->map(function ($item) {
                            $previousGap = ($item->evaluasi_target !== null && $item->evaluasi_previous !== null)
                                ? round($item->evaluasi_target - $item->evaluasi_previous, 2)
                                : null;
                            $item->evaluasi_status = $this->statusFromGap($previousGap, $item->evaluasi_previous);
                            return $item;
                        });
                        $previousScore = $this->rankScore($previousItems, $rankBy);
                    }
                }

                return [
                    'wilayah' => $wilayah ?: '-',
                    'score' => $score,
                    'delta' => $previousScore !== null ? $score - $previousScore : null,
                    'total' => $items->count(),
                ];
            })
            ->sortByDesc('score')
            ->values();

        $criticalIndicators = $evaluations
            ->filter(function ($item) {
                return in_array($item->evaluasi_status, ['BB', 'NA'], true)
                    || ($item->evaluasi_delta !== null && $item->evaluasi_delta < 0);
            })
            ->sortByDesc(fn ($item) => abs($item->evaluasi_gap ?? 0))
            ->take(5)
            ->values();

        $chartData = [$statusCounts['SS'], $statusCounts['SB'], $statusCounts['BB'], $statusCounts['NA']];
        $availableYears = range($currentYear, $currentYear - 4);

        return view('dashboard.index', compact(
            'stats',
            'chartData',
            'ranking',
            'criticalIndicators',
            'selectedYear',
            'availableYears',
            'previousYear',
            'rankBy'
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

    private function rankScore($items, string $rankBy): int
    {
        $grouped = $items->groupBy(function ($item) use ($rankBy) {
            $tpb = $item->tpb;
            if ($rankBy === 'pilar') {
                return $tpb->pilar ?? 'Tanpa Pilar';
            }

            return trim(($tpb->no_tpb ? 'TPB ' . $tpb->no_tpb . ' - ' : '') . ($tpb->nama_tpb ?? 'Tanpa TPB'));
        });

        $groupScores = $grouped->map(function ($groupItems) {
            $totalScore = $groupItems->sum(fn ($item) => $this->statusScore($item->evaluasi_status));
            return $totalScore / max(1, $groupItems->count());
        });

        return (int)round($groupScores->avg() ?? 0);
    }

    private function statusScore(?string $status): int
    {
        return match ($status) {
            'SS' => 100,
            'SB' => 60,
            'BB' => 30,
            default => 0,
        };
    }
}
