@extends('layouts.admin')

@section('content')
<style>
    .region-tabs {
        display: flex;
        overflow-x: auto;
        white-space: nowrap;
        padding: 4px 4px 10px 4px;
        gap: 8px;
        -webkit-overflow-scrolling: touch;
    }
    .region-tabs::-webkit-scrollbar {
        height: 6px;
    }
    .region-tabs::-webkit-scrollbar-thumb {
        background-color: #cbd5e1;
        border-radius: 4px;
    }
    .region-tab-item {
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
    .region-tab-item:hover {
        background: #f8fafc;
        color: #1e293b;
        border-color: #cbd5e1;
    }
    .region-tab-item.active {
        background: #fff;
        color: #1e293b;
        border-color: #64748b;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        font-weight: 600;
    }
    .dataTables_filter {
        display: none !important;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y page-shell">
   
    @if(session('import_summary'))
        <div class="alert alert-info">
            <h5>Ringkasan Import:</h5>
            <p>✅ Berhasil diimpor: {{ session('import_summary')['success'] }} baris</p>
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

    <!-- Responsive Table -->
    <div class="card page-panel">
      <div class="card-body py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <div class="text-muted small fw-light">Data / <span class="fw-semibold text-body">RPJMD</span></div>
                <h4 class="mb-0 fw-bold">Daftar Indikator RPJMD</h4>
            </div>
            <div class="d-flex gap-2">
                <a href="javascript:void(0)" class="btn btn-outline-success rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modal-import">
                    <i class="bx bx-upload me-1"></i> Upload Excel
                </a>
                <a href="javascript:void(0)" class="btn btn-primary rounded-pill px-3" id="btn-create-post">
                    <i class="bx bx-plus me-1"></i> Tambah Data
                </a>
            </div>
        </div>

        {{-- Region Filter Pills --}}
        @if(auth()->user()->level != 'Operator Kabupaten/Kota')
        <div class="region-tabs-container mb-4">
            <div class="region-tabs">
                <a href="{{ route('rpjmd.index') }}" 
                   class="region-tab-item {{ !request('wilayah') ? 'active' : '' }}">Semua</a>
                @foreach($wilayahList as $w)
                    <a href="{{ route('rpjmd.index', ['wilayah' => $w->nama_wilayah]) }}" 
                       class="region-tab-item {{ request('wilayah') == $w->nama_wilayah ? 'active' : '' }}">{{ $w->nama_wilayah }}</a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Search Input Form --}}
        <div class="row g-3 align-items-center mb-4">
            <div class="col-md-6">
                <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-search fs-4"></i></span>
                    <input type="text" id="customSearchInput" class="form-control form-control-lg" placeholder="Pencarian..." style="border-radius: 8px;">
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center gap-3">
                <a href="{{ route('rpjmd.index') }}" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 8px;">
                    <i class="bx bx-reset me-1"></i> Reset
                </a>
                <span class="text-muted small">Menampilkan {{ $rpjmds->count() }} data</span>
            </div>
        </div>
        <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr class="text-nowrap">
              <th>Wilayah</th>
              <th>NOMOR INDIKATOR RPJMD</th>
              <th>Indikator Kinerja</th>
              <th>SPM</th>
              <th>Jenis Urusan</th>
              <th>Kategori Urusan</th>
              <th>Kekhususan Indikator</th>
              <th>Referensi</th>
              <th>Indikator Sama</th>
              <th style="width:150px"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($rpjmds as $data)
            <tr id="index_{{ $data->id }}">
              <td>{{ $data->wilayah ?: '-' }}</td>
              <td>{{ $data->no_indikator_rpjmd }}</td> 
              <td>{{ $data->indikator_kinerja }}</td>
              <td>{{ $data->spm }}</td>
              <td>{{ $data->jenis_urusan }}</td>
              <td>{{ $data->kategori_urusan }}</td>
              <td>{{ $data->kekhususan_indikator }}</td>
              <td>{{ $data->referensi }}</td>
              <td>
                @if($data->indikator)
                  {{ $data->indikator_sama }} - {{ $data->indikator->nama_indikator_tpb }}
                @else
                  {{ $data->indikator_sama }}
                @endif
              </td>
              <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                        <a href="javascript:void(0)" id="btn-edit-post" data-id="{{ $data->id }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"><i class="tf-icons bx bx-copy"></i></a>
                        <a href="javascript:void(0)" id="btn-delete-post" data-id="{{ $data->id }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="tf-icons bx bx-trash"></i></a>
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
@include('rpjmd.modal-create')
@include('rpjmd.modal-edit')
@include('rpjmd.modal-import')
@include('rpjmd.delete-post')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Custom Search Input binding to DataTable
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
