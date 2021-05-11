$(function() {
    $("#profileImage").click(function(e) {
        $("#imageUpload").click();
    });

    function fasterPreview( uploader ) {
        if ( uploader.files && uploader.files[0] ){
            $('#profileImage').attr('src',
                window.URL.createObjectURL(uploader.files[0]) );
        }
    }

    $("#imageUpload").change(function(){
        fasterPreview( this );
    });

    $(document).on('click', '.btn-modal', function(evt) {
        evt.preventDefault();
        const container = $(this).data('container');

        $.ajax({
            url: $(this).data('href'),
            dataType: 'html',
            success: function(result) {
                $(container)
                    .html(result)
                    .modal('show');
            },
        });
    });

    $(document).on('submit', 'form#employee_update_form', function(evt) {
        evt.preventDefault();
        const form = $(this);
        const data = form.serialize();

        if(!form.valid()){
            toastr.error("Invalid details provided");
            return false;
        }

        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            dataType: 'json',
            data: data,
            beforeSend: function(xhr) {
                form.find('button[type=submit]').attr('disabled', 'disabled');
            },
            success: function(result) {
                if (result.success) {
                    $('div.emp-detail-modal').modal('hide');
                    toastr.success(result.msg);
                    $('#employees-table').DataTable().ajax.reload().draw();
                } else {
                    toastr.error(result.msg);
                }
            },
        });
    });

    Dropzone.options.empDocUploadForm = {
        init: function() {
            this.on("queuecomplete", function(file, response) {
                $('#documents-table').DataTable().ajax.reload().draw();
            })
        }
    };

    $(document).on('click', '.doc_delete', (event)=>{
        const docData = $(event.target).data();
        //route('employees.documents.delete')
        Swal.fire({
            title: `Do you want to remove file "${docData.docname}"?`,
            icon: 'warning',
            confirmButtonColor: 'red',
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: `${BASE_URL}/employees/documents/delete`,
                    data: docData,
                    dataType: "json",
                    encode: true,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                }).done(function (result) {
                    if(result.status){
                        Swal.fire('File Deleted successfully', '', 'success');
                        $('#documents-table').DataTable().ajax.reload().draw();
                    } else {
                        Swal.fire('Something went wrong', '', 'error');
                    }
                });

            }
        })
    });

    $(document).on('click', '.doc_approve', (event)=>{
        const docData = $(event.target).data();
        //route('employees.documents.delete')
        Swal.fire({
            title: `Do you want to approve the file "${docData.docname}"?`,
            icon: 'info',
            showConfirmButton: true,
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: `${BASE_URL}/employees/documents/approve`,
                    data: docData,
                    dataType: "json",
                    encode: true,
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                }).done(function (result) {
                    if(result.status){
                        Swal.fire('File Approved successfully', '', 'success');
                        $('#documents-table').DataTable().ajax.reload().draw();
                    } else {
                        Swal.fire('Something went wrong', '', 'error');
                    }
                });

            }
        })
    });
});
