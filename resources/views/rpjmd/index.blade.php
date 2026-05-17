@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
   
   
  

    <!-- Responsive Table -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col mb-6">
            <h4 class=""><span class="text-muted fw-light">Data /</span> RPJMD </h4>
        
          </div>
          <div class="col mb-6">
            <a href="javascript:void(0)" class="btn rounded-pill btn-primary mb-2" id="btn-create-post" style="float:right"><i class="menu-icon tf-icons bx bx-copy"></i>TAMBAH DATA</a>
     
          </div>
        </div>
       
      <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr class="text-nowrap">
              <th>No Indikator RPJMD</th>
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
              <td>{{ $data->no_indikator_rpjmd }}</td> 
              <td>{{ $data->indikator_kinerja }}</td>
              <td>{{ $data->spm }}</td>
              <td>{{ $data->jenis_urusan }}</td>
              <td>{{ $data->kategori_urusan }}</td>
              <td>{{ $data->kekhususan_indikator }}</td>
              <td>{{ $data->referensi }}</td>
              <td>{{ $data->indikator_sama }}</td>
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
</div>
  <!-- / Content -->
@include('rpjmd.modal-create')
@include('rpjmd.modal-edit')
@include('rpjmd.delete-post')
@endsection