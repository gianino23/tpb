@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y page-shell">
    <!-- Responsive Table -->
    <div class="card page-panel">
      <div class="page-panel-header d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div class="page-title">
          <div class="text-muted fw-light">Data / <span class="fw-semibold text-body">Capaian</span></div>
          <h4 class="mb-0">Rekap Capaian</h4>
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
              <th>OPD</th>
              <th>Capaian Tahun N-4</th>
              <th>Capaian Tahun N-3</th>
              <th>Capaian Tahun N-2</th>
              <th>Capaian Tahun N-1</th>
              <th>Capaian Tahun N</th>
              <th>Gap dg Target RPJMN 2019</th>
              <th>Kategori Capaian</th>
              <th style="width:150px"></th>
              
            </tr>
          </thead>
          <tbody>
            
            @foreach($capaians as $data)
           
            <tr id="index_{{ $data->id }}">
              <td>{{ $data->opd }}</td> 
              <td>{{ $data->tahun_n4 }}</td>
              <td>{{ $data->tahun_n3 }}</td>
              <td>{{ $data->tahun_n2 }}</td>
              <td>{{ $data->tahun_n1 }}</td>
              <td>{{ $data->tahun_n }}</td>
              <td>{{ $data->gap }}</td>
              <td>{{ $data->kategori_capaian }}</td>
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
@include('capaian.modal-create')
@include('capaian.modal-edit')
@include('capaian.delete-post')
@endsection
