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
            <input type="hidden" id="target_id">
          <div class="row">
            <div class="col mb-3">
              <label for="no_target" class="control-label">No Indikator</label>
              <input type="text" class="form-control" id="no_target-edit">
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_target-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nama_target" class="control-label">Indikator TPB</label>
              <textarea class="form-control" id="nama_target-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_target-edit"></div>
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

      let target_id = $(this).data('id');
      
        //fetch detail post with ajax
        $.ajax({
            url: `{{ route('target.index') }}/${target_id}`,
            type: "GET",
            cache: false,
            success:function(response){

                //fill data to form
                $('#target_id').val(response.data.id);
                $('#no_target-edit').val(response.data.no_target);
                $('#nama_target-edit').val(response.data.nama_target);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    //action update post
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let target_id = $('#target_id').val();
        let no_target   = $('#no_target-edit').val();
        let nama_target   = $('#nama_target-edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `{{ route('target.index') }}/${target_id}`,
            type: "PUT",
            cache: false,
            data: {
                "no_target": no_target,
                "nama_target": nama_target,
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
                

                if(error.responseJSON.no_target[0]) {

                //show alert
                $('#alert-no_target-edit').removeClass('d-none');
                $('#alert-no_target-edit').addClass('d-block');

                //add message to alert
                $('#alert-no_target-edit').html(error.responseJSON.no_target[0]);
                } 

                if(error.responseJSON.nama_target[0]) {

                //show alert
                $('#alert-nama_target-edit').removeClass('d-none');
                $('#alert-nama_target-edit').addClass('d-block');

                //add message to alert
                $('#alert-nama_target-edit').html(error.responseJSON.nama_target[0]);
                } 

            }

        });

    });

</script>