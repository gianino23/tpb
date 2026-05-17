<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('sneat/assets/') }}"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>E-TPB</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ url('storage/provkalsel.jpeg') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

     <!-- Icons. Uncomment required icon fonts -->
     <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css') }}" />

     <!-- Core CSS -->
     <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
     <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
     <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css') }}" />
 
     <!-- Vendors CSS -->
     <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
 

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/pages/page-auth.css') }}" />
    <!-- Helpers -->
    <script src="{{ asset('sneat/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('sneat/assets/js/config.js') }}"></script>
  </head>

  <body style="background-image: url('https://www.sfidnfits.com/image/catalog/Kalsel/sfidnfits.com-4-Wisata-Keren-Di-Kalimantan-Selatan-Yang-Tak-Boleh-Dilewatkan5.JPG');background-position: center; /* Center the image */
  background-repeat: no-repeat;background-size: cover;">
    <!-- Content -->

    <div class="container-xxl" >
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register -->
          
          <div class="card">
              {{-- Error Alert --}}
              @if(session('error'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{session('error')}}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              @endif 
            <div class="card-body">
              <!-- Logo -->
              <center><img src="{{ url('storage/provkalsel.jpeg') }}" style="width:100px;margin-top:-140px;" class="" /></center>
              <!-- /Logo -->
              <h4 class="mb-2">Selamat Datang!</h4>
              <p class="mb-4">Sistem Informasi Pemantauan dan Evaluasi Capaian Indikator Tujuan Pembangunan Berkelanjutan <br/>Dalam Pelaksanaan Pembangunan Jangka Menengah Kalimantan Selatan Tahun 2025-2030</p>

              <form id="formAuthentication" class="mb-3" novalidate
              action="{{ route('postlogin') }}" method="POST">
              {{ csrf_field() }}
                <div class="mb-3">
                  @error('login_gagal')
                                            {{-- <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span> --}}
                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                {{-- <span class="alert-inner--icon"><i class="ni ni-like-2"></i></span> --}}
                                                <span class="alert-inner--text"><strong>Warning!</strong>  {{ $message }}</span>
                                            </div>
                                            @enderror
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="name@example.com"
                    autofocus
                   
                  />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                  </div>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="*****"
                      aria-describedby="password"
                     
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                </div>
                
              </form>
             
            </div>
          </div>
          <!-- /Register --> 
        </div>
      </div>
    </div>

    <!-- / Content -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('sneat/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

    <script src="{{ asset('sneat/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('sneat/assets/js/main.js') }}"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
