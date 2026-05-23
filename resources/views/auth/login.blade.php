<!DOCTYPE html>
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

    <title>E-TPB | Login</title>

    <meta name="description" content="" />

    <link rel="icon" type="image/x-icon" href="{{ url('storage/provkalsel.jpeg') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('sneat/assets/vendor/css/pages/page-auth.css') }}" />

    <script src="{{ asset('sneat/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/config.js') }}"></script>

    <style>
      body.login-shell {
        position: relative;
        min-height: 100vh;
        background:
          radial-gradient(circle at 14% 20%, rgba(103, 80, 164, .34), transparent 24%),
          radial-gradient(circle at 82% 16%, rgba(16, 185, 129, .24), transparent 18%),
          radial-gradient(circle at 78% 78%, rgba(59, 130, 246, .26), transparent 22%),
          radial-gradient(circle at 22% 84%, rgba(244, 114, 182, .18), transparent 20%),
          linear-gradient(135deg, rgba(6, 11, 22, .82), rgba(14, 22, 39, .72));
      }
      body.login-shell:before {
        content: '';
        position: fixed;
        inset: 0;
        background:
          linear-gradient(120deg, rgba(255,255,255,.03), transparent 35%),
          radial-gradient(circle at 50% 12%, rgba(255, 255, 255, .08), transparent 12%),
          radial-gradient(circle at 60% 28%, rgba(255, 255, 255, .05), transparent 10%),
          radial-gradient(circle at 42% 66%, rgba(255, 255, 255, .04), transparent 16%);
        pointer-events: none;
      }
      .login-wrap {
        position: relative;
        z-index: 1;
        min-height: 100vh;
        display: flex;
        align-items: center;
      }
      .login-stage {
        width: 100%;
        max-width: 1180px;
        margin: 0 auto;
        padding: 2rem 1rem;
      }
      .login-grid {
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 1.5rem;
        align-items: stretch;
      }
      .login-hero,
      .login-card {
        border-radius: 1.35rem;
        overflow: hidden;
        box-shadow: 0 24px 60px rgba(15, 23, 42, .24);
      }
      .login-hero {
        position: relative;
        min-height: 620px;
        padding: 2rem;
        color: #fff;
        background:
          linear-gradient(180deg, rgba(16,24,40,.08), rgba(16,24,40,.72)),
          radial-gradient(circle at 18% 26%, rgba(103, 80, 164, .26), transparent 18%),
          radial-gradient(circle at 82% 22%, rgba(16, 185, 129, .22), transparent 16%),
          radial-gradient(circle at 72% 76%, rgba(59, 130, 246, .22), transparent 20%),
          radial-gradient(circle at 24% 80%, rgba(244, 114, 182, .16), transparent 18%);
        backdrop-filter: blur(10px);
      }
      .login-hero .eyebrow {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .45rem .8rem;
        border-radius: 999px;
        background: rgba(255,255,255,.14);
        backdrop-filter: blur(10px);
        font-size: .85rem;
      }
      .login-hero h1 {
        margin-top: 1.25rem;
        font-size: clamp(2rem, 4vw, 3.6rem);
        line-height: 1.05;
        font-weight: 800;
        letter-spacing: 0;
      }
      .login-hero p {
        max-width: 34rem;
        color: rgba(255,255,255,.9);
      }
      .login-hero .hero-badges {
        display: flex;
        flex-wrap: wrap;
        gap: .6rem;
        margin-top: 1.25rem;
      }
      .login-hero .hero-badges span {
        display: inline-flex;
        align-items: center;
        gap: .45rem;
        padding: .55rem .85rem;
        border-radius: 999px;
        background: rgba(255,255,255,.12);
        backdrop-filter: blur(12px);
        font-size: .85rem;
      }
      .login-card {
        background: rgba(255,255,255,.86);
        backdrop-filter: blur(18px);
        border: 1px solid rgba(255,255,255,.55);
        box-shadow: 0 24px 60px rgba(15, 23, 42, .24), inset 0 1px 0 rgba(255,255,255,.6);
      }
      .login-card:before {
        content: '';
        display: block;
        height: 7px;
        background: linear-gradient(90deg, #696cff, #10b981, #3b82f6, #f59e0b, #ef4444);
      }
      .login-card .card-body {
        padding: 2rem;
      }
      .login-brand {
        display: flex;
        align-items: center;
        gap: .9rem;
        margin-bottom: 1.25rem;
      }
      .login-brand img {
        width: 62px;
        height: 62px;
        object-fit: contain;
      }
      .login-brand .brand-text {
        color: #566a7f;
      }
      .login-brand .brand-text strong {
        display: block;
        font-size: 1.1rem;
      }
      .login-brand .brand-text span {
        display: block;
        font-size: .84rem;
        color: #8592a3;
      }
      .login-form .form-control {
        border-radius: .9rem;
        min-height: 48px;
      }
      .login-form .input-group-text {
        border-radius: 0 .9rem .9rem 0;
      }
      .login-form .btn {
        border-radius: .9rem;
        min-height: 48px;
        font-weight: 700;
      }
      .login-footnote {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(133,146,163,.18);
        color: #8592a3;
        font-size: .82rem;
      }
      @media (max-width: 991.98px) {
        .login-grid {
          grid-template-columns: 1fr;
        }
        .login-hero {
          min-height: 340px;
        }
      }
      @media (max-width: 575.98px) {
        .login-stage {
          padding: .75rem;
        }
        .login-hero,
        .login-card {
          border-radius: 1rem;
        }
        .login-card .card-body {
          padding: 1.25rem;
        }
        .login-hero {
          min-height: 260px;
          padding: 1.25rem;
        }
        .login-hero p {
          font-size: .92rem;
        }
      }
    </style>
  </head>

  <body class="login-shell">
    <div class="login-wrap">
      <div class="login-stage">
        <div class="login-grid">
          <section class="login-hero">
            <div class="eyebrow">
              <i class="bx bx-shield-quarter"></i>
              Sistem Pemantauan TPB
            </div>
            <h1>E-TPB</h1>
            <p>
              Platform resmi untuk pemantauan, evaluasi, dan pelaporan capaian indikator Tujuan Pembangunan Berkelanjutan di Kalimantan Selatan.
            </p>
            <div class="hero-badges">
              <span><i class="bx bx-buildings"></i> Provinsi Kalimantan Selatan</span>
              <span><i class="bx bx-layer"></i> Dashboard Evaluasi Kinerja</span>
              <span><i class="bx bx-cloud-upload"></i> Import Excel Terintegrasi</span>
            </div>
          </section>

          <section class="login-card">
            <div class="card-body">
              <div class="login-brand">
                <img src="{{ url('storage/provkalsel.jpeg') }}" alt="Provinsi Kalimantan Selatan" />
                <div class="brand-text">
                  <strong>E-TPB</strong>
                  <span>Dinas Lingkungan Hidup Provinsi Kalimantan Selatan</span>
                </div>
              </div>

              <h4 class="mb-2 fw-bold" style="color:#566a7f;">Selamat Datang</h4>
              <p class="mb-4" style="color:#8592a3;">
                Masuk untuk mengelola pemantauan dan evaluasi capaian indikator TPB.
              </p>

              @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ session('error') }}
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              @endif

              <form id="formAuthentication" class="login-form" action="{{ route('postlogin') }}" method="POST" novalidate>
                @csrf
                <div class="mb-3">
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
                      placeholder="••••••••"
                      aria-describedby="password"
                    />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>

                <button class="btn btn-primary d-grid w-100" type="submit">
                  Masuk ke Sistem
                </button>
              </form>

              <div class="login-footnote">
                Akses terbatas untuk pengguna terdaftar. Pastikan kredensial sesuai dengan akun Anda.
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>

    <script src="{{ asset('sneat/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/main.js') }}"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
