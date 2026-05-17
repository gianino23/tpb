<!-- Modal -->

<div class="modal fade" id="modal-create" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <i class="menu-icon tf-icons bx bx-chat"></i><h5 class="modal-title" id="exampleModalLabel1">Tambah Data Indikator</h5>
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
              <label for="nameBasic" class="form-label">No Indikator</label>
              <input type="text" id="no_indikator" class="form-control" />
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_indikator"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Indikator TPB</label>
              <textarea class="form-control" id="nama_indikator_tpb" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_indikator_tpb"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Indikator Yang Direncanakan Dalam RPJMD</label>
              <textarea class="form-control" id="indikator_rpjmd" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-indikator_rpjmd"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Target Yang Harus Ditetapkan Dalam RPJMD</label>
              <textarea class="form-control" id="target_rpjmd" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-target_rpjmd"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Dokumen/Data Yang Harus Disiapkan</label>
              <textarea class="form-control" id="dokumen_pendukung" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-dokumen_pendukung"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Catatan</label>
              <textarea class="form-control" id="catatan" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-catatan"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Target (Perpres 59/2017)</label>
              <textarea class="form-control" id="target_perpres59" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-target_perpres59"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Target (Perpres 59/2017) Ringkasan</label>
              <textarea class="form-control" id="ringkasan_target_perpres59" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-ringkasan_target_perpres59"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Kewenangan Kabupaten</label>
              <select class="form-control" id="kewenangan_kabupaten" required>
                  <option value="" selected disabled>Pilih..</option>
                  <option value="Kabupaten">Kewenangan Kabupaten</option>
                  <option value="-">Bukan Kewenangan Kabupaten</option>
              </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kewenangan_kabupaten"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Kewenangan Kota</label>
              <select class="form-control" id="kewenangan_kota" required>
                  <option value="" selected disabled>Pilih..</option>
                  <option value="Kota">Kewenangan Kota</option>
                  <option value="-">Bukan Kewenangan Kota</option>
              </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kewenangan_kota"></div>
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

        //define variable
        let no_indikator  = $('#no_indikator').val();
        let nama_indikator_tpb  = $('#nama_indikator_tpb').val();
        let indikator_rpjmd  = $('#indikator_rpjmd').val();
        let target_rpjmd  = $('#target_rpjmd').val();
        let dokumen_pendukung  = $('#dokumen_pendukung').val();
        let catatan  = $('#catatan').val();
        let target_perpres59  = $('#target_perpres59').val();
        let ringkasan_target_perpres59  = $('#ringkasan_target_perpres59').val();
        let kewenangan_kabupaten  = $('#kewenangan_kabupaten').val();
        let kewenangan_kota = $('#kewenangan_kota').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: "{{ route('indikator.store') }}",
            type: "POST",
            cache: false,
            data: {
                "no_indikator": no_indikator,
                "nama_indikator_tpb": nama_indikator_tpb,
                "indikator_rpjmd": indikator_rpjmd,
                "target_rpjmd": target_rpjmd,
                "dokumen_pendukung": dokumen_pendukung,
                "catatan": catatan,
                "target_perpres59": target_perpres59,
                "ringkasan_target_perpres59": ringkasan_target_perpres59,
                "kewenangan_kabupaten": kewenangan_kabupaten,
                "kewenangan_kota": kewenangan_kota,
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

                
                let pemohon = `
                    <tr id="index_${response.data.id}">
                         <td>${response.data.no_indikator}</td>
                         <td>${response.data.nama_indikator_tpb}</td>
                         <td>${response.data.indikator_rpjmd}</td>
                         <td>${response.data.target_rpjmd}</td>
                         <td>${response.data.dokumen_pendukung}</td>
                         <td>${response.data.catatan}</td>
                         <td>${response.data.target_perpres59}</td>
                         <td>${response.data.ringkasan_target_perpres59}</td>
                         <td>${response.data.kewenangan_kabupaten}</td>
                         <td>${response.data.kewenangan_kota}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <a href="javascript:void(0)" id="btn-edit-post" data-id="${response.data.id}" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"><i class="menu-icon tf-icons bx bx-copy"></i></a>
                            <a href="javascript:void(0)" id="btn-delete-post" data-id="${response.data.id}" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="menu-icon tf-icons bx bx-trash"></i></a>
                            </div>
                       </td>
                    </tr>
                `;
                
                //append to table
                $('#table').prepend(pemohon);
                
                //clear form
                $('#no_indikator').val('');
                $('#nama_indikator_tpb').val('');
                $('#indikator_rpjmd').val('');

                //close modal
                $('#modal-create').modal('hide');
                
                window.location.reload();
            },
            error:function(error){

                if(error.responseJSON.no_indikator[0]) {

                    //show alert
                    $('#alert-no_indikator').removeClass('d-none');
                    $('#alert-no_indikator').addClass('d-block');
                  
                    //add message to alert
                    $('#alert-no_indikator').html(error.responseJSON.no_indikator[0]);
                   
                } 

               


            }

        });

    });

</script>
