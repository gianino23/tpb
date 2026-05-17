@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-12 mb-4 order-0">
      <div class="card border-0 shadow-sm bg-white" style="border-left: 5px solid #696cff !important;">
        <div class="d-flex align-items-end row">
          <div class="col-sm-8">
            <div class="card-body">
              <h4 class="fw-bold text-primary mb-1">Selamat Datang, {{ auth()->user()->name }}! 🎉</h4>
              <p class="mb-0 text-muted" style="font-size: 1.1rem;">Sistem Informasi Pemantauan dan Evaluasi Capaian Indikator TPB</p>
              <p class="text-muted small mb-0">Provinsi Kalimantan Selatan | Dinas Lingkungan Hidup</p>
            </div>
          </div>
          <div class="col-sm-4 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img src="{{ asset('sneat/assets/img/illustrations/man-with-laptop-light.png') }}" height="120" alt="Welcome" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Summary Capaian Kabupaten/Kota (Feature 4: Interactive Cards) -->
  <div class="row mb-4 mt-2">
    <div class="col-md-3 col-sm-6 mb-4">
      <div class="card bg-primary text-white h-100 shadow-sm border-0 card-hover-animate">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-white mb-0">Total Capaian</h6>
              <h3 class="text-white mb-0 mt-1 counter-value" data-target="{{ $stats['total'] }}">0</h3>
            </div>
            <div class="avatar flex-shrink-0">
                <span class="avatar-initial rounded bg-white text-primary"><i class="bx bx-file"></i></span>
            </div>
          </div>
          <a href="{{ route('capaian_kabupaten.index') }}" class="text-white small mt-3 d-block opacity-75">Lihat Semua <i class="bx bx-right-arrow-alt"></i></a>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-4">
      <div class="card bg-warning text-white h-100 shadow-sm border-0 card-hover-animate">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-white mb-0">Menunggu</h6>
              <h3 class="text-white mb-0 mt-1 counter-value" data-target="{{ $stats['menunggu'] }}">0</h3>
            </div>
            <div class="avatar flex-shrink-0">
                <span class="avatar-initial rounded bg-white text-warning"><i class="bx bx-time"></i></span>
            </div>
          </div>
          <a href="{{ route('capaian_kabupaten.index', ['status' => 'Menunggu Verifikasi']) }}" class="text-white small mt-3 d-block opacity-75">Lihat Detail <i class="bx bx-right-arrow-alt"></i></a>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-4">
      <div class="card bg-success text-white h-100 shadow-sm border-0 card-hover-animate">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-white mb-0">Terverifikasi</h6>
              <h3 class="text-white mb-0 mt-1 counter-value" data-target="{{ $stats['terverifikasi'] }}">0</h3>
            </div>
            <div class="avatar flex-shrink-0">
                <span class="avatar-initial rounded bg-white text-success"><i class="bx bx-check-shield"></i></span>
            </div>
          </div>
          <a href="{{ route('capaian_kabupaten.index', ['status' => 'Terverifikasi']) }}" class="text-white small mt-3 d-block opacity-75">Lihat Detail <i class="bx bx-right-arrow-alt"></i></a>
        </div>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-4">
      <div class="card bg-danger text-white h-100 shadow-sm border-0 card-hover-animate">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <div>
              <h6 class="text-white mb-0">Ditolak</h6>
              <h3 class="text-white mb-0 mt-1 counter-value" data-target="{{ $stats['ditolak'] }}">0</h3>
            </div>
            <div class="avatar flex-shrink-0">
                <span class="avatar-initial rounded bg-white text-danger"><i class="bx bx-x-circle"></i></span>
            </div>
          </div>
          <a href="{{ route('capaian_kabupaten.index', ['status' => 'Ditolak']) }}" class="text-white small mt-3 d-block opacity-75">Lihat Detail <i class="bx bx-right-arrow-alt"></i></a>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Chart (Feature 1) -->
    <div class="col-lg-8 mb-4">
      <div class="card h-100 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Distribusi Verifikasi Capaian</h5>
            <small class="text-muted">Persentase Status</small>
        </div>
        <div class="card-body">
            <div id="statusPieChart" style="min-height: 350px;"></div>
        </div>
      </div>
    </div>

    <!-- Recent Activity (Feature 2) -->
    <div class="col-lg-4 mb-4">
      <div class="card h-100 shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Aktivitas Terbaru</h5>
            <i class="bx bx-dots-vertical-rounded"></i>
        </div>
        <div class="card-body">
            <ul class="p-0 m-0">
                @foreach($recentActivities as $activity)
                <li class="d-flex mb-4 pb-1 border-bottom">
                  <div class="avatar flex-shrink-0 me-3">
                    <span class="avatar-initial rounded bg-label-secondary">
                        <i class="bx bx-user"></i>
                    </span>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">{{ $activity->user->name ?? 'User' }}</h6>
                      <small class="text-muted d-block">Indikator: {{ $activity->indikator->no_indikator ?? '-' }}</small>
                      <small class="text-xs text-primary">{{ \Carbon\Carbon::parse($activity->updated_at)->diffForHumans() }}</small>
                    </div>
                    <div class="user-progress d-flex align-items-center gap-1">
                        @if($activity->status == 'Terverifikasi')
                            <span class="badge bg-label-success">Selesai</span>
                        @elseif($activity->status == 'Ditolak')
                            <span class="badge bg-label-danger">Ditolak</span>
                        @else
                            <span class="badge bg-label-warning">Baru</span>
                        @endif
                    </div>
                  </div>
                </li>
                @endforeach
                @if(count($recentActivities) == 0)
                <li class="text-center py-5 text-muted">Belum ada aktivitas.</li>
                @endif
            </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Table Pengajuan Terbaru -->
  <div class="card shadow-sm border-0">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pengajuan Capaian Terbaru</h5>
        <a href="{{ route('capaian_kabupaten.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No Tiket</th>
                        <th>Wilayah / OPD</th>
                        <th>Indikator / RPJMD</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @foreach($capaians as $data)
                    <tr>
                        <td><code>{{ $data->no_tiket }}</code><br><small class="text-muted">{{ $data->tanggal_kirim }}</small></td>
                        <td><strong>{{ $data->wilayah }}</strong><br><small>{{ $data->opd }}</small></td>
                        <td>
                            <span class="badge bg-label-info">{{ $data->indikator->no_indikator ?? '-' }}</span><br>
                            <span class="badge bg-label-secondary mt-1">{{ $data->rpjmd->no_indikator_rpjmd ?? '-' }}</span>
                        </td>
                        <td>{{ $data->kategori_capaian }}</td>
                        <td>
                            @if($data->status == 'Menunggu Verifikasi')
                                <span class="badge bg-warning">Menunggu</span>
                            @elseif($data->status == 'Terverifikasi')
                                <span class="badge bg-success">Terverifikasi</span>
                            @elseif($data->status == 'Ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-icon btn-outline-primary btn-detail-dash" data-id="{{ $data->id }}"><i class="bx bx-show"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
  </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetailDash" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Capaian Kabupaten/Kota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr><th width="30%">No Tiket</th><td><code id="detail_no_tiket"></code></td></tr>
                    <tr><th>Wilayah</th><td id="detail_wilayah"></td></tr>
                    <tr><th>OPD</th><td id="detail_opd"></td></tr>
                    <tr><th>TPB</th><td id="detail_tpb"></td></tr>
                    <tr><th>Target</th><td id="detail_target"></td></tr>
                    <tr><th>Indikator</th><td id="detail_indikator"></td></tr>
                    <tr><th>RPJMD</th><td id="detail_rpjmd"></td></tr>
                    <tr><th>Tahun N-4</th><td id="detail_n4"></td></tr>
                    <tr><th>Tahun N-3</th><td id="detail_n3"></td></tr>
                    <tr><th>Tahun N-2</th><td id="detail_n2"></td></tr>
                    <tr><th>Tahun N-1</th><td id="detail_n1"></td></tr>
                    <tr><th>Tahun N</th><td id="detail_n"></td></tr>
                    <tr><th>Gap</th><td id="detail_gap"></td></tr>
                    <tr><th>Kategori</th><td id="detail_kategori"></td></tr>
                    <tr><th>Nama Dokumen</th><td id="detail_nama_dokumen"></td></tr>
                    <tr><th>Jenis Dokumen</th><td id="detail_jenis_dokumen"></td></tr>
                    <tr><th>Tgl Kirim</th><td id="detail_tgl_kirim"></td></tr>
                    <tr><th>Tgl Terima</th><td id="detail_tgl_terima"></td></tr>
                    <tr><th>Status</th><td id="detail_status"></td></tr>
                    <tr><th>Keterangan Verifikasi</th><td id="detail_keterangan_verifikasi" class="text-danger fw-bold"></td></tr>
                    <tr><th>File Dokumen</th><td id="detail_files"></td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
    .card-hover-animate:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .text-xs { font-size: 0.75rem; }
</style>

@endsection

@section('js')
<!-- ApexCharts is usually already in Sneat layout, if not we add CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
$(document).ready(function() {
    // Feature 4: Counter Animation
    $('.counter-value').each(function() {
        var $this = $(this),
            countTo = $this.attr('data-target');
        $({ countNum: $this.text() }).animate({
            countNum: countTo
        }, {
            duration: 1500,
            easing: 'linear',
            step: function() {
                $this.text(Math.floor(this.countNum));
            },
            complete: function() {
                $this.text(this.countNum);
            }
        });
    });

    // Feature 1: Pie Chart
    var options = {
        series: @json($chartData),
        chart: {
            type: 'donut',
            height: 350
        },
        labels: ['Terverifikasi', 'Menunggu', 'Ditolak'],
        colors: ['#71dd37', '#ffab00', '#ff3e1d'],
        legend: {
            position: 'bottom'
        },
        plotOptions: {
            pie: {
                donut: {
                    size: '65%',
                    labels: {
                        show: true,
                        total: {
                            show: true,
                            label: 'Total Data',
                            formatter: function (w) {
                                return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                            }
                        }
                    }
                }
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };

    var chart = new ApexCharts(document.querySelector("#statusPieChart"), options);
    chart.render();

    // Detail Button Click
    $('.btn-detail-dash').on('click', function() {
        var id = $(this).data('id');
        $.ajax({
            url: `{{ route('capaian_kabupaten.index') }}/${id}/edit`,
            type: "GET",
            success: function(response) {
                $('#detail_no_tiket').text(response.no_tiket);
                $('#detail_wilayah').text(response.wilayah);
                $('#detail_opd').text(response.opd);
                $('#detail_tpb').text(response.tpb ? response.tpb.no_tpb + ' - ' + response.tpb.nama_tpb : '-');
                $('#detail_target').text(response.target ? response.target.no_target + ' - ' + response.target.nama_target : '-');
                $('#detail_indikator').text(response.indikator ? response.indikator.no_indikator + ' - ' + response.indikator.nama_indikator_tpb : '-');
                $('#detail_rpjmd').text(response.rpjmd ? response.rpjmd.no_indikator_rpjmd + ' - ' + response.rpjmd.indikator_kinerja : '-');
                $('#detail_n4').text(response.tahun_n4);
                $('#detail_n3').text(response.tahun_n3);
                $('#detail_n2').text(response.tahun_n2);
                $('#detail_n1').text(response.tahun_n1);
                $('#detail_n').text(response.tahun_n);
                $('#detail_gap').text(response.gap);
                $('#detail_kategori').text(response.kategori_capaian);
                $('#detail_nama_dokumen').text(response.nama_dokumen);
                $('#detail_jenis_dokumen').text(response.jenis_dokumen);
                $('#detail_tgl_kirim').text(response.tanggal_kirim);
                $('#detail_tgl_terima').text(response.tanggal_terima ?? '-');
                $('#detail_status').text(response.status);
                $('#detail_keterangan_verifikasi').text(response.keterangan_verifikasi ?? '-');
                
                var filesHtml = '';
                if(response.files) {
                    var files = JSON.parse(response.files);
                    files.forEach(function(file) {
                        filesHtml += `<a href="{{ asset('storage/capaian_dokumen') }}/${file}" target="_blank" class="btn btn-xs btn-outline-info me-1 mt-1"><i class="bx bx-download"></i> ${file}</a>`;
                    });
                }
                $('#detail_files').html(filesHtml || '-');
                
                $('#modalDetailDash').modal('show');
            }
        });
    });
});
</script>
@endsection