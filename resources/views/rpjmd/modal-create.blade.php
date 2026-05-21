<!-- Modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <i class="menu-icon tf-icons bx bx-chat"></i><h5 class="modal-title" id="exampleModalLabel1">Tambah Data RPJMD</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="wilayah" class="form-label">WILAYAH (Kab/Kota)</label>
              @if(auth()->user()->level == 'Operator Kabupaten/Kota')
                @php
                    $user = auth()->user();
                    $userWilayah = '';
                    if (str_contains(strtolower($user->wilayah), 'barito kuala')) {
                        $userWilayah = 'Barito Kuala';
                    } elseif (str_contains(strtolower($user->wilayah), 'banjar')) {
                        $userWilayah = 'Banjar';
                    } elseif (str_contains(strtolower($user->wilayah), 'tapin')) {
                        $userWilayah = 'Tapin';
                    }
                @endphp
                <select id="wilayah" class="form-control" disabled>
                    <option value="{{ $userWilayah }}">{{ $userWilayah }}</option>
                </select>
              @else
                <select id="wilayah" class="form-control">
                    <option value="">-- Pilih Wilayah --</option>
                    <option value="Banjar">Banjar</option>
                    <option value="Barito Kuala">Barito Kuala</option>
                    <option value="Tapin">Tapin</option>
                </select>
              @endif
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-wilayah"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="no_indikator_rpjmd" class="form-label">NOMOR INDIKATOR RPJMD</label>
              <input type="text" id="no_indikator_rpjmd" class="form-control" />
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_indikator_rpjmd"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="indikator_kinerja" class="form-label">Nama Indikator Kinerja</label>
              <textarea class="form-control" id="indikator_kinerja" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-indikator_kinerja"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="spm" class="form-label">SPM</label>
              <textarea class="form-control" id="spm" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-spm"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="jenis_urusan" class="form-label">Jenis Urusan</label>
              <select id="jenis_urusan" class="form-control" required>
                    <option value="">-- Pilih Data Jenis Urusan --</option>
                    <option value="Administrasi Kependudukan & Catatan Sipil">Administrasi Kependudukan & Catatan Sipil</option>
                    <option value="Balitbang Daerah">Balitbang Daerah</option>
                    <option value="Energi & Sumber Daya Mineral">Energi & Sumber Daya Mineral</option>
                    <option value="Kehutanan">Kehutanan</option>
                    <option value="Kelautan & Perikanan">Kelautan & Perikanan</option>
                    <option value="Kesehatan">Kesehatan</option>
                    <option value="Kesehatan, PPKB">Kesehatan, PPKB</option>
                    <option value="Ketentraman, Ketertiban Umum & Perlindungan Masyarakat ">Ketentraman, Ketertiban Umum & Perlindungan Masyarakat</option>
                    <option value="Keuangan">Keuangan</option>
                    <option value="Komunikasi & Informatika">Komunikasi & Informatika</option>
                    <option value="Koperasi, Usaha Kecil & Menengah">Koperasi, Usaha Kecil & Menengah</option>
                    <option value="Lingkungan Hidup">Lingkungan Hidup</option>
                    <option value="Pangan">Pangan</option>
                    <option value="Pariwisata">Pariwisata</option>
                    <option value="Pekerjaan Umum & Penataan Ruang">Pekerjaan Umum & Penataan Ruang</option>
                    <option value="Pemberdayaan Masyarakat & Desa">Pemberdayaan Masyarakat & Desa</option>
                    <option value="Pemberdayaan Perempuan & Perlindungan Anak">Pemberdayaan Perempuan & Perlindungan Anak</option>
                    <option value="Penanaman Modal">Penanaman Modal</option>
                    <option value="Pendidikan">Pendidikan</option>
                    <option value="Perencanaan">Perencanaan</option>
                    <option value="Perhubungan">Perhubungan</option>
                    <option value="Perindustrian">Perindustrian</option>
                    <option value="Perumahan Rakyat & Kawasan Permukiman">Perumahan Rakyat & Kawasan Permukiman</option>
                    <option value="PPKB">PPKB</option>
                    <option value="Sosial">Sosial</option>
                    <option value="Sosial, Trantiblinmas">Sosial, Trantiblinmas</option>
                    <option value="Statistik">Statistik</option>
                    <option value="Tenaga Kerja">Tenaga Kerja</option>
                </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jenis_urusan"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="kategori_urusan" class="form-label">Kategori Urusan</label>
              <select id="kategori_urusan" class="form-control" required>
                    <option value="">-- Pilih Data Kategori Urusan --</option>
                    <option value="Wajib Pelayanan Dasar">Wajib Pelayanan Dasar</option>
                    <option value="Wajib Non Pelayanan Dasar">Wajib Non Pelayanan Dasar</option>
                    <option value="Pilihan">Pilihan</option>
                </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori_urusan"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="kekhususan_indikator" class="form-label">Kekhususan Indikator</label>
              <textarea class="form-control" id="kekhususan_indikator" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kekhususan_indikator"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="referensi" class="form-label">Referensi</label>
              <textarea class="form-control" id="referensi" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-referensi"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="indikator_sama" class="form-label">INDIKATOR SAMA (Kode TPB)</label>
              <select id="indikator_sama" class="form-control select2" style="width: 100%">
                  <option value="-">- (Tidak Ada Relasi)</option>
                  @foreach($indikators as $ind)
                      <option value="{{ $ind->no_indikator }}">{{ $ind->no_indikator }} - {{ $ind->nama_indikator_tpb }}</option>
                  @endforeach
              </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-indikator_sama"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="tf-icons bx bx-exit"></i>Tutup
          </button>
          <button type="button" class="btn btn-primary" id="store"><i class="tf-icons bx bx-save"></i>Simpan</button>
        </div>
      </div>
    </div>
