@php
    $alt_banner_tag = $banner_img = '';
    $menu_banner = '';
    $image_path = '';
    if (!empty($data) && !empty($data->imagepath)) {
        $image_path = $data->imagepath;
    }
@endphp

@if (isset($data->menus) && $data->menus != null)
    @php
        $menu_link = $data->menus->link;
    @endphp

    @if (count($data->menus->menu_banner_management) > 0)
        @php
            
            if (isset($data->menus->menu_banner_management[0]) && $data->menus->menu_banner_management[0]->web_banner != null) {
                $banner_img = $data->menus->menu_banner_management[0]->web_banner->file_name;
            } else {
                $banner_img = '';
            }
            $menu_banner = $data->menus->menu_banner_management[0];
            if ($menu_banner->web_banner != null) {
                $alt_banner_tag = $menu_banner->web_banner->alt_tag;
            }
        @endphp

        <style>
            @media only screen and (min-width: 769px) {
                .innerPage_banner_title {
                    left: <?php echo $menu_banner->banner_title_left_pos_web; ?>%;
                    top: <?php echo $menu_banner->banner_title_top_pos_web; ?>%;
                }

                .innerPage_banner_desc {
                    left: <?php echo $menu_banner->banner_desc_left_pos_web; ?>%;
                    top: <?php echo $menu_banner->banner_desc_top_pos_web; ?>%;
                }

                .innerPage_banner_link {
                    left: <?php echo $menu_banner->button_name_left_pos_web; ?>%;
                    top: <?php echo $menu_banner->button_name_top_pos_web; ?>%;
                }
            }

            @media only screen and (min-width: 577px) and (max-width:768px) {
                .innerPage_banner_title {
                    left: <?php echo $menu_banner->banner_title_left_pos_tablet; ?>%;
                    top: <?php echo $menu_banner->banner_title_top_pos_tablet; ?>%;
                }

                .innerPage_banner_desc {
                    left: <?php echo $menu_banner->banner_desc_left_pos_tablet; ?>%;
                    top: <?php echo $menu_banner->banner_desc_top_pos_tablet; ?>%;
                }

                .innerPage_banner_link {
                    left: <?php echo $menu_banner->button_name_left_pos_tablet; ?>%;
                    top: <?php echo $menu_banner->button_name_top_pos_tablet; ?>%;
                }
            }

            @media only screen and (max-width: 576px) {
                .innerPage_banner_title {
                    left: <?php echo $menu_banner->banner_title_left_pos_mobile; ?>%;
                    top: <?php echo $menu_banner->banner_title_top_pos_mobile; ?>%;
                }

                .innerPage_banner_desc {
                    left: <?php echo $menu_banner->banner_desc_left_pos_mobile; ?>%;
                    top: <?php echo $menu_banner->banner_desc_top_pos_mobile; ?>%;
                }

                .innerPage_banner_link {
                    left: <?php echo $menu_banner->button_name_left_pos_mobile; ?>%;
                    top: <?php echo $menu_banner->button_name_top_pos_mobile; ?>%;
                }
            }
        </style>
    @endif
@endif


<div class="innerPage_banner_content">
    <img src="{{ $image_path . $banner_img }}" class="innerPage_banner_img" alt="{{ $alt_banner_tag }}">
    <video autoplay muted loop playsinline class="d-block innerPage_banner_img video_elem" style="display:none" id="video_elem">
        <source src="{{ $image_path . $banner_img }}" type="video/{{ pathinfo($banner_img, PATHINFO_EXTENSION) }}"
            id="video_src">
        Your browser does not support HTML video.
    </video>
    <h1 class="innerPage_banner_title">{{ $menu_banner != null ? $menu_banner->banner_title : '' }}</h1>
    <p class="innerPage_banner_desc">{{ $menu_banner != null ? $menu_banner->banner_desc : '' }}</p>
    @if ($menu_banner != null && $menu_banner->button_link != '')
        <span class="innerPage_banner_link">
            <a class="trasparent-btn-white" style="bottom: auto !important;"
                href="{{ $menu_banner->button_link }}">{{ $menu_banner->button_name }}</a>
        </span>
    @endif
