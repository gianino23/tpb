@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
   
   
  

    <!-- Responsive Table -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col mb-6">
            <h4 class=""><span class="text-muted fw-light">Data /</span> Indikator </h4>
        
          </div>
          <div class="col mb-6">
            <a href="javascript:void(0)" class="btn rounded-pill btn-primary mb-2" id="btn-create-post" style="float:right"><i class="menu-icon tf-icons bx bx-copy"></i>TAMBAH DATA</a>
     
          </div>
        </div>
       
      <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr class="text-nowrap">
              <th>Pilar</th>
              <th>No Indikator</th>
              <th>Indikator TPB</th>
              <th>Indikator Yang Direncanakan Dalam RPJMD</th>
              <th>Target Yang Harus Ditetapkan Dalam RPJMD</th>
              <th>Dokumen/Data Yang Harus Disiapkan</th>
              <th>Catatan</th>
              <th>Target (Perpres 59/2017)</th>
              <th>Target (Perpres 59/2017) - Ringkasan</th>
              <th>Kewenangan Kabupaten</th>
              <th>Kewenangan Kota</th>
              <th style="width:150px"></th>
              
            </tr>
          </thead>
          <tbody>
            
            @foreach($indikators as $data)
           
            <tr id="index_{{ $data->id }}">
              <td>{{ $data->target && $data->target->tpb ? $data->target->tpb->pilar : '-' }}</td>
              <td>{{ $data->target ? $data->target->no_target : '-' }}</td> 
              <td>{{ $data->target ? $data->target->nama_target : '-' }}</td>
              <td>{{ $data->indikator_rpjmd }}</td>
              <td>{{ $data->target_rpjmd }}</td>
              <td>{{ $data->dokumen_pendukung }}</td>
              <td>{{ $data->catatan }}</td>
              <td>{{ $data->target_perpres59 }}</td>
              <td>{{ $data->ringkasan_target_perpres59 }}</td>
              <td>{{ $data->kewenangan_kabupaten }}</td>
              <td>{{ $data->kewenangan_kota }}</td>
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
@include('indikator.modal-create')
@include('indikator.modal-edit')
@include('indikator.delete-post')
@endsection