@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-4">
    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
    <h5 class="card-header">Informasi Pengguna</h5>
    <!-- Account -->
    <div class="card-body">
      <div class="d-flex align-items-start align-items-sm-center gap-4">
        <img
          id="preview-image-before-upload" 
          src="{{ $user->foto ? asset('storage/foto/' . $user->foto) : 'https://www.salonlfc.com/wp-content/uploads/2018/01/image-not-found-scaled.png' }}"
          alt="user-avatar"
          class="d-block rounded"
          height="150"
          width="150"
        />
        <div class="button-wrapper">
          <label for="foto" class="btn btn-primary me-2 mb-4" tabindex="0">
            <span class="d-none d-sm-block">Upload new photo</span>
            <i class="bx bx-upload d-block d-sm-none"></i>
           <input type="file" name="foto" placeholder="Choose image" id="foto" class="account-file-input"
           hidden accept="image/png, image/jpeg" >
          </label>
          <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
        </div>
      </div>
    </div>

    <hr class="my-0" />
      <div class="card-body">
        <div class="row">
          <div class="col mb-12">
                <label for="nameBasic" class="form-label">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Nama Anda" value="{{ old('name', $user->name) }}" required/>
                @error('name')
                <div class="alert alert-danger mt-2 d-none" role="alert">
                    {{ $message }}
                </div>
            @enderror
          </div>
        </div>
        <br />
          <!-- -->
          <div class="row">
            <div class="col mb-6">
                  <label for="nameBasic" class="form-label">Email / Username</label>
                  <input type="text" id="email" name="email" class="form-control" placeholder="Email / Username" value="{{ old('email', $user->email) }}" required/>
                  @error('email')
                  <div class="alert alert-danger mt-2 d-none" role="alert">
                      {{ $message }}
                  </div>
              @enderror
            </div>
                <div class="col mb-6">
                  <label for="nameBasic" class="form-label">Kata Sandi</label>
                  <input type="password" id="password" name="password" class="form-control" placeholder="Password" value="" required/>
                  @error('password')
                  <div class="alert alert-danger mt-2 d-none" role="alert">
                      {{ $message }}
                  </div>
              @enderror
            </div>
          </div>
          <!-- -->
          <br />
           <!-- -->
        <div class="row">
          <div class="col mb-8">
                <label for="level" class="form-label">Jenis Pengguna</label>
                <select class="form-control js-example-basic-single" name="level" id="level" required>
                  <option value="" selected disabled>Pilih..</option>
                  <option value="Administrator" {{ $user->level == "Administrator" ? 'selected' : '' }}>Administrator</option>
                  <option value="Operator Provinsi" {{ $user->level == "Operator Provinsi" ? 'selected' : '' }}>Operator Provinsi</option>
                  <option value="Operator Kabupaten/Kota" {{ $user->level == "Operator Kabupaten/Kota" ? 'selected' : '' }}>Operator Kabupaten/Kota</option>
                  <option value="Verifikator" {{ $user->level == "Verifikator" ? 'selected' : '' }}>Verifikator</option>
                  <option value="Guest" {{ $user->level == "Guest" ? 'selected' : '' }}>Guest</option>
              </select>
                @error('level')
                <div class="alert alert-danger mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
          </div>
          <div class="col mb-4">
            <label for="no_hp" class="form-label">Nomor Ponsel</label>
            <input type="number" id="no_hp" name="no_hp" class="form-control" placeholder="" value="{{ old('no_hp', $user->no_hp) }}" required/>
            @error('no_hp')
            <div class="alert alert-danger mt-2 d-none" role="alert">
                {{ $message }}
            </div>
        @enderror
      </div>
        </div>
        <!-- -->
        <br />
        <div id="row_dinas" style="{{ $user->level == 'Operator Provinsi' || $user->level == 'Operator Kabupaten/Kota' ? '' : 'display:none' }}">
          <div class="row">
            <div class="col mb-6">
              <label for="dinas" class="form-label">Nama Dinas</label>
              <input type="text" id="dinas" name="dinas" class="form-control" placeholder="Nama Dinas" value="{{ old('dinas', $user->dinas) }}"/>
            </div>
            <div class="col mb-6" id="row_wilayah" style="{{ $user->level == 'Operator Kabupaten/Kota' ? '' : 'display:none' }}">
              <label for="wilayah" class="form-label">Kabupaten/Kota</label>
              <select class="form-control js-example-basic-single" name="wilayah" id="wilayah">
                <option value="" selected disabled>Pilih..</option>
                @foreach($wilayah as $data)
                  <option value="{{ $data->nama_wilayah }}" {{ $user->wilayah == $data->nama_wilayah ? 'selected' : '' }}>{{ $data->nama_wilayah }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
       
        <div class="row mt-3">
          <div class="col mb-12">
        <button type="submit" class="btn btn-md btn-primary"><i class="tf-icons bx bx-save"></i>SIMPAN</button>
        <button type="button" class="btn btn-md btn-warning" onclick="history.back()"><i class="tf-icons bx bx-exit"></i>BATAL</button>
          </div>
        </div>

      </div>
    </form>
</div>
   
</div>
  <!-- / Content -->
  <script src="//cdn.ckeditor.com/4.20.0/full/ckeditor.js"></script>
  <script type="text/javascript">
      $(document).ready(function () {
          $('.ckeditor').ckeditor();
      });
  </script>
  <script type="text/javascript">
      
    $(document).ready(function (e) {
     
       
       $('#foto').change(function(){
                
        let reader = new FileReader();
     
        reader.onload = (e) => { 
     
          $('#preview-image-before-upload').attr('src', e.target.result); 
        }
     
        reader.readAsDataURL(this.files[0]); 
       
       });

       $('#level').change(function() {
            var level = $(this).val();
            if (level == 'Operator Provinsi') {
                $('#row_dinas').show();
                $('#row_wilayah').hide();
                $('#wilayah').val('');
            } else if (level == 'Operator Kabupaten/Kota') {
                $('#row_dinas').show();
                $('#row_wilayah').show();
            } else {
                $('#row_dinas').hide();
                $('#row_wilayah').hide();
                $('#dinas').val('');
                $('#wilayah').val('');
            }
        });
       
    });
     
    </script>
 
@endsection