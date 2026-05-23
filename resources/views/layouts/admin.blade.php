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
  class="light-style layout-menu-fixed"
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
   
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>E-TPB | Dinas Lingkungan Hidup Prov. Kalsel</title>

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

    <!-- Helpers -->
    <script src="{{ asset('sneat/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('sneat/assets/js/config.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
      .unselectable {
        -webkit-user-select: none;
        -webkit-touch-callout: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }
      .app-shell-brand {
        min-height: 96px;
        padding: 18px 24px 12px;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .app-shell-brand img {
        width: 58px;
        height: 58px;
        object-fit: contain;
      }
      .layout-navbar {
        min-height: 64px;
        margin-top: 1rem;
        margin-bottom: .5rem;
        border-radius: .75rem;
        box-shadow: 0 .125rem .5rem rgba(67, 89, 113, .08);
      }
      .navbar-title {
        min-width: 0;
      }
      .navbar-title-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eef2ff;
        color: #696cff;
        flex: 0 0 auto;
      }
      .navbar-title strong {
        display: block;
        color: #566a7f;
        line-height: 1.2;
      }
      .navbar-title span {
        display: block;
        color: #a1acb8;
        font-size: .8125rem;
        line-height: 1.2;
      }
      .navbar-meta {
        gap: .5rem;
      }
      .navbar-meta .badge {
        border-radius: 999px;
        font-weight: 500;
        padding: .45rem .7rem;
      }
      .navbar-user-pill {
        display: inline-flex;
        align-items: center;
        gap: .65rem;
        padding: .35rem .45rem .35rem .75rem;
        border: 1px solid #edf0f5;
        border-radius: 999px;
        background: #fff;
        color: #566a7f;
      }
      .navbar-user-pill:hover {
        background: #f8f9fb;
        color: #566a7f;
      }
      .navbar-user-text {
        line-height: 1.1;
        text-align: right;
      }
      .navbar-user-text strong {
        display: block;
        font-size: .875rem;
      }
      .navbar-user-text span {
        display: block;
        font-size: .75rem;
        color: #a1acb8;
        margin-top: .15rem;
      }
      .layout-page {
        padding-left: .75rem;
        padding-right: .75rem;
      }
      .layout-page .container-xxl {
        max-width: 100%;
      }
      .content-wrapper > .container-xxl {
        padding-top: 1rem !important;
      }
      .dropdown-user .dropdown-menu {
        min-width: 230px;
      }
      .footer .container-xxl {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
      }
      .app-footer {
        margin-top: 1rem;
        margin-bottom: 1rem;
      }
      .app-footer .footer-panel {
        position: relative;
        overflow: hidden;
        border: 1px solid #edf0f5;
        border-radius: 1rem;
        background:
          linear-gradient(135deg, rgba(105,108,255,.06), rgba(255,255,255,.92) 42%, rgba(17,24,39,.03)),
          #fff;
        box-shadow: 0 10px 30px rgba(67, 89, 113, .08);
      }
      .app-footer .footer-panel:before {
        content: '';
        position: absolute;
        inset: 0;
        background:
          linear-gradient(90deg, rgba(105,108,255,.08), transparent 35%),
          linear-gradient(180deg, transparent, rgba(17,24,39,.03));
        pointer-events: none;
      }
      .app-footer .footer-content {
        position: relative;
        z-index: 1;
      }
      .app-footer .footer-brand {
        display: flex;
        align-items: center;
        gap: .85rem;
      }
      .app-footer .footer-badge {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #eef2ff;
        color: #696cff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 0 0 auto;
      }
      .app-footer .footer-title {
        color: #566a7f;
        font-weight: 700;
        line-height: 1.25;
      }
      .app-footer .footer-subtitle {
        color: #a1acb8;
        font-size: .85rem;
      }
      .app-footer .footer-meta {
        color: #a1acb8;
        font-size: .85rem;
      }
      @media (max-width: 1199.98px) {
        .layout-page {
          padding-left: .75rem;
          padding-right: .75rem;
        }
        .layout-navbar {
          margin: .75rem 0 .25rem;
        }
      }
      @media (max-width: 767.98px) {
        html, body {
          overflow-x: hidden;
        }
        .layout-page {
          padding-left: .5rem;
          padding-right: .5rem;
        }
        .layout-navbar {
          min-height: 58px;
          border-radius: .65rem;
        }
        .navbar-title strong {
          font-size: .95rem;
          white-space: nowrap;
          overflow: hidden;
          text-overflow: ellipsis;
          max-width: 58vw;
        }
        .navbar-title span {
          display: none;
        }
        .navbar-title-icon {
          width: 34px;
          height: 34px;
          border-radius: 8px;
        }
        .navbar-meta,
        .navbar-user-text {
          display: none !important;
        }
        .content-wrapper > .container-xxl {
          padding-left: .75rem !important;
          padding-right: .75rem !important;
        }
        .footer .container-xxl {
          padding-left: .75rem;
          padding-right: .75rem;
          font-size: .8rem;
        }
        .app-footer .footer-brand {
          align-items: flex-start;
        }
        .app-footer .footer-panel {
          border-radius: .85rem;
        }
      }
    </style>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    @yield('css')
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo app-shell-brand">
            <a href="{{ route('dashboard.index') }}" class="app-brand-link d-flex flex-column align-items-center text-center">
              <img src="{{ url('storage/provkalsel.jpeg') }}" alt="Provinsi Kalimantan Selatan" />
              <span class="app-brand-text demo menu-text fw-bold mt-2" style="font-size:.9rem;letter-spacing:0;color:#566a7f;">E-TPB</span>
            </a>
              <!--
            <a href="#" class="app-brand-link">
                
              <span class="app-brand-logo demo">
                <svg
                  width="25"
                  viewBox="0 0 25 42"
                  version="1.1"
                  xmlns="http://www.w3.org/2000/svg"
                  xmlns:xlink="http://www.w3.org/1999/xlink"
                >
                  <defs>
                    <path
                      d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                      id="path-1"
                    ></path>
                    <path
                      d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                      id="path-3"
                    ></path>
                    <path
                      d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                      id="path-4"
                    ></path>
                    <path
                      d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                      id="path-5"
                    ></path>
                  </defs>
                  <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                    <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                      <g id="Icon" transform="translate(27.000000, 15.000000)">
                        <g id="Mask" transform="translate(0.000000, 8.000000)">
                          <mask id="mask-2" fill="white">
                            <use xlink:href="#path-1"></use>
                          </mask>
                          <use fill="#696cff" xlink:href="#path-1"></use>
                          <g id="Path-3" mask="url(#mask-2)">
                            <use fill="#696cff" xlink:href="#path-3"></use>
                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                          </g>
                          <g id="Path-4" mask="url(#mask-2)">
                            <use fill="#696cff" xlink:href="#path-4"></use>
                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                          </g>
                        </g>
                        <g
                          id="Triangle"
                          transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) "
                        >
                          <use fill="#696cff" xlink:href="#path-5"></use>
                          <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                        </g>
                      </g>
                    </g>
                  </g>
                </svg>
              </span>
              
              <span class="app-brand-text demo menu-text fw-bolder ms-2">SIKANDA</span>
            </a>
           
            
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
            -->
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none position-absolute" style="right:12px;top:14px;">
              <i class="bx bx-x bx-sm align-middle"></i>
            </a>
          </div>
         
             
         
          <div class="text-center mb-3 d-none"></div>
          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item {{ Request::is('dashboard*') ? 'active' : '' }}">
              <a href="{{ route('dashboard.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Beranda</div>
              </a>
            </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Menu Utama</span>
              </li>
            
    @if(auth()->user()->level == 'Administrator')
            <li class="menu-item {{ Request::is('tpb*') ? 'active' : '' }}">
                <a href="{{ route('tpb.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-layout"></i>
                  <div data-i18n="Analytics">Data TPB</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('target*') ? 'active' : '' }}">
                <a href="{{ route('target.index') }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-copy"></i>
                  <div data-i18n="Analytics">Data Indikator</div>
                </a>
            </li>
           
            <li class="menu-item {{ Request::is('indikator*') ? 'active' : '' }}">
              <a href="{{ route('indikator.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-crown"></i>
                <div data-i18n="Analytics">Data Target</div>
              </a>
          </li>
          <li class="menu-item {{ Request::is('rpjmd*') ? 'active' : '' }}">
              <a href="{{ route('rpjmd.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-archive"></i>
                <div data-i18n="Analytics">Data RPJMD</div>
              </a>
          </li>
          <li class="menu-item {{ Request::is('capaian_kabupaten*') ? 'active' : '' }}">
              <a href="{{ route('capaian_kabupaten.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Capaian Kab/Kota</div>
              </a>
          </li>
          <li class="menu-item {{ Request::is('wilayah*') ? 'active' : '' }}">
              <a href="{{ route('wilayah.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-map"></i>
                <div data-i18n="Analytics">Data Wilayah</div>
              </a>
          </li>
          <li class="menu-item {{ Request::is('user*') ? 'active' : '' }}">
              <a href="{{ route('user.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bxs-user-account"></i>
                <div data-i18n="Analytics">Pengguna</div>
              </a>
          </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Pengaturan</span>
            </li>
            <li class="menu-item {{ Request::is('user/umum*') ? 'active' : '' }}">
                <a href="{{ route('user.umum', Crypt::encryptString(auth()->user()->id)) }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-support"></i>
                  <div data-i18n="Analytics">Umum</div>
                </a>
            </li>
            <li class="menu-item {{ Request::is('user/akun*') ? 'active' : '' }}">
                <a href="{{ route('user.akun', Crypt::encryptString(auth()->user()->id)) }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                  <div data-i18n="Analytics">Akun</div>
                </a>
            </li>
    @elseif(auth()->user()->level == 'Operator Provinsi')
          <li class="menu-item {{ Request::is('capaian_kabupaten*') ? 'active' : '' }}">
              <a href="{{ route('capaian_kabupaten.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Capaian Kab/Kota</div>
              </a>
          </li>
          <li class="menu-item {{ Request::is('indikator*') ? 'active' : '' }}">
              <a href="{{ route('indikator.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-crown"></i>
                <div data-i18n="Analytics">Data Target</div>
              </a>
          </li>
          <li class="menu-item {{ Request::is('rpjmd*') ? 'active' : '' }}">
              <a href="{{ route('rpjmd.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-archive"></i>
                <div data-i18n="Analytics">Data RPJMD</div>
              </a>
          </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Pengaturan</span>
            </li>
            <li class="menu-item {{ Request::is('user/akun*') ? 'active' : '' }}">
                <a href="{{ route('user.akun', Crypt::encryptString(auth()->user()->id)) }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                  <div data-i18n="Analytics">Akun</div>
                </a>
            </li>
    @elseif(auth()->user()->level == 'Operator Kabupaten/Kota')
          <li class="menu-item {{ Request::is('capaian_kabupaten*') ? 'active' : '' }}">
              <a href="{{ route('capaian_kabupaten.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-file"></i>
                <div data-i18n="Analytics">Capaian Kab/Kota</div>
              </a>
          </li>
          <li class="menu-item {{ Request::is('indikator*') ? 'active' : '' }}">
              <a href="{{ route('indikator.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-crown"></i>
                <div data-i18n="Analytics">Data Target</div>
              </a>
          </li>
          <li class="menu-item {{ Request::is('rpjmd*') ? 'active' : '' }}">
              <a href="{{ route('rpjmd.index') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-archive"></i>
                <div data-i18n="Analytics">Data RPJMD</div>
              </a>
          </li>
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Pengaturan</span>
            </li>
            <li class="menu-item {{ Request::is('user/akun*') ? 'active' : '' }}">
                <a href="{{ route('user.akun', Crypt::encryptString(auth()->user()->id)) }}" class="menu-link">
                  <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                  <div data-i18n="Analytics">Akun</div>
                </a>
            </li>
    @endif
               
             
           

            <!-- Layouts 
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-layout"></i>
                <div data-i18n="Layouts">Layouts</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="layouts-without-menu.html" class="menu-link">
                    <div data-i18n="Without menu">Without menu</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-without-navbar.html" class="menu-link">
                    <div data-i18n="Without navbar">Without navbar</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-container.html" class="menu-link">
                    <div data-i18n="Container">Container</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-fluid.html" class="menu-link">
                    <div data-i18n="Fluid">Fluid</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="layouts-blank.html" class="menu-link">
                    <div data-i18n="Blank">Blank</div>
                  </a>
                </li>
              </ul>
            </li>

            <li class="menu-header small text-uppercase">
              <span class="menu-header-text">Pages</span>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Account Settings">Account Settings</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="pages-account-settings-account.html" class="menu-link">
                    <div data-i18n="Account">Account</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pages-account-settings-notifications.html" class="menu-link">
                    <div data-i18n="Notifications">Notifications</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pages-account-settings-connections.html" class="menu-link">
                    <div data-i18n="Connections">Connections</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                <div data-i18n="Authentications">Authentications</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="auth-login-basic.html" class="menu-link" target="_blank">
                    <div data-i18n="Basic">Login</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="auth-register-basic.html" class="menu-link" target="_blank">
                    <div data-i18n="Basic">Register</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="auth-forgot-password-basic.html" class="menu-link" target="_blank">
                    <div data-i18n="Basic">Forgot Password</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cube-alt"></i>
                <div data-i18n="Misc">Misc</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="pages-misc-error.html" class="menu-link">
                    <div data-i18n="Error">Error</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="pages-misc-under-maintenance.html" class="menu-link">
                    <div data-i18n="Under Maintenance">Under Maintenance</div>
                  </a>
                </li>
              </ul>
            </li>
             -->
            <!-- Components 
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Components</span></li>
            -->
            <!-- Cards 
            <li class="menu-item">
              <a href="cards-basic.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Cards</div>
              </a>
            </li>
            -->
            <!-- User interface
            <li class="menu-item">
              <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-box"></i>
                <div data-i18n="User interface">User interface</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="ui-accordion.html" class="menu-link">
                    <div data-i18n="Accordion">Accordion</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-alerts.html" class="menu-link">
                    <div data-i18n="Alerts">Alerts</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-badges.html" class="menu-link">
                    <div data-i18n="Badges">Badges</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-buttons.html" class="menu-link">
                    <div data-i18n="Buttons">Buttons</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-carousel.html" class="menu-link">
                    <div data-i18n="Carousel">Carousel</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-collapse.html" class="menu-link">
                    <div data-i18n="Collapse">Collapse</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-dropdowns.html" class="menu-link">
                    <div data-i18n="Dropdowns">Dropdowns</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-footer.html" class="menu-link">
                    <div data-i18n="Footer">Footer</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-list-groups.html" class="menu-link">
                    <div data-i18n="List Groups">List groups</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-modals.html" class="menu-link">
                    <div data-i18n="Modals">Modals</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-navbar.html" class="menu-link">
                    <div data-i18n="Navbar">Navbar</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-offcanvas.html" class="menu-link">
                    <div data-i18n="Offcanvas">Offcanvas</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-pagination-breadcrumbs.html" class="menu-link">
                    <div data-i18n="Pagination &amp; Breadcrumbs">Pagination &amp; Breadcrumbs</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-progress.html" class="menu-link">
                    <div data-i18n="Progress">Progress</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-spinners.html" class="menu-link">
                    <div data-i18n="Spinners">Spinners</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-tabs-pills.html" class="menu-link">
                    <div data-i18n="Tabs &amp; Pills">Tabs &amp; Pills</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-toasts.html" class="menu-link">
                    <div data-i18n="Toasts">Toasts</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-tooltips-popovers.html" class="menu-link">
                    <div data-i18n="Tooltips & Popovers">Tooltips &amp; popovers</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="ui-typography.html" class="menu-link">
                    <div data-i18n="Typography">Typography</div>
                  </a>
                </li>
              </ul>
            </li>
             -->
            <!-- Extended components 
            <li class="menu-item">
              <a href="javascript:void(0)" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-copy"></i>
                <div data-i18n="Extended UI">Extended UI</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="extended-ui-perfect-scrollbar.html" class="menu-link">
                    <div data-i18n="Perfect Scrollbar">Perfect scrollbar</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="extended-ui-text-divider.html" class="menu-link">
                    <div data-i18n="Text Divider">Text Divider</div>
                  </a>
                </li>
              </ul>
            </li>

            <li class="menu-item">
              <a href="icons-boxicons.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-crown"></i>
                <div data-i18n="Boxicons">Boxicons</div>
              </a>
            </li>
        -->
            <!-- Forms & Tables 
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Forms &amp; Tables</span></li>
            -->
            <!-- Forms 
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Form Elements">Form Elements</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="forms-basic-inputs.html" class="menu-link">
                    <div data-i18n="Basic Inputs">Basic Inputs</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="forms-input-groups.html" class="menu-link">
                    <div data-i18n="Input groups">Input groups</div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-detail"></i>
                <div data-i18n="Form Layouts">Form Layouts</div>
              </a>
              <ul class="menu-sub">
                <li class="menu-item">
                  <a href="form-layouts-vertical.html" class="menu-link">
                    <div data-i18n="Vertical Form">Vertical Form</div>
                  </a>
                </li>
                <li class="menu-item">
                  <a href="form-layouts-horizontal.html" class="menu-link">
                    <div data-i18n="Horizontal Form">Horizontal Form</div>
                  </a>
                </li>
              </ul>
            </li>
            -->
            <!-- Tables 
            <li class="menu-item active">
              <a href="tables-basic.html" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">Tables</div>
              </a>
            </li>
        -->
            <!-- Misc -->
           
          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <div class="navbar-nav align-items-center flex-grow-1 overflow-hidden">
                <div class="nav-item d-flex align-items-center navbar-title gap-3">
                  <div class="navbar-title-icon">
                    <i class="bx bx-line-chart fs-4"></i>
                  </div>
                  <div class="overflow-hidden">
                    <strong>Sistem Informasi Pemantauan TPB</strong>
                    <span>Dinas Lingkungan Hidup Provinsi Kalimantan Selatan</span>
                  </div>
                  <div class="navbar-meta d-none d-lg-flex align-items-center ms-2">
                    <span class="badge bg-label-primary">{{ auth()->user()->level }}</span>
                    @if(auth()->user()->wilayah)
                      <span class="badge bg-label-success">{{ auth()->user()->wilayah }}</span>
                    @endif
                    <span class="badge bg-label-secondary">{{ now()->format('d M Y') }}</span>
                  </div>
                </div>
              </div>
              
              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow navbar-user-pill" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="navbar-user-text">
                      <strong>{{ auth()->user()->name }}</strong>
                      <span>{{ auth()->user()->level }}</span>
                    </div>
                    <div class="avatar avatar-online">
                    <?php
                              $user = \App\Models\User::where('id',auth()->user()->id)->first();
                            ?>
                               <img src="{{ $user->foto ? asset('storage/foto/' . $user->foto) : 'https://www.salonlfc.com/wp-content/uploads/2018/01/image-not-found-scaled.png' }}" alt class="w-px-30 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                          
                             <img src="{{ $user->foto ? asset('storage/foto/' . $user->foto) : 'https://www.salonlfc.com/wp-content/uploads/2018/01/image-not-found-scaled.png' }}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{ $user->name }}</span>
                            <small class="text-muted">{{ $user->level }}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                   
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('logout') }}">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->
            @yield('content')

            <!-- Footer -->
            <footer class="content-footer footer bg-transparent app-footer">
              <div class="container-xxl">
                <div class="footer-panel">
                  <div class="footer-content px-4 py-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="footer-brand">
                      <div class="footer-badge">
                        <i class="bx bx-planet fs-4"></i>
                      </div>
                      <div>
                        <div class="footer-title">
                          E-TPB
                          <span class="footer-subtitle d-block">Sistem Pemantauan dan Evaluasi Capaian Indikator TPB</span>
                        </div>
                        <div class="footer-meta">
                          Kalimantan Selatan · Tahun {{ date('Y') }}
                        </div>
                      </div>
                    </div>
                    <div class="text-md-end">
                      <div class="footer-title">Dalam Pelaksanaan Pembangunan Jangka Menengah</div>
                      <div class="footer-meta">Provinsi Kalimantan Selatan 2025-2030</div>
                    </div>
                  </div>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>
      

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
   
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
   
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
 
    <script>
        $(document).ready(function () {
        $('#table').DataTable(
          {
            "bLengthChange": false,
            "ordering": true,               // Allows ordering
        "searching": true,              // Searchbox
        "paging": true,                 // Pagination
        "info": false,                  // Shows 'Showing X of X' information
        "pagingType": 'simple_numbers', // Shows Previous, page numbers & next buttons only
        "pageLength": 10,               // Defaults number of rows to display in table
        "columnDefs": [
            {
                "targets": 'dialPlanButtons',
                "searchable": false,    // Stops search in the fields 
                "sorting": false,       // Stops sorting
                "orderable": false      // Stops ordering
            }
        ],
        "dom": '<"top"f>rt<"bottom"lp><"clear">', // Positions table elements
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], // Sets up the amount of records to display
        "language": {
            "search": "_INPUT_",            // Removes the 'Search' field label
            "searchPlaceholder": "Pencarian"   // Placeholder for the search box
        },
        "search": {
            "addClass": 'form-control input-lg col-xs-12'
        },
        "fnDrawCallback":function(){
            $("input[type='search']").attr("id", "searchBox");
            $('#dialPlanListTable').css('cssText', "margin-top: 0px !important;");
            $("select[name='dialPlanListTable_length'], #searchBox").removeClass("input-sm");
            $('#searchBox').css("width", "980px").focus();
            $('#dialPlanListTable_filter').removeClass('dataTables_filter');
        }
          }
        );
      
        });
        </script>

