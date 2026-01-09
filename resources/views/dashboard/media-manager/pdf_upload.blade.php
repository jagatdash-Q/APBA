<!-- Pdf section -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModal" aria-hidden="true">
    <div class="modal-dialog" role="document" style="margin-left: 35%;
    margin-top: 15%;">
        <div class="modal-content" style="    width: 75%;">
            <form action="#" method="post" enctype="multipart/form-data" novalidate id="myform"
                class="form-pdf">
                <div class="modal-header">
                    <div class="col-md-10">
                        <h6 class="modal-title" id="exampleModalLabel">{{ __('Upload PDF') }}</h6>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
                <div class="modal-body text-sm">
                    <label for="">Upload file : </label>
                    <input type="file" name="files[]" id="files" required="required" multiple="multiple">
                    <br>
                    <span class="text-danger">* Max 10 files , Max Size: 25MB</span>
                    <img src="{{ url('assets/dashboard/images/Spinner-1s-200px.svg') }}" id="img"
                        style="display:none">
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('after-scripts')
    <script>
        $('.form-pdf').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            let TotalFiles = $('#files')[0].files.length; //Total files
            let files = $('#files')[0];
            if (TotalFiles == 0) {
                Swal.fire('Please select a file.');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            }
            let total_file_size = 0;
            for (let i = 0; i < TotalFiles; i++) {
                total_file_size += files.files[i].size;

                formData.append('files' + i, files.files[i]);
            }
            if (total_file_size > 25000000) {
                Swal.fire('Can not upload . Total file size exceeds 25MB.');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                formData.append('TotalFiles', TotalFiles);
                setTimeout(() => {
                    $.ajax({
                        type: "post",
                        url: "{{ url('admin/media-manager/pdf-upload') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        contentType: false,
                        // url:"/admin/media/check-media-data",
                        // url:
                        data: formData,
                        dataType: "json",
                        processData: false,
                        cache: false,
                        async: false,
                        success: function(response) {
                            console.log(response);
                            let status = response.status;
                            if (status == 'success') {
                                Swal.fire(response.message);
                                setTimeout(() => {
                                    location.reload();

                                }, 1500);
                            } else if (status == 'error') {
                                Swal.fire(response.message);
                                setTimeout(() => {
                                    location.reload();
                                }, 1500);
                            }
                        },
                        error: function(jqXhr) {
                            Swal.file(response.message);
                            location.reload();
                        }
                    });
                }, 250);
            }

        });
    </script>
@endpush
