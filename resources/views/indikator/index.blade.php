@extends('layouts.admin')

@section('content')
<style>
    .pilar-tabs {
        display: flex;
        overflow-x: auto;
        white-space: nowrap;
        padding: 4px 4px 10px 4px;
        gap: 8px;
        -webkit-overflow-scrolling: touch;
    }
    .pilar-tabs::-webkit-scrollbar {
        height: 6px;
    }
    .pilar-tabs::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 4px;
    }
    .pilar-tab-item {
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 8px 24px;
        border-radius: 20px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-block;
    }
    .pilar-tab-item:hover {
        background: #f8fafc;
        color: #1e293b;
        border-color: #cbd5e1;
    }
    .pilar-tab-item.active {
        background: #fff;
        color: #1e293b;
        border-color: #64748b;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        font-weight: 600;
    }
    .dataTables_filter {
        display: none !important;
    }
    .badge-pilar {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        background: #eef2ff;
        color: #4f46e5;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y page-shell">
    @if(session('import_summary'))
        <div class="alert alert-info">
            <h5>Ringkasan Import:</h5>
            <p>✅ Berhasil diimpor: {{ session('import_summary')['success'] }} baris</p>
            <p>⚠️ Berhasil dengan peringatan (format catatan tidak sesuai): {{ session('import_summary')['warning'] }} baris</p>
            <p>❌ Gagal diimpor: {{ session('import_summary')['failed'] }} baris</p>
            @if(count(session('import_summary')['errors']) > 0)
                <hr>
                <h6>Detail Error:</h6>
                <ul style="max-height: 150px; overflow-y: auto;">
                    @foreach(session('import_summary')['errors'] as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
    <div class="card page-panel">
      <div class="card-body py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <div class="text-muted small fw-light">Data / <span class="fw-semibold text-body">Target</span></div>
                <h4 class="mb-0 fw-bold">Daftar Target</h4>
            </div>
            @if(auth()->user()->level == 'Administrator' || auth()->user()->level == 'Operator Kabupaten/Kota')
            <div class="d-flex gap-2">
              <a href="javascript:void(0)" class="btn btn-outline-success rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modal-import">
                <i class="bx bx-upload me-1"></i> Upload Excel
              </a>
              <a href="javascript:void(0)" class="btn btn-primary rounded-pill px-3" id="btn-create-post">
                <i class="bx bx-plus me-1"></i> Tambah Data
              </a>
            </div>
            @endif
        </div>

        {{-- Pilar Filter Pills --}}
        <div class="pilar-tabs-container mb-4">
            <div class="pilar-tabs">
                <a href="{{ route('indikator.index') }}" 
                   class="pilar-tab-item {{ !request('pilar') ? 'active' : '' }}">Semua</a>
                @foreach($pilars as $p)
                    <a href="{{ route('indikator.index', ['pilar' => $p]) }}" 
                       class="pilar-tab-item {{ request('pilar') == $p ? 'active' : '' }}">{{ $p }}</a>
                @endforeach
            </div>
        </div>

        {{-- Search Input Form --}}
        <div class="row g-3 align-items-center mb-4">
            <div class="col-md-6">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-search fs-4"></i></span>
                    <input type="text" id="customSearchInput" class="form-control form-control-lg" placeholder="Pencarian..." style="border-radius: 8px;">
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center gap-3">
                <a href="{{ route('indikator.index') }}" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 8px;">
                    <i class="bx bx-reset me-1"></i> Reset
                </a>
                <span class="text-muted small">Menampilkan {{ $indikators->count() }} data</span>
            </div>
        </div>

        <div class="table-responsive">
          <table id="table" class="table table-striped table-bordered" style="width:100%">
            <thead>
              <tr class="text-nowrap">
                <th>Pilar</th>
                <th>No Indikator</th>
                <th>Indikator TPB</th>
                <th>Target Yang Harus Ditetapkan Dalam RPJMD</th>
                <th>Dokumen/Data Yang Harus Disiapkan</th>
                <th>Catatan</th>
                <th>Target (Perpres 59/2017)</th>
                <th>Target (Perpres 59/2017) - Ringkasan</th>
                <th>Kewenangan Kabupaten</th>
                <th>Kewenangan Kota</th>
                <th>Status</th>
                <th style="width:150px"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($indikators as $data)
              <tr id="index_{{ $data->id }}">
                <td><span class="badge-pilar">{{ $data->target && $data->target->tpb ? $data->target->tpb->pilar : '-' }}</span></td>
                <td>{{ $data->target ? $data->target->no_target : '-' }}</td> 
                <td>{{ $data->target ? $data->target->nama_target : '-' }}</td>
                <td>{{ $data->target_rpjmd }}</td>
                <td>{{ $data->dokumen_pendukung }}</td>
                <td>{{ $data->catatan }}</td>
                <td>{{ $data->target_perpres59 }}</td>
                <td>{{ $data->ringkasan_target_perpres59 }}</td>
                <td>{{ $data->kewenangan_kabupaten }}</td>
                <td>{{ $data->kewenangan_kota }}</td>
                <td>
                  @if($data->status == 'Terverifikasi')
                      <span class="badge bg-success">Terverifikasi</span>
                  @elseif($data->status == 'Ditolak')
                      <span class="badge bg-danger">Ditolak</span>
                  @else
                      <span class="badge bg-warning">Menunggu Validasi</span>
                  @endif
                  @if($data->keterangan_verifikasi)
                      <br><small class="text-muted">{{ $data->keterangan_verifikasi }}</small>
                  @endif
                </td>
                 <td class="text-center">
                      <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                          @if(auth()->user()->level == 'Administrator' || auth()->user()->level == 'Operator Kabupaten/Kota')
                              <a href="javascript:void(0)" id="btn-edit-post" data-id="{{ $data->id }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"><i class="tf-icons bx bx-copy"></i></a>
                              <a href="javascript:void(0)" id="btn-delete-post" data-id="{{ $data->id }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="tf-icons bx bx-trash"></i></a>
                          @endif
                      </div>
                 </td>
              </tr>
             @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- / Content -->
@include('indikator.modal-create')
@include('indikator.modal-edit')
@include('indikator.delete-post')
@include('indikator.modal-import')

<script>
function verifyData(id) {
    Swal.fire({
        title: 'Verifikasi Data',
        input: 'textarea',
        inputLabel: 'Keterangan Tambahan (Opsional)',
        inputPlaceholder: 'Catatan tambahan saat menerima data...',
        showCancelButton: true,
        confirmButtonText: 'Verifikasi & Terima',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#28a745'
    }).then((result) => {
        if (result.isConfirmed) {
            submitReview(id, 'verify', result.value);
        }
    });
}

function rejectData(id) {
    Swal.fire({
        title: 'Tolak Data',
        input: 'textarea',
        inputLabel: 'Alasan Penolakan (Wajib)',
        inputPlaceholder: 'Masukkan alasan kenapa data ditolak...',
        showCancelButton: true,
        confirmButtonText: 'Tolak Data',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545',
        inputValidator: (value) => {
            if (!value) {
                return 'Keterangan wajib diisi jika menolak data!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            submitReview(id, 'reject', result.value);
        }
    });
}

function submitReview(id, action, keterangan) {
    let url = action === 'verify' ? `/indikator/verify/${id}` : `/indikator/reject/${id}`;
    let token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: token,
            keterangan_verifikasi: keterangan
        },
        success: function(response) {
            Swal.fire('Berhasil', response.success || 'Data berhasil diproses', 'success').then(() => {
                location.reload();
            });
        },
        error: function(err) {
            Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        var dt = $('#table').DataTable();
        var customSearchInput = document.getElementById('customSearchInput');
        if (customSearchInput && dt) {
            customSearchInput.addEventListener('keyup', function() {
                dt.search(this.value).draw();
            });
        }
    }, 300);
});
</script>

@endsection
