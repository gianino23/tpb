@extends('layouts.admin')

@section('content')

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
      <div class="page-panel-header d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div class="page-title">
          <div class="text-muted fw-light">Data / <span class="fw-semibold text-body">RPJMD</span></div>
          <h4 class="mb-0">Daftar Indikator RPJMD</h4>
        </div>
        <div class="page-actions">
          <a href="javascript:void(0)" class="btn btn-outline-success rounded-pill" data-bs-toggle="modal" data-bs-target="#modal-import">
            <i class="bx bx-upload me-1"></i> Upload Excel
          </a>
          <a href="javascript:void(0)" class="btn btn-primary rounded-pill" id="btn-create-post">
            <i class="bx bx-plus me-1"></i> Tambah Data
          </a>
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
@endsection
