<style>
    .media-inner {
        height: 110px;
        width: 200px;
        padding: 3px
    }

    .image-design {
        max-height: 110px;
        max-width: 100%;
        cursor: pointer
    }
</style>

<div id="masonry-layout">
    <!-- folders -->

    <!-- files -->
    <?php
    $choose_type = Session::get('choose_type');
    $catId = Session::get('catId');
    $showsid = Session::get('showsid');
    
    ?>
    <?php if (isset($media['files'])) {
    ?>
    <?php $m = 0;
        foreach ($media['files'] as $file) {
            // if ($file['file_ext'] == 'pdf') continue;
            $m++;
            if (str_contains($file['file_type'], 'image') || str_contains($file['file_type'], 'pdf')  || (str_contains($file['file_type'], 'video')) && ($choose_type == 'news_image')) {
                $length = (count($media['files']));
                $total_num_row = ceil($length / 5);


                $reminder = (($m - 1) % 5);
                $this_row = ceil($m / 5) - 1;
                $left = $reminder * 19.99;
                $top = $this_row * 167;
        ?>

    <?php if (($m - 1 % 5) == 0) { ?>
    <br>
    <?php } ?>
    <div class=""
        style="min-height: 150px;<?php echo 'width:' . $file['width_x'] . 'px'; ?>; position: absolute;  left : <?php echo $left; ?>% ;  top : <?php echo $top; ?>px;">
        <?php //echo "<pre>"; print_r($media); exit;
        ?>
        <div class="cover"></div>

        <div class="media-inner">
            <a class="mfp-image" data-group="1" title="<?php echo $file['file_name']; ?>" href="#">
                @if (str_contains($file['file_type'], 'image'))
                    <img src="{{ $file['media_url'] }}" id="<?php echo $file['name']; ?>" alt="<?php echo $file['name']; ?>"
                        class="image-design" onclick="get_value('<?php echo $file['file_name']; ?>');" />
                @elseif(str_contains($file['file_type'], 'video'))
                    <video width="100%" controls>
                        <source src="{{ asset($file['path']) }}" type="{{ $file['file_type'] }}">
                        Your browser does not support HTML video.
                    </video>
                @elseif(str_contains($file['file_type'], 'pdf'))
                    <img src="{{ asset('assets/dashboard/images/PDF_file_icon.svg') }}" alt="Icon" width="200" max-height="120" height="100" style="object-fit: fill;">
                @endif
            </a>
            <div class="media-title">
                <a class="mfp-image" data-group="2" title="<?php echo $file['file_name']; ?>" onclick="get_value(this.id);"
                    id="<?php echo $file['file_name']; ?>" href="#">
                    <?php echo $file['file_name']; ?>
                </a>
            </div>
        </div>


        <script>
            function get_value(txt) {
                var str = txt.split(".");
                console.log(str);
                // if(str[1]=='jpg' || str[1]=='jpeg'){
                const valid_file_format = ["jpeg", "jpg", "png", "gif", "bmp", "mp4", "webm", "ogg","svg" , "pdf"];
                console.log(str);
                if (valid_file_format.includes(str[1])) {

                    $.ajax({
                        method: 'post',
                        url: "<?php echo url('admin/media-manager/get-media-data'); ?>",
                        data: 'imgvalue=' + txt,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            window.parent.closeModal();
                        }
                    });
                } else {
                    alert('You can choose only Image / Video.');
                }
            }
        </script>
    </div>
    <?php }
        }
    } ?>
</div>
