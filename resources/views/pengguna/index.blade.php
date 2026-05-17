@extends('layouts.admin')

@section('content')

<?php
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
?>
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Responsive Table -->
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col mb-6">
            <h4 class=""><span class="text-muted fw-light"></span>Daftar Pengguna
            </h4>
        
          </div>
          <div class="col mb-6">
            <a href="{{ route('user.create') }}" class="btn rounded-pill btn-primary mb-2" id="btn-create-post" style="float:right"><i class="menu-icon tf-icons bx bx-copy"></i> TAMBAH DATA</a>
            
          </div>
        </div>
       
      <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr class="text-nowrap">
              <th>No</th>
              <th>Pengguna</th>
              <th>Jenis Pengguna</th>
              <th style="width:150px"></th>
              
            </tr>
          </thead>
          <tbody>
            <?php $i=0;?>
            @foreach($users as $data)
           <?php $i++;?>
            <tr id="index_{{ $data->id }}">
              <td>{{$i }}</td>
              <td>
                <p class="card-text"><small class="text-muted">{{ $data->email }}</small></p>
                
                {{ $data->name }}
              </td>
              <td>{{ $data->level }}</td>
             
              <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                      <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('user.destroy', Crypt::encryptString($data->id)) }}" method="POST">
                        <a href="{{ route('user.edit', Crypt::encryptString($data->id)) }}" class="btn btn-sm btn-warning"><i class="tf-icons bx bx-copy"></i></a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"><i class="tf-icons bx bx-trash"></i></button>
                    </form>
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

@endsection