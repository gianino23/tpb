<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Edit Data Target</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="indikator_id">
          <div class="row">
            <div class="col mb-3">
              <label for="target_id-edit" class="form-label">Data Indikator TPB</label>
              <select id="target_id-edit" class="form-control select2" style="width: 100%">
                  <option value="">Pilih Data Indikator TPB</option>
                  @foreach($targets as $target)
                  <option value="{{ $target->id }}" data-nama="{{ $target->nama_target }}">{{ $target->no_target }} - {{ $target->nama_target }}</option>
                  @endforeach
              </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-target_id-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Target Yang Harus Ditetapkan Dalam RPJMD</label>
              <textarea class="form-control" id="target_rpjmd-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-target_rpjmd-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Dokumen/Data Yang Harus Disiapkan</label>
              <textarea class="form-control" id="dokumen_pendukung-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-dokumen_pendukung-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Catatan</label>
              <textarea class="form-control" id="catatan-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-catatan-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Target (Perpres 59/2017)</label>
              <textarea class="form-control" id="target_perpres59-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-target_perpres59-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Target (Perpres 59/2017) Ringkasan</label>
              <textarea class="form-control" id="ringkasan_target_perpres59-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-ringkasan_target_perpres59-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Kewenangan Kabupaten</label>
              <select class="form-control" id="kewenangan_kabupaten-edit" required>
                  <option value="" selected disabled>Pilih..</option>
                  <option value="Kabupaten">Kewenangan Kabupaten</option>
                  <option value="-">Bukan Kewenangan Kabupaten</option>
              </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kewenangan_kabupaten-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Kewenangan Kota</label>
              <select class="form-control" id="kewenangan_kota-edit" required>
                  <option value="" selected disabled>Pilih..</option>
                  <option value="Kota">Kewenangan Kota</option>
                  <option value="-">Bukan Kewenangan Kota</option>
              </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kewenangan_kota-edit"></div>
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

      let indikator_id = $(this).data('id');
      
        //fetch detail post with ajax
        $.ajax({
            url: `{{ route('indikator.index') }}/${indikator_id}`,
            type: "GET",
            cache: false,
            success:function(response){

                //fill data to form
                $('#indikator_id').val(response.data.id);
                $('#target_id-edit').val(response.data.target_id).trigger('change');
                $('#target_rpjmd-edit').val(response.data.target_rpjmd);
                $('#dokumen_pendukung-edit').val(response.data.dokumen_pendukung);
                $('#catatan-edit').val(response.data.catatan);
                $('#target_perpres59-edit').val(response.data.target_perpres59);
                $('#ringkasan_target_perpres59-edit').val(response.data.ringkasan_target_perpres59);
                $('#kewenangan_kabupaten-edit').val(response.data.kewenangan_kabupaten);
                $('#kewenangan_kota-edit').val(response.data.kewenangan_kota);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    //action update post
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let indikator_id = $('#indikator_id').val();
        let target_id  = $('#target_id-edit').val();
        let target_rpjmd  = $('#target_rpjmd-edit').val();
        let dokumen_pendukung  = $('#dokumen_pendukung-edit').val();
        let catatan  = $('#catatan-edit').val();
        let target_perpres59  = $('#target_perpres59-edit').val();
        let ringkasan_target_perpres59  = $('#ringkasan_target_perpres59-edit').val();
        let kewenangan_kabupaten  = $('#kewenangan_kabupaten-edit').val();
        let kewenangan_kota = $('#kewenangan_kota-edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `{{ route('indikator.index') }}/${indikator_id}`,
            type: "PUT",
            cache: false,
            data: {
                "target_id": target_id,
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
                
                if(error.responseJSON.target_id && error.responseJSON.target_id[0]) {
                    $('#alert-target_id-edit').removeClass('d-none');
                    $('#alert-target_id-edit').addClass('d-block');
                    $('#alert-target_id-edit').html(error.responseJSON.target_id[0]);
                } 

                

            }

        });

    });

    $(document).ready(function() {
        $('#target_id-edit').select2({
            dropdownParent: $('#modal-edit')
        });
    });
</script>