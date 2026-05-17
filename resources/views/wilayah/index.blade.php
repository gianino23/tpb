@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col mb-6">
            <h4 class="">Daftar Wilayah</h4>
          </div>
          <div class="col mb-6">
            <a href="{{ route('wilayah.create') }}" class="btn rounded-pill btn-primary mb-2" style="float:right"><i class="menu-icon tf-icons bx bx-copy"></i> TAMBAH DATA</a>
          </div>
        </div>
       
      <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr class="text-nowrap">
              <th>No</th>
              <th>Nama Wilayah</th>
              <th>Kategori</th>
              <th>Keterangan</th>
              <th style="width:150px">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($wilayahs as $data)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $data->nama_wilayah }}</td>
              <td>{{ $data->kategori }}</td>
              <td>{{ $data->keterangan ?? '-' }}</td>
              <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                      <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('wilayah.destroy', Crypt::encryptString($data->id)) }}" method="POST">
                        <a href="{{ route('wilayah.edit', Crypt::encryptString($data->id)) }}" class="btn btn-sm btn-warning"><i class="tf-icons bx bx-edit"></i></a>
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
  </div>
</div>

@endsection
