<script>
    //button create post event
    $('body').on('click', '#btn-delete-post', function () {

        let tpb_id = $(this).data('id');
        let token   = $("meta[name='csrf-token']").attr("content");

        Swal.fire({
            title: 'Apakah Kamu Yakin?',
            text: "ingin menghapus data ini!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'TIDAK',
            confirmButtonText: 'YA, HAPUS!'
        }).then((result) => {
            if (result.isConfirmed) {

                console.log('');

                //fetch to delete data
                $.ajax({

                    url: `{{ route('tpb.index') }}/${tpb_id}`,
                    type: "DELETE",
                    cache: false,
                    data: {
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

                        //remove post on table
                        $(`#index_${tpb_id}`).remove();
                        window.location.reload();
                    }
                });

                
            }
        })
        
    });
</script>