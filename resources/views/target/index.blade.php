@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y page-shell">
    <div class="card page-panel">
      <div class="page-panel-header d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div class="page-title">
          <div class="text-muted fw-light">Data / <span class="fw-semibold text-body">Indikator</span></div>
          <h4 class="mb-0">Daftar Indikator</h4>
          <div class="text-muted small">Kelola Indikator nasional, satuan, dan statusnya.</div>
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
              <th>Pilar</th>
              <th>No Indikator</th>
              <th>Indikator TPB</th>
              <th style="width:150px"></th>
              
            </tr>
          </thead>
          <tbody>
            
            @foreach($targets as $data)
           
            <tr id="index_{{ $data->id }}">
              <td>{{ $data->tpb ? $data->tpb->pilar : '-' }}</td>
              <td>{{ $data->no_target }}</td> 
              <td>{{ $data->nama_target }}</td>
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
    <!--/ Responsive Table -->
  </div>

  <!-- / Content -->
@include('target.modal-create')
@include('target.modal-edit')
@include('target.delete-post')
@endsection
