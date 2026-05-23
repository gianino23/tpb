@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y page-shell">
    <div class="card page-panel">
      <div class="page-panel-header d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div class="page-title">
          <div class="text-muted fw-light">Data / <span class="fw-semibold text-body">TPB</span></div>
          <h4 class="mb-0">Daftar TPB</h4>
          <div class="text-muted small">Kelola tujuan pembangunan berkelanjutan dan struktur pilar.</div>
        </div>
        <div class="page-actions">
          <a href="javascript:void(0)" class="btn btn-primary rounded-pill" id="btn-create-post">
            <i class="bx bx-plus me-1"></i> Tambah Data
          </a>
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
              <td>{{ $data->pilar }}</td>
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
  <!-- / Content -->
@include('tpb.modal-create')
@include('tpb.modal-edit')
@include('tpb.delete-post')
@endsection
