<!-- Modal -->

<div class="modal fade" id="modal-create" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <i class="menu-icon tf-icons bx bx-chat"></i><h5 class="modal-title" id="exampleModalLabel1">Tambah Data Capaian</h5>
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
              <label for="nameBasic" class="form-label">Data TPB</label>
              <select id="tpb_id" class="form-control" required>
                    <option value="">-- Pilih TPB --</option>
                    @foreach($tpbs as $tpb)
                        <option value="{{ $tpb->id }}">{{ $tpb->no_tpb }} | {{ $tpb->nama_tpb }}</option>
                    @endforeach
                </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tpb_id"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Data Target</label>
              <select id="target_id" class="form-control" required>
                    <option value="">-- Pilih Target --</option>
                    @foreach($targets as $target)
                        <option value="{{ $target->id }}">{{ $target->no_target }} | {{ $target->nama_target }}</option>
                    @endforeach
                </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-target_id"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Data Indikator</label>
              <select id="indikator_id" class="form-control" required>
                    <option value="">-- Pilih Indikator --</option>
                    @foreach($indikators as $indikator)
                        <option value="{{ $indikator->id }}">{{ $indikator->no_indikator }} | {{ $indikator->nama_indikator_tpb }}</option>
                    @endforeach
                </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-indikator_id"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Data RPJMD</label>
              <select id="rpjmd_id" class="form-control" required>
                    <option value="">-- Pilih Data RPJMD --</option>
                    @foreach($rpjmds as $rpjmd)
                        <option value="{{ $rpjmd->id }}">{{ $rpjmd->no_indikator_rpjmd }} | {{ $rpjmd->indikator_kinerja }}</option>
                    @endforeach
                </select>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-rpjmd_id"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">OPD</label>
              <textarea class="form-control" id="opd" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-opd"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Tahun N-4</label>
              <textarea class="form-control" id="tahun_n4" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tahun_n4"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Tahun N-3</label>
              <textarea class="form-control" id="tahun_n3" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tahun_n3"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Tahun N-2</label>
              <textarea class="form-control" id="tahun_n2" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tahun_n2"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Tahun N-1</label>
              <textarea class="form-control" id="tahun_n1" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tahun_n1"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Tahun N</label>
              <textarea class="form-control" id="tahun_n" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-tahun_n"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Gap dg Target RPJMN 2019</label>
              <textarea class="form-control" id="gap" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-gap"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Kategori Capaian</label>
              <textarea class="form-control" id="kategori_capaian" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-kategori_capaian"></div>
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
        let tpb_id  = $('#tpb_id').val();
        let target_id  = $('#target_id').val();
        let indikator_id  = $('#indikator_id').val();
        let rpjmd_id = $('#rpjmd_id').val();
        let opd  = $('#opd').val();
        let tahun_n4  = $('#tahun_n4').val();
        let tahun_n3  = $('#tahun_n3').val();
        let tahun_n2  = $('#tahun_n2').val();
        let tahun_n1  = $('#tahun_n1').val();
        let tahun_n  = $('#tahun_n').val();
        let gap  = $('#gap').val();
        let kategori_capaian  = $('#kategori_capaian').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: '/capaian',
            type: "POST",
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

                
                let pemohon = `
                    <tr id="index_${response.data.id}">
                         <td>${response.data.opd}</td>
                         <td>${response.data.tahun_n4}</td>
                         <td>${response.data.tahun_n3}</td>
                         <td>${response.data.tahun_n2}</td>
                         <td>${response.data.tahun_n1}</td>
                         <td>${response.data.tahun_n}</td>
                         <td>${response.data.gap}</td>
                         <td>${response.data.kategori_capaian}</td>
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
                $('#opd').val('');
                $('#tahun_n4').val('');
               

                //close modal
                $('#modal-create').modal('hide');
                
                window.location.reload();
            },
            error:function(error){

                if(error.responseJSON.opd[0]) {

                    //show alert
                    $('#alert-opd').removeClass('d-none');
                    $('#alert-opd').addClass('d-block');
                  
                    //add message to alert
                    $('#alert-opd').html(error.responseJSON.opd[0]);
                   
                } 

               


            }

        });

    });

</script>
