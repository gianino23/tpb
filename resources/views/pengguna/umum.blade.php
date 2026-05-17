@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card mb-4">
    <form action="/perbaharui/<?php echo Crypt::encryptString(auth()->user()->id);?>" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
    <h5 class="card-header">Pengaturan Umum</h5>
    <!-- Account -->

    <hr class="my-0" />
      <div class="card-body">
        
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
              <label for="nameBasic" class="form-label">Nomor Ponsel</label>
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
        <!-- -->
       
        <div class="row">
          <div class="col mb-12">
        <button type="submit" class="btn btn-md btn-primary"><i class="tf-icons bx bx-save"></i>SIMPAN</button>
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
       
    });
     
    </script>
 
@endsection