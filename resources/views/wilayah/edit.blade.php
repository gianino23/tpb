@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-4">
    <form action="{{ route('wilayah.update', $wilayah->id) }}" method="POST">
      @csrf
      @method('PUT')
      <h5 class="card-header">Edit Data Wilayah</h5>
      <div class="card-body">
        <div class="row">
          <div class="col mb-12">
            <label for="nama_wilayah" class="form-label">Nama Wilayah</label>
            <input type="text" id="nama_wilayah" name="nama_wilayah" class="form-control" value="{{ old('nama_wilayah', $wilayah->nama_wilayah) }}" required/>
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
              <option value="Provinsi" {{ $wilayah->kategori == 'Provinsi' ? 'selected' : '' }}>Provinsi</option>
              <option value="Kabupaten" {{ $wilayah->kategori == 'Kabupaten' ? 'selected' : '' }}>Kabupaten</option>
              <option value="Kota" {{ $wilayah->kategori == 'Kota' ? 'selected' : '' }}>Kota</option>
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
            <textarea id="keterangan" name="keterangan" class="form-control" rows="3">{{ old('keterangan', $wilayah->keterangan) }}</textarea>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col mb-12">
            <button type="submit" class="btn btn-md btn-primary"><i class="tf-icons bx bx-save"></i> UPDATE</button>
            <a href="{{ route('wilayah.index') }}" class="btn btn-md btn-warning"><i class="tf-icons bx bx-exit"></i> KEMBALI</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
