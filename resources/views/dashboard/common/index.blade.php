<div class="modal fade mt-5" id="showsModal" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header row">
                <div class="col-md-10">
                    <h6>Image & Video Upload</h6>
                </div>
                <div class="col-md-2">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            </div>

            <?php
            $uri_path = url()->current();
            $uri_segments = explode('/', $uri_path);
            $last_url = $uri_segments[count($uri_segments) - 1];
            $_SESSION['last_url'] = $last_url;
            ?>
            <div class="modal-body">
                <iframe id="iframe" src="{{ url('') }}/admin/media-manager?type=news_image" frameborder="0"
                    style="width: 100%; height: 475px;"></iframe>
            </div>
        </div>
    </div>
</div>
