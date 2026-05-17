<!-- Modal -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<div class="modal fade" id="modal-create" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <i class="menu-icon tf-icons bx bx-chat"></i><h5 class="modal-title" id="exampleModalLabel1">Tambah Data Target</h5>
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
              <label for="nameBasic" class="form-label">No Target</label>
              <input type="text" id="no_target" class="form-control" />
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-no_target"></div>
            </div>
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="nameBasic" class="form-label">Nama Target</label>
              <textarea class="form-control" id="nama_target" style="min-width: 100%"></textarea>
              <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_target"></div>
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
        let no_target  = $('#no_target').val();
        let nama_target  = $('#nama_target').val();
        let token   = $("meta[name='csrf-token']").attr("content");
        
        //ajax
        $.ajax({

            url: "{{ route('target.store') }}",
            type: "POST",
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

                
                let pemohon = `
                    <tr id="index_${response.data.id}">
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
                
                //append to table
                $('#table').prepend(pemohon);
                
                //clear form
                $('#no_target').val('');
                $('#nama_target').val('');

                //close modal
                $('#modal-create').modal('hide');
                
                window.location.reload();
            },
            error:function(error){


                if(error.responseJSON.no_target[0]) {

                  //show alert
                  $('#alert-no_target').removeClass('d-none');
                  $('#alert-no_target').addClass('d-block');

                  //add message to alert
                  $('#alert-no_target').html(error.responseJSON.no_target[0]);

                  } 

                  if(error.responseJSON.nama_target[0]) {

                  //show alert
                  $('#alert-nama_target').removeClass('d-none');
                  $('#alert-nama_target').addClass('d-block');

                  //add message to alert
                  $('#alert-nama_target').html(error.responseJSON.nama_target[0]);

                  } 


            }

        });

    });

</script>