</div>


@php
    $banner_web_img = $banner_tablet_img = $banner_mobile_img = url('') . '/assets/ui/img/image_not_found.jpg';
    if (isset($data->menus) && $data->menus != null) {
        if (count($data->menus->menu_banner_management) > 0) {
            if ($data->menus->menu_banner_management[0]->web_banner != null) {
                $banner_web_img = $data->imagepath . $data->menus->menu_banner_management[0]->web_banner->file_name;
            }
    
            if ($data->menus->menu_banner_management[0]->tablet_banner != null) {
                $banner_tablet_img = $data->imagepath . $data->menus->menu_banner_management[0]->tablet_banner->file_name;
            }
    
            if ($data->menus->menu_banner_management[0]->mobile_banner != null) {
                $banner_mobile_img = $data->imagepath . $data->menus->menu_banner_management[0]->mobile_banner->file_name;
            }
        }
    }
@endphp

<script>
    $(document).ready(function() {
        var screen_width = document.body.clientWidth;
        var video = document.getElementById('video_elem');

        if (screen_width >= 768 && $(".innerPage_banner_img").length > 0) {
            @if (in_array(pathinfo($banner_img, PATHINFO_EXTENSION), ['jpeg', 'jpg', 'png', 'gif', 'bmp']))
                document.querySelector(".innerPage_banner_img").src = "<?php echo $banner_web_img; ?>"
                $('#video_elem').remove();
                $('.innerPage_banner_img').css("display", "block");
            @elseif (in_array(pathinfo($banner_img, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                $('.innerPage_banner_img').css("display", "none");
                $('#video_elem').css("display", "block");
                let source = document.getElementById("video_src");
                source.setAttribute('src', '<?php echo $banner_web_img; ?>');
                source.setAttribute('type', 'video/<?php echo pathinfo($banner_img, PATHINFO_EXTENSION); ?>');
                video.load();
            @endif
        }
        if (screen.width <= 768 && screen.width >= 576 && $(".innerPage_banner_img").length > 0){
            @if (in_array(pathinfo($banner_tablet_img, PATHINFO_EXTENSION), ['jpeg', 'jpg', 'png', 'gif', 'bmp']))
                document.querySelector(".innerPage_banner_img").src = "<?php echo $banner_tablet_img; ?>"
                $('#video_elem').remove();
                $('.innerPage_banner_img').css("display", "block");
            @elseif (in_array(pathinfo($banner_tablet_img, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                $('.innerPage_banner_img').css("display", "none");
                $('#video_elem').css("display", "block");
                let source = document.getElementById("video_src");
                source.setAttribute('src', '<?php echo $banner_tablet_img; ?>');
                source.setAttribute('type', 'video/<?php echo pathinfo($banner_tablet_img, PATHINFO_EXTENSION); ?>');
                video.load();
            @endif
        }

        // document.querySelector(".innerPage_banner_img").src = "<?php echo $banner_tablet_img; ?>"

        if (screen.width <= 576 && $(".innerPage_banner_img").length > 0) {
            @if (in_array(pathinfo($banner_mobile_img, PATHINFO_EXTENSION), ['jpeg', 'jpg', 'png', 'gif', 'bmp']))
                document.querySelector(".innerPage_banner_img").src = "<?php echo $banner_mobile_img; ?>"
                $('#video_elem').remove();
                $('.innerPage_banner_img').css("display", "block");
            @elseif (in_array(pathinfo($banner_mobile_img, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                $('.innerPage_banner_img').css("display", "none");
                $('#video_elem').css("display", "block");
                let source = document.getElementById("video_src");
                source.setAttribute('src', '<?php echo $banner_mobile_img; ?>');
                source.setAttribute('type', 'video/<?php echo pathinfo($banner_mobile_img, PATHINFO_EXTENSION); ?>');
                video.load();
            @endif
        }
    });
</script>
