@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
    <div>
      <h3 class="fw-bold mb-1">Evaluasi / Kinerja KLHS RPJMD</h3>
      <div class="text-muted">Periode: {{ min($availableYears) }} - {{ max($availableYears) }} · Kalimantan Selatan</div>
    </div>
    <div class="d-flex flex-wrap gap-2 align-items-center">
      @foreach($availableYears as $year)
        <a href="{{ route('dashboard.index', ['year' => $year, 'rank_by' => $rankBy]) }}"
          class="btn {{ $selectedYear == $year ? 'btn-primary' : 'btn-outline-secondary' }}">
          {{ $year }}
        </a>
      @endforeach
      <button type="button" class="btn btn-outline-secondary">
        <i class="bx bx-download me-1"></i> Unduh Laporan PDF
      </button>
    </div>
  </div>

  <div class="d-flex flex-wrap gap-2 mb-4 pb-3 border-bottom">
    <button class="btn btn-outline-primary active"><i class="bx bx-bar-chart-alt-2 me-1"></i> Ringkasan</button>
    <button class="btn btn-outline-secondary"><i class="bx bx-trending-up me-1"></i> Tren Tahunan</button>
    <button class="btn btn-outline-secondary"><i class="bx bx-clipboard me-1"></i> Catatan Tindak Lanjut</button>
    <button class="btn btn-outline-secondary"><i class="bx bx-money-withdraw me-1"></i> Rekomendasi Anggaran</button>
    <button class="btn btn-outline-secondary"><i class="bx bx-file me-1"></i> Laporan Otomatis</button>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
      <div class="card kpi-card h-100">
        <div class="card-body text-center">
          <div class="kpi-number text-success">{{ $stats['ss_percent'] }}%</div>
          <div class="fw-semibold">Tercapai (SS)</div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="card kpi-card h-100">
        <div class="card-body text-center">
          <div class="kpi-number text-warning">{{ $stats['sb_percent'] }}%</div>
          <div class="fw-semibold">Dalam Proses (SB)</div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="card kpi-card h-100">
        <div class="card-body text-center">
          <div class="kpi-number text-danger">{{ $stats['bb_percent'] }}%</div>
          <div class="fw-semibold">Belum Tercapai (BB)</div>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6">
      <div class="card kpi-card h-100">
        <div class="card-body text-center">
          <div class="kpi-number text-secondary">{{ $stats['critical'] }}</div>
          <div class="fw-semibold">Indikator Kritis</div>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-4 mb-4">
    <div class="col-lg-5">
      <div class="card h-100">
        <div class="card-header">
          <h5 class="mb-0">Komposisi Status {{ $selectedYear }}</h5>
        </div>
        <div class="card-body">
          <div id="evaluationDonut" style="min-height: 320px;"></div>
        </div>
      </div>
    </div>

    <div class="col-lg-7">
      <div class="card h-100">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Peringkat capaian kabupaten/kota {{ $selectedYear }} - {{ $rankBy === 'pilar' ? 'Per Pilar' : 'Per TPB' }}</h5>
          <div class="btn-group">
            <a href="{{ route('dashboard.index', ['year' => $selectedYear, 'rank_by' => 'tpb']) }}"
              class="btn btn-sm {{ $rankBy === 'tpb' ? 'btn-secondary' : 'btn-outline-secondary' }}">
              Per TPB
            </a>
            <a href="{{ route('dashboard.index', ['year' => $selectedYear, 'rank_by' => 'pilar']) }}"
              class="btn btn-sm {{ $rankBy === 'pilar' ? 'btn-secondary' : 'btn-outline-secondary' }}">
              Per Pilar
            </a>
          </div>
        </div>
        <div class="card-body">
          @forelse($ranking as $index => $row)
            @php
              $barClass = $row['score'] >= 70 ? 'bg-success' : ($row['score'] >= 50 ? 'bg-warning' : 'bg-danger');
              $deltaClass = $row['delta'] === null ? 'bg-label-secondary' : ($row['delta'] >= 0 ? 'bg-label-success' : 'bg-label-danger');
              $deltaText = $row['delta'] === null ? '-' : (($row['delta'] >= 0 ? '+' : '') . $row['delta'] . '%');
            @endphp
            <div class="ranking-row d-flex align-items-center gap-3 py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
              <div class="rank-number">{{ $index + 1 }}</div>
              <div class="fw-bold flex-grow-1">{{ $row['wilayah'] }}</div>
              <div class="progress flex-grow-1" style="max-width: 280px; height: 10px;">
                <div class="progress-bar {{ $barClass }}" style="width: {{ $row['score'] }}%"></div>
              </div>
              <div class="fw-bold text-nowrap">{{ $row['score'] }}%</div>
              <span class="badge {{ $deltaClass }}">{{ $deltaText }}</span>
            </div>
          @empty
            <div class="text-center text-muted py-5">Belum ada data terverifikasi untuk tahun {{ $selectedYear }}.</div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Indikator kritis - perlu perhatian segera</h5>
    </div>
    <div class="card-body">
      @forelse($criticalIndicators as $item)
        @php
          $isDown = $item->evaluasi_delta !== null && $item->evaluasi_delta < 0;
          $alertClass = $item->evaluasi_status === 'BB' ? 'critical-danger' : ($isDown ? 'critical-warning' : 'critical-success');
          $icon = $item->evaluasi_status === 'BB' ? 'bx-error' : ($isDown ? 'bx-trending-down' : 'bx-trending-up');
        @endphp
        <div class="critical-item {{ $alertClass }} d-flex gap-3 align-items-start mb-3">
          <i class="bx {{ $icon }} fs-3"></i>
          <div>
            <div class="fw-bold">
              {{ $item->indikator->no_indikator ?? '-' }} {{ $item->indikator->nama_indikator_tpb ?? '-' }}
            </div>
            <div>
              {{ $item->wilayah }}:
              Capaian {{ $item->evaluasi_capaian ?? '-' }}{{ $item->evaluasi_target !== null ? ', Target ' . $item->evaluasi_target : '' }},
              GAP {{ $item->evaluasi_gap ?? '-' }},
              Status {{ $item->evaluasi_status }}
              @if($item->evaluasi_delta !== null)
                · Tren {{ $previousYear }} ke {{ $selectedYear }}: {{ $item->evaluasi_delta >= 0 ? '+' : '' }}{{ $item->evaluasi_delta }}
              @endif
            </div>
          </div>
        </div>
      @empty
        <div class="text-center text-muted py-5">Tidak ada indikator kritis untuk tahun {{ $selectedYear }}.</div>
      @endforelse
    </div>
  </div>
