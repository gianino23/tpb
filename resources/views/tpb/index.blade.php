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
    <div class="card page-panel">
      <div class="card-body py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <div class="text-muted small fw-light">Data / <span class="fw-semibold text-body">TPB</span></div>
                <h4 class="mb-0 fw-bold">Daftar TPB</h4>
            </div>
            <div class="d-flex gap-2">
                <a href="javascript:void(0)" class="btn btn-primary rounded-pill px-3" id="btn-create-post">
                    <i class="bx bx-plus me-1"></i> Tambah Data
                </a>
            </div>
        </div>

        {{-- Pilar Filter Pills --}}
        <div class="pilar-tabs-container mb-4">
            <div class="pilar-tabs">
                <a href="{{ route('tpb.index') }}" 
                   class="pilar-tab-item {{ !request('pilar') ? 'active' : '' }}">Semua</a>
                @foreach($pilars as $p)
                    <a href="{{ route('tpb.index', ['pilar' => $p]) }}" 
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
                <a href="{{ route('tpb.index') }}" class="btn btn-outline-secondary px-4 py-2" style="border-radius: 8px;">
                    <i class="bx bx-reset me-1"></i> Reset
                </a>
                <span class="text-muted small">Menampilkan {{ $tpbs->count() }} data</span>
            </div>
        </div>

        <div class="table-responsive">
          <table id="table" class="table table-striped table-bordered" style="width:100%">
            <thead>
              <tr class="text-nowrap">
                <th>No TPB</th>
                <th>Tujuan Pembangunan Berkelanjutan</th>
                <th>Pilar</th>
                <th style="width:150px"></th>
              </tr>
            </thead>
            <tbody>
              @foreach($tpbs as $data)
              <tr id="index_{{ $data->id }}">
                <td data-sort="{{ str_pad(preg_replace('/[^0-9]/', '', $data->no_tpb), 5, '0', STR_PAD_LEFT) }}">{{ $data->no_tpb }}</td>
                <td>{{ $data->nama_tpb }}</td> 
                <td><span class="badge-pilar">{{ $data->pilar }}</span></td>
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
@include('tpb.modal-create')
@include('tpb.modal-edit')
@include('tpb.delete-post')

<script>
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
