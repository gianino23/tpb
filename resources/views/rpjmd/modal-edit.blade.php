<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Edit Data RPJMD</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="rpjmd_id">
            <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">No Indikator RPJMD</label>
              <input type="text" id="no_indikator_rpjmd-edit" class="form-control" />
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_indikator_rpjmd-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Nama Indikator Kinerja</label>
              <textarea class="form-control" id="indikator_kinerja-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-indikator_kinerja-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">SPM</label>
              <textarea class="form-control" id="spm-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-spm-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Jenis Urusan</label>
              <select id="jenis_urusan-edit" class="form-control" required>
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
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-jenis_urusan-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Kategori Urusan</label>
              <select id="kategori_urusan-edit" class="form-control" required>
                    <option value="">-- Pilih Data Kategori Urusan --</option>
                    <option value="Wajib Pelayanan Dasar">Wajib Pelayanan Dasar</option>
                    <option value="Wajib Non Pelayanan Dasar">Wajib Non Pelayanan Dasar</option>
                    <option value="Pilihan">Pilihan</option>
                </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori_urusan-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Kekhususan Indikator</label>
              <textarea class="form-control" id="kekhususan_indikator-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kekhususan_indikator-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Referensi</label>
              <textarea class="form-control" id="referensi-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-referensi-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Indikator Sama</label>
              <textarea class="form-control" id="indikator_sama-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-indikator_sama-edit"></div>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            <i class="tf-icons bx bx-exit"></i>Tutup
          </button>
          <button type="button" class="btn btn-primary" id="update"> <i class="tf-icons bx bx-save"></i>UPDATE</button>
        </div>
      </div>
    </div>
  </div>


<script>
    //button create post event
    $('body').on('click', '#btn-edit-post', function () {

      let rpjmd_id = $(this).data('id');
      
        //fetch detail post with ajax
        $.ajax({
            url: `{{ route('rpjmd.index') }}/${rpjmd_id}`,
            type: "GET",
            cache: false,
            success:function(response){

                //fill data to form
                $('#rpjmd_id').val(response.data.id);
                $('#no_indikator_rpjmd-edit').val(response.data.no_indikator_rpjmd);
                $('#indikator_kinerja-edit').val(response.data.indikator_kinerja);
                $('#spm-edit').val(response.data.spm);
                $('#jenis_urusan-edit').val(response.data.jenis_urusan);
                $('#kategori_urusan-edit').val(response.data.kategori_urusan);
                $('#kekhususan_indikator-edit').val(response.data.kekhususan_indikator);
                $('#referensi-edit').val(response.data.referensi);
                $('#indikator_sama-edit').val(response.data.indikator_sama);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    //action update post
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let rpjmd_id = $('#rpjmd_id').val();
        let no_indikator_rpjmd  = $('#no_indikator_rpjmd-edit').val();
        let indikator_kinerja  = $('#indikator_kinerja-edit').val();
        let spm  = $('#spm-edit').val();
        let jenis_urusan  = $('#jenis_urusan-edit').val();
        let kategori_urusan  = $('#kategori_urusan-edit').val();
        let kekhususan_indikator  = $('#kekhususan_indikator-edit').val();
        let referensi  = $('#referensi-edit').val();
        let indikator_sama  = $('#indikator_sama-edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `{{ route('rpjmd.index') }}/${rpjmd_id}`,
            type: "PUT",
            cache: false,
            data: {
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
                    type: 'success',
                    icon: 'success',
                    title: `${response.message}`,
                    showConfirmButton: false,
                    timer: 1000
                });

                //data post
                /*
                let pemohon = `
                    <tr id="index_${response.data.id}">
                        <td>${response.data.tpb_id}</td>
                         <td>${response.data.no_target}</td>
                          <td>${response.data.nama_target}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"><i class="menu-icon tf-icons bx bx-copy"></i></a>
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="menu-icon tf-icons bx bx-trash"></i></a>
                            </div>
                       </td>
                    </tr>
                `;
                
                //append to post data
                $(`#index_${response.data.id}`).replaceWith(pemohon);

                //close modal
                $('#modal-edit').modal('hide');
                */
                window.location.reload();

            },
            error:function(error){
                
                if(error.responseJSON.no_indikator_rpjmd[0]) {

                //show alert
                $('#alert-no_indikator_rpjmd-edit').removeClass('d-none');
                $('#alert-no_indikator_rpjmd-edit').addClass('d-block');

                //add message to alert
                $('#alert-no_indikator_rpjmd-edit').html(error.responseJSON.no_indikator_rpjmd[0]);
                } 

                

            }

        });

    });

</script>