</div>

<style>
  .kpi-card { background: #fffdf7; border: 1px solid #edf0f5; box-shadow: 0 2px 10px rgba(67, 89, 113, .06); }
  .kpi-number { font-size: 2.4rem; line-height: 1; font-weight: 800; }
  .rank-number { width: 38px; color: #f59e0b; font-size: 1.4rem; font-weight: 800; }
  .ranking-row { min-height: 64px; }
  .critical-item { border-radius: 8px; padding: 18px; }
  .critical-danger { background: #fee2e2; color: #8a1f1f; }
  .critical-warning { background: #fff3d6; color: #7a4d00; }
  .critical-success { background: #e7f6df; color: #216e33; }
</style>

@endsection

@section('js')
<script src="{{ asset('sneat/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const chartEl = document.querySelector('#evaluationDonut');
  if (!chartEl) return;

  new ApexCharts(chartEl, {
    series: @json($chartData),
    chart: { type: 'donut', height: 320 },
    labels: ['SS', 'SB', 'BB', 'NA'],
    colors: ['#22a95a', '#f5a623', '#dc3545', '#9ca3af'],
    legend: { position: 'bottom' },
    plotOptions: {
      pie: {
        donut: {
          size: '68%',
          labels: {
            show: true,
            total: {
              show: true,
              label: 'Indikator',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
              }
            }
          }
        }
      }
    }
  }).render();
});
</script>
@endsection
