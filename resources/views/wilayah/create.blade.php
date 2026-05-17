@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-4">
    <form action="{{ route('wilayah.store') }}" method="POST">
      @csrf
      <h5 class="card-header">Tambah Data Wilayah</h5>
      <div class="card-body">
        <div class="row">
          <div class="col mb-12">
            <label for="nama_wilayah" class="form-label">Nama Wilayah</label>
            <input type="text" id="nama_wilayah" name="nama_wilayah" class="form-control" placeholder="Contoh: Kalimantan Selatan, Banjarmasin, dll" required/>
            @error('nama_wilayah')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col mb-12">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-control" name="kategori" id="kategori" required>
              <option value="" selected disabled>Pilih Kategori..</option>
              <option value="Provinsi">Provinsi</option>
              <option value="Kabupaten">Kabupaten</option>
              <option value="Kota">Kota</option>
            </select>
            @error('kategori')
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col mb-12">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea id="keterangan" name="keterangan" class="form-control" rows="3" placeholder="Tambahkan keterangan jika perlu"></textarea>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col mb-12">
            <button type="submit" class="btn btn-md btn-primary"><i class="tf-icons bx bx-save"></i> SIMPAN</button>
            <a href="{{ route('wilayah.index') }}" class="btn btn-md btn-warning"><i class="tf-icons bx bx-exit"></i> KEMBALI</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