<script>
  $(document).ready(function () {
  $('#table1').DataTable(
    {
      "bLengthChange": false,
      "ordering": true,               // Allows ordering
  "searching": false,              // Searchbox
  "paging": true,                 // Pagination
  "info": false,                  // Shows 'Showing X of X' information
  "pagingType": 'simple_numbers', // Shows Previous, page numbers & next buttons only
  "pageLength": 5,               // Defaults number of rows to display in table
  "columnDefs": [
      {
          "targets": 'dialPlanButtons',
          "searchable": false,    // Stops search in the fields 
          "sorting": false,       // Stops sorting
          "orderable": false      // Stops ordering
      }
  ],
  "dom": '<"top"f>rt<"bottom"lp><"clear">', // Positions table elements
  "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], // Sets up the amount of records to display
  "language": {
      "search": "_INPUT_",            // Removes the 'Search' field label
      "searchPlaceholder": "Pencarian"   // Placeholder for the search box
  },
  "search": {
      "addClass": 'form-control input-lg col-xs-12'
  },
  "fnDrawCallback":function(){
      $("input[type='search']").attr("id", "searchBox");
      $('#dialPlanListTable').css('cssText', "margin-top: 0px !important;");
      $("select[name='dialPlanListTable_length'], #searchBox").removeClass("input-sm");
      $('#searchBox').css("width", "100%").focus();
      $('#dialPlanListTable_filter').removeClass('dataTables_filter');
  }
    }
  );

  });
  </script>

    @yield('js')
  </body>
</html>
