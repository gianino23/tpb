@extends('layouts.admin')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
   
   
  

    <!-- Responsive Table -->
    @if(session('import_summary'))
        <div class="alert alert-info">
            <h5>Ringkasan Import:</h5>
            <p>✅ Berhasil diimpor: {{ session('import_summary')['success'] }} baris</p>
            <p>⚠️ Berhasil dengan peringatan (format catatan tidak sesuai): {{ session('import_summary')['warning'] }} baris</p>
            <p>❌ Gagal diimpor: {{ session('import_summary')['failed'] }} baris</p>
            @if(count(session('import_summary')['errors']) > 0)
                <hr>
                <h6>Detail Error:</h6>
                <ul style="max-height: 150px; overflow-y: auto;">
                    @foreach(session('import_summary')['errors'] as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col mb-6">
            <h4 class=""><span class="text-muted fw-light">Data /</span> Target </h4>
        
          </div>
          <div class="col mb-6">
            @if(auth()->user()->level == 'Administrator' || auth()->user()->level == 'Operator Kabupaten/Kota')
            <a href="javascript:void(0)" class="btn rounded-pill btn-primary mb-2" id="btn-create-post" style="float:right; margin-left: 10px;"><i class="menu-icon tf-icons bx bx-copy"></i>TAMBAH DATA</a>
            <a href="javascript:void(0)" class="btn rounded-pill btn-success mb-2" data-bs-toggle="modal" data-bs-target="#modal-import" style="float:right"><i class="menu-icon tf-icons bx bx-upload"></i>UPLOAD EXCEL</a>
            @endif
          </div>
        </div>
       
      <div class="table-responsive">
        <table id="table" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr class="text-nowrap">
              <th>Pilar</th>
              <th>No Indikator</th>
              <th>Indikator TPB</th>

              <th>Target Yang Harus Ditetapkan Dalam RPJMD</th>
              <th>Dokumen/Data Yang Harus Disiapkan</th>
              <th>Catatan</th>
              <th>Target (Perpres 59/2017)</th>
              <th>Target (Perpres 59/2017) - Ringkasan</th>
              <th>Kewenangan Kabupaten</th>
              <th>Kewenangan Kota</th>
              <th>Status</th>
              <th style="width:150px"></th>
              
            </tr>
          </thead>
          <tbody>
            
            @foreach($indikators as $data)
           
            <tr id="index_{{ $data->id }}">
              <td>{{ $data->target && $data->target->tpb ? $data->target->tpb->pilar : '-' }}</td>
              <td>{{ $data->target ? $data->target->no_target : '-' }}</td> 
              <td>{{ $data->target ? $data->target->nama_target : '-' }}</td>

              <td>{{ $data->target_rpjmd }}</td>
              <td>{{ $data->dokumen_pendukung }}</td>
              <td>{{ $data->catatan }}</td>
              <td>{{ $data->target_perpres59 }}</td>
              <td>{{ $data->ringkasan_target_perpres59 }}</td>
              <td>{{ $data->kewenangan_kabupaten }}</td>
              <td>{{ $data->kewenangan_kota }}</td>
              <td>
                @if($data->status == 'Terverifikasi')
                    <span class="badge bg-success">Terverifikasi</span>
                @elseif($data->status == 'Ditolak')
                    <span class="badge bg-danger">Ditolak</span>
                @else
                    <span class="badge bg-warning">Menunggu Validasi</span>
                @endif
                @if($data->keterangan_verifikasi)
                    <br><small class="text-muted">{{ $data->keterangan_verifikasi }}</small>
                @endif
              </td>
               <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                        @if(auth()->user()->level == 'Administrator' || auth()->user()->level == 'Operator Kabupaten/Kota')
                            <a href="javascript:void(0)" id="btn-edit-post" data-id="{{ $data->id }}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"><i class="tf-icons bx bx-copy"></i></a>
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="{{ $data->id }}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="tf-icons bx bx-trash"></i></a>
                        @endif
                    </div>
               </td>
            </tr>
           @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <!--/ Responsive Table -->
  </div>
</div>
  <!-- / Content -->
@include('indikator.modal-create')
@include('indikator.modal-edit')
@include('indikator.delete-post')
@include('indikator.modal-import')

<script>
function verifyData(id) {
    Swal.fire({
        title: 'Verifikasi Data',
        input: 'textarea',
        inputLabel: 'Keterangan Tambahan (Opsional)',
        inputPlaceholder: 'Catatan tambahan saat menerima data...',
        showCancelButton: true,
        confirmButtonText: 'Verifikasi & Terima',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#28a745'
    }).then((result) => {
        if (result.isConfirmed) {
            submitReview(id, 'verify', result.value);
        }
    });
}

function rejectData(id) {
    Swal.fire({
        title: 'Tolak Data',
        input: 'textarea',
        inputLabel: 'Alasan Penolakan (Wajib)',
        inputPlaceholder: 'Masukkan alasan kenapa data ditolak...',
        showCancelButton: true,
        confirmButtonText: 'Tolak Data',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545',
        inputValidator: (value) => {
            if (!value) {
                return 'Keterangan wajib diisi jika menolak data!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            submitReview(id, 'reject', result.value);
        }
    });
}

function submitReview(id, action, keterangan) {
    let url = action === 'verify' ? `/indikator/verify/${id}` : `/indikator/reject/${id}`;
    let token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: token,
            keterangan_verifikasi: keterangan
        },
        success: function(response) {
            Swal.fire('Berhasil', response.success || 'Data berhasil diproses', 'success').then(() => {
                location.reload();
            });
        },
        error: function(err) {
            Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
        }
    });
}
</script>

@endsection