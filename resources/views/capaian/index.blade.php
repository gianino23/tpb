@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
   
   
  

    <!-- Responsive Table -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col mb-6">
            <h4 class=""><span class="text-muted fw-light">Data /</span> Capaian </h4>
        
          </div>
          <div class="col mb-6">
            <a href="javascript:void(0)" class="btn rounded-pill btn-primary mb-2" id="btn-create-post" style="float:right"><i class="menu-icon tf-icons bx bx-copy"></i>TAMBAH DATA</a>
     
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
    <!--/ Responsive Table -->
  </div>
</div>
  <!-- / Content -->
@include('capaian.modal-create')
@include('capaian.modal-edit')
@include('capaian.delete-post')
@endsection