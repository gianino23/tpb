@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y page-shell">
    <div class="card page-panel">
      <div class="page-panel-header d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div class="page-title">
          <div class="text-muted fw-light">Data / <span class="fw-semibold text-body">Wilayah</span></div>
          <h4 class="mb-0">Daftar Wilayah</h4>
        </div>
        <div class="page-actions">
          <a href="{{ route('wilayah.create') }}" class="btn btn-primary rounded-pill">
            <i class="bx bx-plus me-1"></i> Tambah Data
          </a>
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
