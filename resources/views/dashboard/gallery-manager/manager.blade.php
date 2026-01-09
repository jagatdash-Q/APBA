<link rel="stylesheet" href="{{ asset('assets/dashboard/media_manager/gallery-manager/bootstrap/bootstrap.min.css') }}">
<script src="{{ asset('assets/dashboard/media_manager/gallery-manager/jquey/jquery.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/media_manager/gallery-manager/jquey/bootstrap.min.js') }}"></script>
<div id="media-manager" class="container">

    <!-- toolbar container -->

    <div id="controls" class="row">
        <div class="col-md-12">
            <div class="btn-toolbar" role="toolbar" area-label="toolbar of control buttons" title="Toggle Folder Lists">
                <div class="btn-group hidden-md-up" role="group" area-label="show off-canvas folders list">
                    <button type="button" class="btn btn-secondary btn btn-sm btn-off-canvas"><span
                            class="fa fa-list"></span></button>
                </div>
                <div class="btn-group" role="group" area-label="upload media" title="Upload">
                    <button type="button" data-toggle="collapse" data-target="#collapse-upload"
                        class="btn btn-success btn-sm"><span class="fa fa-upload"></span> <span class="hidden-sm-down">
                            Image & Video Upload</span></button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.toolbar container -->
    <!-- main container -->

    <div class="row wrapper">
        <!-- media container -->
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 main-section">
            @include('dashboard/gallery-manager/mediaform')
            @include('dashboard/gallery-manager/medialayout')
            <?php if (isset($_SESSION['last_url'])) {
        if ($_SESSION['last_url']  != 'media-manager') {
      ?>
            <?php
        }
      } ?>
        </div>
        <!-- /.media container -->
    </div>


</div>
</div>

<script>
    const site_url = '<?php echo URL::to('/admin/media-manager/index'); ?>';
    const max_size = 30;
    const max_files = 10;
</script>
