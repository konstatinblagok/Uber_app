<style>
    #actions {
        margin: 2em 0;
    }
    /* Mimic table appearance */
    div.table {
        display: table;
    }
    div.table .file-row {
        display: table-row;
    }
    div.table .file-row > div {
        display: table-cell;
        vertical-align: top;
        border-top: 1px solid #ddd;
        padding: 8px;
    }
    div.table .file-row:nth-child(odd) {
        background: #f9f9f9;
    }
    /* The total progress gets shown by event listeners */
    #total-progress {
        opacity: 0;
        transition: opacity 0.3s linear;
    }

    /* Hide the progress bar when finished */
    #previews .file-row.dz-success .progress {
        opacity: 0;
        transition: opacity 0.3s linear;
    }

    /* Hide the delete button initially */
    #previews .file-row .delete {
        display: none;
    }

    /* Hide the start and cancel buttons and show the delete button */

    #previews .file-row.dz-success .start,
    #previews .file-row.dz-success .cancel {
        display: none;
    }
    #previews .file-row.dz-success .delete {
        display: block;
    }
    .preview img {
        width: 80px;
        height: 80px;
    }
</style>
<div class="media_upload_container">
    <!-- HTML heavily inspired by https://blueimp.github.io/jQuery-File-Upload/ -->
    <div id="actions" class="row">
        <div class="col-lg-12">
            <!-- The fileinput-button span is used to style the file input field as button -->
            <span class="btn btn-success fileinput-button dz-clickable">
          <i class="glyphicon glyphicon-plus"></i>
          <span>Add files...</span>
      </span>
            <button type="submit" class="btn btn-primary start">
                <i class="glyphicon glyphicon-upload"></i>
                <span>Start upload</span>
            </button>
            <button type="reset" class="btn btn-warning cancel">
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>Cancel upload</span>
            </button>
        </div>

        <div class="col-lg-12 m-t-20">
            <!-- The global file processing state -->
            <span class="fileupload-process">
        <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
          <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress=""></div>
        </div>
      </span>
        </div>
    </div>
    <div class="table table-striped files" id="previews">
        <div class="hide">
            <div id="template" class="file-row dz-image-preview">
                <!-- This is used as the file preview template -->
                <div>
                    <span class="preview"><img data-dz-thumbnail></span>
                </div>
                <div>
                    <p class="name" data-dz-name></p>
                    <strong class="error text-danger" data-dz-errormessage></strong>
                </div>
                <div>
                    <p class="size" data-dz-size></p>
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                        <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-primary start">
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Start</span>
                    </button>
                    <button data-dz-remove class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel</span>
                    </button>
                    <button data-dz-remove class="btn btn-danger delete">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span>Delete</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('dashboard-scripts')
<script>
    const mealId = $('#mealId').val();
    // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    const previewNode = document.querySelector("#template");
    previewNode.id = "";
    const previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    const removeFileFromList = (file)=>{
        const fileRef =file.previewElement;
        return fileRef!= null ? fileRef.parentNode.removeChild(file.previewElement) : void 0;
    };

    const myDropzone = new Dropzone(".media_upload_container", {
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: `/food-selection/${mealId}/media/upload/`,
        thumbnailWidth: 80,
        thumbnailHeight: 80,
        parallelUploads: 20,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#previews",
        clickable: ".fileinput-button", // Define the element that should be used as click trigger to select files.
        init: function() {
        @if(isset($meal) && $meal->media)
            const myDropzone = this;
            const files = {!! json_encode($meal->media) !!}
            for (let i in files) {
                const file = files[i];
                // this.options.addedfile.call(this, file)
                myDropzone.displayExistingFile(file, file.path);
                file.previewElement.classList.add('dz-complete','dz-success');
                // $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
            }
        @endif
        },
        removedfile: function(file) {
            if(!file.id) {
                return removeFileFromList(file);
            } else {
                // const mealId = $('#mealId').val();
                return $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    url: `/food-selection/${mealId}/media/remove`,
                    data: {id: file.id},
                    success: function (data) {
                        return removeFileFromList(file);
                        console.log("Media removed Successfully");
                    },
                    error: function (e) {
                        toastr.error('Something Went wrong');
                    }
                });
            }

        },
    });

    myDropzone.on("addedfile", function(file) {
        // Hookup the start button
        file.previewElement.querySelector(".start").onclick = function() {
            myDropzone.enqueueFile(file);
        };
    });



    myDropzone
        .on("totaluploadprogress", function(progress) {
            // Update the total progress bar
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%";
        })
        .on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1";
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
        })
        .on("queuecomplete", function(progress) {
            // Hide the total progress bar when nothing's uploading anymore
            document.querySelector("#total-progress").style.opacity = "0";
        })
        .on('success', function (file, response) {
            if (response.media_id) {
                file.id = response.media_id;
            }
        });

    // Setup the buttons for all transfers
    // The "add files" button doesn't need to be setup because the config
    // `clickable` has already been specified.
    document.querySelector("#actions .start").onclick = function() {
        myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED));
    };
    document.querySelector("#actions .cancel").onclick = function() {
        myDropzone.removeAllFiles(true);
    };

</script>
@endsection
