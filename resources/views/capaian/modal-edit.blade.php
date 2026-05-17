<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Edit Data Capaian</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="capaian_id">
            <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Data TPB</label>
              <select id="tpb_id-edit" class="form-control" required>
                    <option value="">-- Pilih TPB --</option>
                    @foreach($tpbs as $tpb)
                        <option value="{{ $tpb->id }}">{{ $tpb->no_tpb }} | {{ $tpb->nama_tpb }}</option>
                    @endforeach
                </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tpb_id-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Data Target</label>
              <select id="target_id-edit" class="form-control" required>
                    <option value="">-- Pilih Target --</option>
                    @foreach($targets as $target)
                        <option value="{{ $target->id }}">{{ $target->no_target }} | {{ $target->nama_target }}</option>
                    @endforeach
                </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-target_id-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Data Indikator</label>
              <select id="indikator_id-edit" class="form-control" required>
                    <option value="">-- Pilih Indikator --</option>
                    @foreach($indikators as $indikator)
                        <option value="{{ $indikator->id }}">{{ $indikator->no_indikator }} | {{ $indikator->nama_indikator_tpb }}</option>
                    @endforeach
                </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-indikator_id-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Data RPJMD</label>
              <select id="rpjmd_id-edit" class="form-control" required>
                    <option value="">-- Pilih Data RPJMD --</option>
                    @foreach($rpjmds as $rpjmd)
                        <option value="{{ $rpjmd->id }}">{{ $rpjmd->no_indikator_rpjmd }} | {{ $rpjmd->indikator_kinerja }}</option>
                    @endforeach
                </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-rpjmd_id-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">OPD</label>
              <textarea class="form-control" id="opd-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-opd-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Tahun N-4</label>
              <textarea class="form-control" id="tahun_n4-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tahun_n4-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Tahun N-3</label>
              <textarea class="form-control" id="tahun_n3-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tahun_n3-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Tahun N-2</label>
              <textarea class="form-control" id="tahun_n2-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tahun_n2-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Tahun N-1</label>
              <textarea class="form-control" id="tahun_n1-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tahun_n1-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Tahun N</label>
              <textarea class="form-control" id="tahun_n-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tahun_n-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Gap dg Target RPJMN 2019</label>
              <textarea class="form-control" id="gap-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-gap-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Kategori Capaian</label>
              <textarea class="form-control" id="kategori_capaian-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori_capaian-edit"></div>
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

      let capaian_id = $(this).data('id');
      
        //fetch detail post with ajax
        $.ajax({
            url: `/capaian/${capaian_id}`,
            type: "GET",
            cache: false,
            success:function(response){

                //fill data to form
                $('#capaian_id').val(response.data.id);
                $('#tpb_id-edit').val(response.data.tpb_id);
                $('#target_id-edit').val(response.data.target_id);
                $('#indikator_id-edit').val(response.data.indikator_id);
                $('#rpjmd_id-edit').val(response.data.rpjmd_id);
                $('#opd-edit').val(response.data.opd);
                $('#tahun_n4-edit').val(response.data.tahun_n4);
                $('#tahun_n3-edit').val(response.data.tahun_n3);
                $('#tahun_n2-edit').val(response.data.tahun_n2);
                $('#tahun_n1-edit').val(response.data.tahun_n1);
                $('#tahun_n-edit').val(response.data.tahun_n);
                $('#gap-edit').val(response.data.gap);
                $('#kategori_capaian-edit').val(response.data.kategori_capaian);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    //action update post
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let capaian_id = $('#capaian_id').val();
        let tpb_id  = $('#tpb_id-edit').val();
        let target_id  = $('#target_id-edit').val();
        let indikator_id  = $('#indikator_id-edit').val();
        let rpjmd_id = $('#rpjmd_id-edit').val();
        let opd  = $('#opd-edit').val();
        let tahun_n4  = $('#tahun_n4-edit').val();
        let tahun_n3  = $('#tahun_n3-edit').val();
        let tahun_n2  = $('#tahun_n2-edit').val();
        let tahun_n1  = $('#tahun_n1-edit').val();
        let tahun_n  = $('#tahun_n-edit').val();
        let gap  = $('#gap-edit').val();
        let kategori_capaian  = $('#kategori_capaian-edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `/capaian/${capaian_id}`,
            type: "PUT",
            cache: false,
            data: {
               "tpb_id": tpb_id,
                "target_id": target_id,
                "indikator_id": indikator_id,
                "rpjmd_id": rpjmd_id,
                "opd": opd,
                "tahun_n4": tahun_n4,
                "tahun_n3": tahun_n3,
                "tahun_n2": tahun_n2,
                "tahun_n1": tahun_n1,
                "tahun_n": tahun_n,
                "gap": gap,
                "kategori_capaian": kategori_capaian,
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
                
                if(error.responseJSON.tpb_id[0]) {

                //show alert
                $('#alert-tpb_id-edit').removeClass('d-none');
                $('#alert-tpb_id-edit').addClass('d-block');

                //add message to alert
                $('#alert-tpb_id-edit').html(error.responseJSON.tpb_id[0]);
                } 

                

            }

        });

    });

</script>