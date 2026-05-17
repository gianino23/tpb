@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
  <div class="row">
    <div class="col-lg-12 mb-8 order-0">
      <div class="card">
        <div class="d-flex align-items-end row">
          <div class="col-sm-7">
            <div class="card-body">
              <h5 class="card-title text-primary">Selamat Datang {{ auth()->user()->name }} ! 🎉</h5>
              <p class="mb-4">
                SIKANDA | Sistem Informasi Kewaspadaan Dini Daerah <br />
                Badan Kesatuan Bangsa dan Politik Kabupaten Balangan
              </p>

            </div>
          </div>
          <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img
                src="{{ asset('sneat/assets/img/illustrations/man-with-laptop-light.png') }}"
                height="140"
                alt="View Badge User"
                data-app-dark-img="{{ asset('sneat/illustrations/man-with-laptop-dark.png') }}"
                data-app-light-img="{{ asset('sneat/illustrations/man-with-laptop-light.png') }}"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <br />
  
  @if((auth()->user()->level == 'Administrator')||(auth()->user()->level == 'Guest'))
 
  <div class="col-lg-12 col-md-12 order-1">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-3 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{ asset('sneat/assets/img/icons/unicons/chart-success.png') }}"
                  alt="chart success"
                  class="rounded"
                />
              </div>
              
            </div>
            <span class="fw-semibold d-block mb-1">Admin</span>
            <h3 class="card-title mb-2"> 
              <?php $q=0;?>
              @foreach($admin as $a)
              <?php $q++; ?>
              @endforeach
              {{ $q }}
            </h3>
            
          </div>
        </div>
      </div>
      

      <div class="col-lg-3 col-md-3 col-3 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{ asset('sneat/assets/img/icons/unicons/wallet-info.png') }}"
                  alt="chart success"
                  class="rounded"
                />
              </div>
              
            </div>
            <span class="fw-semibold d-block mb-1">Verifikator</span>
            <h3 class="card-title mb-2">
              <?php $w=0;?>
              @foreach($verifikator as $b)
              <?php $w++; ?>
              @endforeach
              {{ $w }}

            </h3>
            
          </div>
        </div>
      </div>
      

      <div class="col-lg-3 col-md-3 col-3 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{ asset('sneat/assets/img/icons/unicons/paypal.png') }}"
                  alt="chart success"
                  class="rounded"
                />
              </div>
              
            </div>
            <span class="fw-semibold d-block mb-1">Petugas</span>
            <h3 class="card-title mb-2">
              <?php $e=0;?>
              @foreach($petugas as $c)
              <?php $e++; ?>
              @endforeach
              {{ $e }}
            </h3>
            
          </div>
        </div>
      </div>
      
      <div class="col-lg-3 col-md-3 col-3 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{ asset('sneat/assets/img/icons/unicons/cc-primary.png') }}"
                  alt="chart success"
                  class="rounded"
                />
              </div>
              
            </div>
            <span class="fw-semibold d-block mb-1">Laporan Diverifikasi</span>
            <h3 class="card-title mb-2">
              <?php $ee=0;?>
              @foreach($verif as $ccc)
              <?php $ee++; ?>
              @endforeach
              {{ $ee }}
            </h3>
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- kolom 1 -->
   
  <!-- kolom 2 -->
  <div class="col-lg-12 col-md-12 order-1">
    <div class="row">
      <div class="col-lg-3 col-md-3 col-3 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{ asset('sneat/assets/img/icons/unicons/cc-success.png') }}"
                  alt="chart success"
                  class="rounded"
                />
              </div>
              
            </div>
            <span class="fw-semibold d-block mb-1">Laporan Ditolak</span>
            <h3 class="card-title mb-2">
              <?php $ff=0;?>
              @foreach($tolakverif as $ds)
              <?php $ff++; ?>
              @endforeach
              {{ $ff }}
            </h3>
            
          </div>
        </div>
      </div>
      <!-- -->

      <div class="col-lg-3 col-md-3 col-3 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{ asset('sneat/assets/img/icons/unicons/chart.png') }}"
                  alt="chart success"
                  class="rounded"
                />
              </div>
              
            </div>
            <span class="fw-semibold d-block mb-1" style="font-size:13px;">Laporan Menunggu Verifikasi</span>
            <h3 class="card-title mb-2">
              <?php $zz=0;?>
              @foreach($belumverif as $sa)
              <?php $zz++; ?>
              @endforeach
              {{ $zz }}
            </h3>
            
          </div>
        </div>
      </div>
      <!-- -->

      <div class="col-lg-3 col-md-3 col-3 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{ asset('sneat/assets/img/icons/unicons/wallet.png') }}"
                  alt="chart success"
                  class="rounded"
                />
              </div>
              
            </div>
            <span class="fw-semibold d-block mb-1">Informasi</span>
            <h3 class="card-title mb-2">
              <?php $d=0;?>
              @foreach($berita as $z)
              <?php $d++; ?>
              @endforeach
              {{ $ee }}
            </h3>
            
          </div>
        </div>
      </div>
      <!-- -->
      <div class="col-lg-3 col-md-3 col-3 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="card-title d-flex align-items-start justify-content-between">
              <div class="avatar flex-shrink-0">
                <img
                  src="{{ asset('sneat/assets/img/icons/unicons/cc-warning.png') }}"
                  alt="chart success"
                  class="rounded"
                />
              </div>
              
            </div>
            <span class="fw-semibold d-block mb-1">Kategori Informasi</span>
            <h3 class="card-title mb-2">
              <?php $h=0;?>
              @foreach($kategoriberita as $p)
              <?php $h++; ?>
              @endforeach
              {{ $h }}
            </h3>
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- kolom 2 -->
  @endif

  <form action="/dashboard/indexx" method="POST"> 
    <div class="row">
      <div class="col mb-10">
        <label for="nameBasic" class="form-label">Filter Kecamatan</label>
        <select class="form-control js-example-basic-single" name="kecamatan_id" id="kecem_id" onchange="test(this)" required>
        <option value="" selected disabled>Pilih..</option>
        <option value="0">Semua Kecamatan</option>
        @foreach($kecamatan as $ins)
        <option value="{{ $ins->id }}">{{ $ins->nama_kecamatan }}</option>
        @endforeach
      </select>
            @error('kecamatan_id')
            <div class="alert alert-danger mt-2 d-none" role="alert">
                {{ $message }}
            </div>
        @enderror
        
      </div>
   
      <div class="col mb-2">
        <br />
        <button type="submit" class="btn btn-md btn-primary" id="bt" style="display:none;"><i class="tf-icons bx bx-save"></i>CARI</button>
      </div>
    </div>
  </form>
  <br />
  <div id="muka"></div>

  <!-- ekonomi -->
  <?php $vv=0;?>
  @foreach($ekonomi as $asq)
  <?php $vv++; ?>
  @endforeach
  <!-- ideologi -->
  <?php $vv1=0;?>
  @foreach($ideologi as $asq1)
  <?php $vv1++; ?>
  @endforeach
   <!-- politik -->
   <?php $vv2=0;?>
   @foreach($politik as $asq2)
   <?php $vv2++; ?>
   @endforeach
    <!-- sosbud -->
    <?php $vv3=0;?>
    @foreach($sosbud as $asq3)
    <?php $vv3++; ?>
    @endforeach
     <!-- kkk -->
     <?php $vv4=0;?>
     @foreach($kkk as $asq4)
     <?php $vv4++; ?>
     @endforeach
 
 
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
    var users =  <?php echo json_encode($verif) ?>;
    
    Highcharts.chart('muka', {
        title: {
            text: 'Grafik Pelaporan'
        },
        subtitle: {
            text: 'SIKANDA | Sistem Informasi Kewaspadaan Dini Daerah'
        },
         xAxis: {
            categories: ['< 2022','2022']
        },
        yAxis: {
            title: {
                text: 'Data Laporan'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            }
        },
        series: [
        {
            name: 'Ekonomi',
            data: [ 0 , {{ $vv }} ]
        },
        {
            name: 'Ideologi',
            data:[ 0 , {{ $vv1 }} ]
        },
        {
            name: 'Politik',
            data:[ 0 , {{ $vv2 }} ]
        },
        {
            name: 'Sosial dan Budaya',
            data:[ 0 , {{ $vv3 }} ]
        },
        {
            name: 'Keamanan, Ketentraman dan Ketertiban',
            data:[ 0 , {{ $vv4 }} ]
        }
      ],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
});
</script>
<script type="text/javascript">
  $('#kecem_id').on('change', () => {
    
    $('#bt').trigger('click');
});
</script>
<script>
function test(a) {
  alert("Filter Grafik Berdasarkan Kecamatan "+a.options[a.selectedIndex].text);
}
</script>
   
  @endsection