</div>

<script>
    //button create post event
    $('body').on('click', '#btn-create-post', function () {
        //open modal
        $('#modal-create').modal('show');
    });

    //action create post
    $('#store').click(function(e) {
        e.preventDefault();

        // Reset errors
        $('.alert-danger').addClass('d-none').removeClass('d-block').html('');

        //define variable
        let wilayah = $('#wilayah').val();
        let no_indikator_rpjmd  = $('#no_indikator_rpjmd').val();
        let indikator_kinerja  = $('#indikator_kinerja').val();
        let spm  = $('#spm').val();
        let jenis_urusan = $('#jenis_urusan').val();
        let kategori_urusan  = $('#kategori_urusan').val();
        let kekhususan_indikator  = $('#kekhususan_indikator').val();
        let referensi  = $('#referensi').val();
        let indikator_sama  = $('#indikator_sama').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({
            url: "{{ route('rpjmd.store') }}",
            type: "POST",
            cache: false,
            data: {
                "wilayah": wilayah,
                "no_indikator_rpjmd": no_indikator_rpjmd,
                "indikator_kinerja": indikator_kinerja,
                "spm": spm,
                "jenis_urusan": jenis_urusan,
                "kategori_urusan": kategori_urusan,
                "kekhususan_indikator": kekhususan_indikator,
                "referensi": referensi,
                "indikator_sama": indikator_sama,
                "_token": token
            },
            success:function(response){
                //show success message
                Swal.fire({
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 1000
                });

                //close modal
                $('#modal-create').modal('hide');
                
                window.location.reload();
            },
            error:function(error){
                let errors = error.responseJSON.errors;
                if (errors) {
                    if (errors.wilayah) {
                        $('#alert-wilayah').removeClass('d-none').addClass('d-block').html(errors.wilayah[0]);
                    }
                    if (errors.no_indikator_rpjmd) {
                        $('#alert-no_indikator_rpjmd').removeClass('d-none').addClass('d-block').html(errors.no_indikator_rpjmd[0]);
                    }
                    if (errors.indikator_kinerja) {
                        $('#alert-indikator_kinerja').removeClass('d-none').addClass('d-block').html(errors.indikator_kinerja[0]);
                    }
                    if (errors.spm) {
                        $('#alert-spm').removeClass('d-none').addClass('d-block').html(errors.spm[0]);
                    }
                    if (errors.jenis_urusan) {
                        $('#alert-jenis_urusan').removeClass('d-none').addClass('d-block').html(errors.jenis_urusan[0]);
                    }
                    if (errors.kategori_urusan) {
                        $('#alert-kategori_urusan').removeClass('d-none').addClass('d-block').html(errors.kategori_urusan[0]);
                    }
                    if (errors.kekhususan_indikator) {
                        $('#alert-kekhususan_indikator').removeClass('d-none').addClass('d-block').html(errors.kekhususan_indikator[0]);
                    }
                    if (errors.referensi) {
                        $('#alert-referensi').removeClass('d-none').addClass('d-block').html(errors.referensi[0]);
                    }
                    if (errors.indikator_sama) {
                        $('#alert-indikator_sama').removeClass('d-none').addClass('d-block').html(errors.indikator_sama[0]);
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.responseJSON.message || 'Terjadi kesalahan server.'
                    });
                }
            }
        });
    });

    $(document).ready(function() {
        $('#indikator_sama').select2({
            dropdownParent: $('#modal-create')
        });
    });
</script>
