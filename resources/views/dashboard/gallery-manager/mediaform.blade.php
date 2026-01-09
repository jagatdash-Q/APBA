<!-- file upload form -->
<div id="collapse-upload" class="collapse media-forms">
    <form id="upload-form" action="{{ route('admin.media-manager.upload') }}" method="post" enctype="multipart/form-data"
        class="form-inline dropzone" role="form">
        @csrf
        <div class="form-group fallback">
            <label for="filedata">Upload file</label>
            <input type="file" name="filedata[]" id="filedata" class="form-control form-control-sm" multiple
                accept="image/*">
            <button class="btn btn-sm btn-primary"><span class="fa fa-upload"></span> Start Upload</button>
        </div>
        <div class="meter"><span class="roller"></span></div>
        <button type="button" class="btn btn-sm btn-primary btn-upload"><span class="fa fa-upload"></span> Start
            Upload</button>
    </form>
    <p class="text-muted small">Upload files (Maximum Size: <?php echo '30'; ?> MB and maximum 10 files at a time and
        support file formats : .jpeg,.jpg,.png,.gif,.bmp,.mp4,.webm,.ogg,.pdf,.doc )</p>
</div>
<!-- /.file upload form -->
