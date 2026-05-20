<!-- Modal -->
<div class="modal fade" id="modal-edit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel1">Edit Data TPB</h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close"
          ></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="tpb_id">
          <div class="row">
            <div class="col mb-3">
              <label for="no_tpb" class="control-label">No TPB</label>
              <input type="text" class="form-control" id="no_tpb-edit">
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_tpb-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nama_tpb" class="control-label">Nama TPB</label>
              <textarea class="form-control" id="nama_tpb-edit" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_tpb-edit"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="pilar" class="control-label">Pilar</label>
              <input type="text" class="form-control" id="pilar-edit">
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-pilar-edit"></div>
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

      let tpb_id = $(this).data('id');
      
        //fetch detail post with ajax
        $.ajax({
            url: `{{ route('tpb.index') }}/${tpb_id}`,
            type: "GET",
            cache: false,
            success:function(response){

                //fill data to form
                $('#tpb_id').val(response.data.id);
                $('#no_tpb-edit').val(response.data.no_tpb);
                $('#nama_tpb-edit').val(response.data.nama_tpb);
                $('#pilar-edit').val(response.data.pilar);

                //open modal
                $('#modal-edit').modal('show');
            }
        });
    });

    //action update post
    $('#update').click(function(e) {
        e.preventDefault();

        //define variable
        let tpb_id = $('#tpb_id').val();
        let no_tpb   = $('#no_tpb-edit').val();
        let nama_tpb   = $('#nama_tpb-edit').val();
        let pilar   = $('#pilar-edit').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: `{{ route('tpb.index') }}/${tpb_id}`,
            type: "PUT",
            cache: false,
            data: {
                "no_tpb": no_tpb,
                "nama_tpb": nama_tpb,
                "pilar": pilar,
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
                let pemohon = `
                    <tr id="index_${response.data.id}">
                        <td data-sort="${response.data.no_tpb.replace(/[^0-9]/g, '').padStart(5, '0')}">${response.data.no_tpb}</td>
                         <td>${response.data.nama_tpb}</td>
                          <td>${response.data.pilar}</td>
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
                
                window.location.reload();

            },
            error:function(error){
                
                if(error.responseJSON.no_tpb[0]) {

                //show alert
                $('#alert-no_tpb-edit').removeClass('d-none');
                $('#alert-no_tpb-edit').addClass('d-block');

                //add message to alert
                $('#alert-no_tpb-edit').html(error.responseJSON.no_tpb[0]);
                } 

                if(error.responseJSON.nama_tpb[0]) {

                //show alert
                $('#alert-nama_tpb-edit').removeClass('d-none');
                $('#alert-nama_tpb-edit').addClass('d-block');

                //add message to alert
                $('#alert-nama_tpb-edit').html(error.responseJSON.nama_tpb[0]);
                } 

                if(error.responseJSON.pilar[0]) {

                //show alert
                $('#alert-pilar-edit').removeClass('d-none');
                $('#alert-pilar-edit').addClass('d-block');

                //add message to alert
                $('#alert-pilar-edit').html(error.responseJSON.pilar[0]);
                } 

            }

        });

    });

</script>