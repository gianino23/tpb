@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-4">
    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
    <h5 class="card-header">Informasi Pengguna</h5>
    <!-- Account -->
    <div class="card-body">
      <div class="d-flex align-items-start align-items-sm-center gap-4">
        <img
          id="preview-image-before-upload" 
          src="https://www.salonlfc.com/wp-content/uploads/2018/01/image-not-found-scaled.png"
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
           hidden accept="image/png, image/jpeg">
           <p id="file-result"></p>
          </label>
          <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 1 MB</p>
        </div>
      </div>
    </div>

    <hr class="my-0" />
      <div class="card-body">
        <div class="row">
          <div class="col mb-12">
                <label for="nameBasic" class="form-label">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Nama Anda" required/>
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
                  <input type="text" id="email" name="email" class="form-control" placeholder="Email / Username" required/>
                  @error('email')
                  <div class="alert alert-danger mt-2 d-none" role="alert">
                      {{ $message }}
                  </div>
              @enderror
            </div>
                <div class="col mb-6">
                  <label for="nameBasic" class="form-label">Kata Sandi</label>
                  <input type="password" id="password" name="password" class="form-control" placeholder="Password" required/>
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
                  <option value="Administrator">Administrator</option>
                  <option value="Operator Provinsi">Operator Provinsi</option>
                  <option value="Operator Kabupaten/Kota">Operator Kabupaten/Kota</option>
              </select>
                @error('level')
                <div class="alert alert-danger mt-2" role="alert">
                    {{ $message }}
                </div>
            @enderror
          </div>
          <div class="col mb-4">
            <label for="no_hp" class="form-label">Nomor Ponsel</label>
            <input type="number" id="no_hp" name="no_hp" class="form-control" placeholder="" required/>
            @error('no_hp')
            <div class="alert alert-danger mt-2 d-none" role="alert">
                {{ $message }}
            </div>
        @enderror
      </div>
        </div>
        <!-- -->
        <br />
        <div id="row_dinas" style="display:none">
          <div class="row">
            <div class="col mb-6">
              <label for="dinas" class="form-label">Nama Dinas</label>
              <input type="text" id="dinas" name="dinas" class="form-control" placeholder="Nama Dinas"/>
            </div>
            <div class="col mb-6" id="row_wilayah" style="display:none">
              <label for="wilayah" class="form-label">Kabupaten/Kota</label>
              <select class="form-control js-example-basic-single" name="wilayah" id="wilayah">
                <option value="" selected disabled>Pilih..</option>
                @foreach($wilayah as $data)
                  <option value="{{ $data->nama_wilayah }}">{{ $data->nama_wilayah }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
       
        <div class="row mt-3">
          <div class="col mb-12">
        <button type="submit" class="btn btn-md btn-primary"><i class="tf-icons bx bx-save"></i>SIMPAN</button>
        <button type="reset" class="btn btn-md btn-warning"><i class="tf-icons bx bx-exit"></i>RESET</button>
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
      
      let fileInput = document.getElementById("foto");
      let fileResult = document.getElementById("file-result");
      let reader = new FileReader();
       
       fileInput.addEventListener("change", function () {
       if (fileInput.files.length > 0) {
         const fileSize = fileInput.files.item(0).size;
         const fileMb = fileSize / 1024 ** 2;
         if (fileMb >= 1) {
           fileResult.innerHTML = "File Melebihi 1 MB";
           fileSubmit.disabled = true;
         } else {
           reader.onload = (e) => { 
             
             $('#preview-image-before-upload').attr('src', e.target.result); 
           }

           reader.readAsDataURL(this.files[0]); 
           fileResult.innerHTML = "Foto Berhasil Di Upload";
           fileSubmit.disabled = true;
         }
       }
     });

     $(document).ready(function() {
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