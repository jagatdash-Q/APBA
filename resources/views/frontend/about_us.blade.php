@extends('frontend.layouts.master')
@section('content')
    <style>
        svg {
            width: 75px;
            height: 75px;
        }

        path {
            stroke: #02b0b5;
        }
    </style>
    <style>
        @media only screen and (min-width: 769px) {

            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $about_content_details->getBannerImageWeb->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $about_content_details->banner_title_left_pos_web; ?>%;
                top: <?php echo $about_content_details->banner_title_top_pos_web; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $about_content_details->banner_desc_left_pos_web; ?>%;
                top: <?php echo $about_content_details->banner_desc_top_pos_web; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $about_content_details->button_name_left_pos_web; ?>%;
                top: <?php echo $about_content_details->button_name_top_pos_web; ?>%;
            }
        }

        @media only screen and (min-width: 577px) and (max-width:768px) {
            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $about_content_details->getBannerImageTab->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $about_content_details->banner_title_left_pos_tablet; ?>%;
                top: <?php echo $about_content_details->banner_title_top_pos_tablet; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $about_content_details->banner_desc_left_pos_tablet; ?>%;
                top: <?php echo $about_content_details->banner_desc_top_pos_tablet; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $about_content_details->button_name_left_pos_tablet; ?>%;
                top: <?php echo $about_content_details->button_name_top_pos_tablet; ?>%;
            }
        }

        @media only screen and (max-width: 576px) {

            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $about_content_details->getBannerImageMobile->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $about_content_details->banner_title_left_pos_mobile; ?>%;
                top: <?php echo $about_content_details->banner_title_top_pos_mobile; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $about_content_details->banner_desc_left_pos_mobile; ?>%;
                top: <?php echo $about_content_details->banner_desc_top_pos_mobile; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $about_content_details->button_name_left_pos_mobile; ?>%;
                top: <?php echo $about_content_details->button_name_top_pos_mobile; ?>%;
            }
        }
    </style>


    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            {{-- @if ($about_content_details->getBannerImageWeb != null)
            @if (in_array($about_content_details->getBannerImageWeb->file_ext, ['mp4', 'webm', 'ogg']))
                <video autoplay muted loop playsinline class="d-block video_elem" style="display:none;width:100%"
                    id="video_elem">
                    <source src="{{ asset('') }}{{ $about_content_details->getBannerImageWeb->path }}"
                        type="video/{{ pathinfo($about_content_details->getBannerImageWeb->path, PATHINFO_EXTENSION) }}"
                        id="video_src">
                    Your browser does not support HTML video.
                </video>
                <img src="" class="innerPage_banner_img" style="display: none;" />
            @else
                <video autoplay muted loop playsinline class="video_elem" style="display:none;width:100%" id="video_elem">
                    <source src="" type="" id="video_src">
                    Your browser does not support HTML video.
                </video>
                <img src="{{ asset('') }}{{ $about_content_details->getBannerImageWeb->path }}"
                    class="innerPage_banner_img" style="display:none;"/>
            @endif
        @endif --}}
            <h1 class="innerPage_banner_title">
                {{ $about_content_details->heading != null ? $about_content_details->heading : '' }}
            </h1>
            <p class="innerPage_banner_desc">
                {{ $about_content_details->banner_desc != null ? $about_content_details->banner_desc : '' }}
            </p>
            @if ($about_content_details->button_name != null && $about_content_details->button_link != '')
                <span class="innerPage_banner_link">
                    <a class="arrow_hover_link"
                        href="{{ $about_content_details->button_link }}">{{ $about_content_details->button_name }}</a>
                </span>
            @endif
        </div>
    </div>

    <div class="page_container">

        <div class="small_nav">
            <a href="{{ url('') }}"><img src="{{ asset('assets/frontend/images/home_icon.svg') }}"
                    alt="..."></a>
            <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
            <span class="small_nav_text">About</span>
        </div>


        <div class="row aboutus_section_1">
            <div class="col-sm-6 mb-5">
                <h2 class="site_heading_h2">{{ $about_content_details->welcome_head }}</h2><br>
                <div class="apba_desc">
                    {!! $about_content_details->welcome_desc !!}
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">

                    @if (count($about_content_details->getFirstSectionCard))
                        @for ($i = 0; $i < count($about_content_details->getFirstSectionCard); $i++)
                            @php
                                $class = '';
                            @endphp
                            @if ($i % 2 == 0)
                                @php $class='mt-5' @endphp
                            @endif
                            @if ($about_content_details->getFirstSectionCard[$i]->getImageDetails != null)
                                <div class="col-sm-6 ml-4 about_items {{ $class }}">
                                    <div class="about_items_img">
                                        <img class="mb-3"
                                            src="{{ asset('') }}{{ $about_content_details->getFirstSectionCard[$i]->getImageDetails->path }}"
                                            alt="...">
                                    </div>
                                    <h4 class="about_items_title">
                                        {{ $about_content_details->getFirstSectionCard[$i]->desc }}</h4>
                                </div>
                            @endif
                        @endfor
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="position-relative">
        <div class="aboutus_canvas_div">
            <canvas id="aboutus_canvas" class="particles"></canvas>
        </div>
    </div>

    {{-- <img class="particles_center" src="{{ asset('assets/frontend/images/particles_no_bg.png') }}" alt="..."> --}}

    <div class="page_container">
        <div class="row aboutus_section_2 mr-0">
            <div class="col-sm-7 pr-5 about_vision_content">
                <div class="about_vision_box">
                    <h3 class="site_heading_h3 mb-3">{{ $about_content_details->section_2_head_1 }}</h3>
                    <p class="about_vision_desc">{{ $about_content_details->section_2_desc_1 }}</p>
                </div>
                <div class="about_vision_box">
                    <h3 class="site_heading_h3 mb-3">{{ $about_content_details->section_2_head_2 }}</h3>
                    <p class="about_vision_desc">{{ $about_content_details->section_2_desc_2 }}</p>
                </div>
                <div class="about_vision_box">
                    <h3 class="site_heading_h3 mb-3">{{ $about_content_details->section_2_head_3 }}</h3>
                    <p class="about_vision_desc">To provide a professional forum that represents
                        {{ $about_content_details->section_2_desc_3 }}</p>
                </div>
            </div>
            <div class="col-sm-5 about_vision_img">
                @if ($about_content_details->getsecondSectionImage != null)
                    @if (in_array(pathinfo($about_content_details->getsecondSectionImage->path, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                        <video autoplay muted loop playsinline class="d-block video_elem" style="width:100%"
                            id="video_elem_second_section">
                            <source src="{{ asset('') }}{{ $about_content_details->getsecondSectionImage->path }}"
                                type="video/{{ pathinfo($about_content_details->getsecondSectionImage->path, PATHINFO_EXTENSION) }}"
                                id="video_src_second_section">
                            Your browser does not support HTML video.
                        </video>
                    @else
                        <img class=""
                            src="{{ asset('') }}{{ $about_content_details->getsecondSectionImage->path }}"
                            alt="...">
                    @endif
                @endif
            </div>
        </div>


        <div class="row aboutus_section_3">
            <div class="col-sm-4 py-5 mb-3">
                <h2 class="site_heading_h2">{{ $about_content_details->objective_head }}</h2>
                <p class="aboutus_objective_desc">{{ $about_content_details->objective_desc }}</p>
            </div>


            {{-- @if (count($about_content_details->getThirdSectionCard))
                @for ($i = 0; $i < count($about_content_details->getThirdSectionCard); $i++)
                    @if ($about_content_details->getThirdSectionCard[$i]->getImageDetails != null)
                        <div class="col-sm-4 mb-3">
                            <div class="aboutus_objective_div">

                                <div class="aboutus_objective_div_img">
                                    <img class="icon_blue" src="{{ asset('assets/frontend/images/shield.gif') }}" alt="...">
                                    <img class="icon_white" src="{{ asset('assets/frontend/images/shield_white.gif') }}" alt="...">
                                </div>
                                <p class="aboutus_objective_desc">
                                    @if (strlen($about_content_details->getThirdSectionCard[$i]->desc) > 220)
                                    {{ substr($about_content_details->getThirdSectionCard[$i]->desc, 0, 200) . ' ...' }}
                                    @else
                                        {{ $about_content_details->getThirdSectionCard[$i]->desc }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endif
                @endfor
            @endif --}}
            @if (count($about_content_details->getThirdSectionCard))
                @for ($i = 0; $i < count($about_content_details->getThirdSectionCard); $i++)
                    <div class="col-sm-4 mb-3">
                        <div class="aboutus_objective_div">
                            <div class="aboutus_objective_div_img">
                                @if ($about_content_details->getThirdSectionCard[$i]->getImageDetails != null)
                                    <img class="icon_blue"
                                        src="{{ asset('') }}{{ $about_content_details->getThirdSectionCard[$i]->getImageDetails->path }}"
                                        alt="..." style="height: 75px;">
                                @endif
                                @if ($about_content_details->getThirdSectionCard[$i]->hoverImageDetails != null)
                                    <img class="icon_white"
                                        src="{{ asset('') }}{{ $about_content_details->getThirdSectionCard[$i]->hoverImageDetails->path }}"
                                        alt="..." style="height: 75px;">
                                @endif
                            </div>
                            <p class="aboutus_objective_desc">
                                {{-- @if (strlen($about_content_details->getThirdSectionCard[$i]->desc) > 220)
                                    {{ substr($about_content_details->getThirdSectionCard[$i]->desc, 0, 200) . ' ...' }}
                                    @else
                                        {{ $about_content_details->getThirdSectionCard[$i]->desc }}
                                    @endif --}}
                                {{ $about_content_details->getThirdSectionCard[$i]->desc }}
                            </p>
                        </div>
                    </div>
                @endfor
            @endif
            {{-- <div class="col-sm-4 mb-3">
                <div class="aboutus_objective_div">
                    <!-- <img class="aboutus_objective_svg" src="./assets/images/shield.svg" alt="..."> -->
                    <!-- <iframe class="aboutus_objective_iframe" src="./assets/images/shield.svg" frameborder="0"></iframe> -->
                    <svg width="75px" height="75px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.5 9.5L11 14L9.5 12.5M12 3L4 7C4 12.1932 6.78428 19.5098 12 21C17.2157 19.5098 20 12.1932 20 7L12 3Z"
                            stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="aboutus_objective_desc">To enhance recognition and
                        endorsement of APBA as credible and
                        competent implementing partner in
                        strengthening biosafety and biosecurity
                        standards and best practices.</p>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <div class="aboutus_objective_div">
                    <svg width="75px" height="75px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.5 9.5L11 14L9.5 12.5M12 3L4 7C4 12.1932 6.78428 19.5098 12 21C17.2157 19.5098 20 12.1932 20 7L12 3Z"
                            stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="aboutus_objective_desc">To advocate biosafety and
                        biocontainment technology as a credible
                        profession and enhance recognition that
                        those who work with biological materials
                        should be skilled and competent in
                        biosafety standards and best practices.</p>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <div class="aboutus_objective_div">
                    <svg width="75px" height="75px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.5 9.5L11 14L9.5 12.5M12 3L4 7C4 12.1932 6.78428 19.5098 12 21C17.2157 19.5098 20 12.1932 20 7L12 3Z"
                            stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="aboutus_objective_desc">To target key international public health
                        initiatives to ensure they include
                        biosafety and biosecurity priorities,
                        resources and agendas for action that
                        enhance sustainable biosafety capacity
                        among medical laboratory technicians
                        and scientists.</p>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <div class="aboutus_objective_div">
                    <svg width="800px" height="800px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M14 13a3.954 3.954 0 0 0 .142 1H9.858A3.954 3.954 0 0 0 10 13zm-3.5-4h3a2.486 2.486 0 0 1 1.945.949 3.992 3.992 0 0 1 .839-.547A3.485 3.485 0 0 0 13.5 8h-3a3.485 3.485 0 0 0-2.784 1.402 3.992 3.992 0 0 1 .84.547A2.486 2.486 0 0 1 10.5 9zM9 4a3 3 0 1 1 3 3 3.003 3.003 0 0 1-3-3zm1 0a2 2 0 1 0 2-2 2.002 2.002 0 0 0-2 2zM4.5 17h3a3.504 3.504 0 0 1 3.5 3.5V23H1v-2.5A3.504 3.504 0 0 1 4.5 17zm0 1A2.503 2.503 0 0 0 2 20.5V22h8v-1.5A2.503 2.503 0 0 0 7.5 18zM6 16a3 3 0 1 1 3-3 3.003 3.003 0 0 1-3 3zm0-1a2 2 0 1 0-2-2 2.002 2.002 0 0 0 2 2zm17 5.5V23H13v-2.5a3.504 3.504 0 0 1 3.5-3.5h3a3.504 3.504 0 0 1 3.5 3.5zm-1 0a2.503 2.503 0 0 0-2.5-2.5h-3a2.503 2.503 0 0 0-2.5 2.5V22h8zM21 13a3 3 0 1 1-3-3 3.003 3.003 0 0 1 3 3zm-1 0a2 2 0 1 0-2 2 2.002 2.002 0 0 0 2-2z" />
                    </svg>
                    <p class="aboutus_objective_desc">To promote and develop National
                        Biosafety Associations (NA) and Country
                        Biosafety Working Groups (CWG) and
                        fully integrate NAs and CWGs into APBA.</p>
                </div>
            </div>
            <div class="col-sm-4 mb-3">
                <div class="aboutus_objective_div">
                    <svg width="75px" height="75px" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.5 9.5L11 14L9.5 12.5M12 3L4 7C4 12.1932 6.78428 19.5098 12 21C17.2157 19.5098 20 12.1932 20 7L12 3Z"
                            stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <p class="aboutus_objective_desc">To educate key governmental, political,
                        public and private stakeholders on the
                        need to strengthen sustainable biosafety
                        practices and laboratory infrastructure/
                        equipment using practical risk-based
                        solutions that can be operated and
                        maintained in a safe and secure manner
                        using local resources.</p>
                </div>
            </div> --}}
        </div>


    </div>

    @php
        $banner_img = '';
        $banner_tablet_img = '';
        $banner_mobile_img = '';
        
    @endphp
    @if ($about_content_details->getBannerImageWeb != null)
        @php
            $banner_img = $about_content_details->getBannerImageWeb->path;
        @endphp
    @endif
    @if ($about_content_details->getBannerImageTab != null)
        @php
            $banner_tablet_img = $about_content_details->getBannerImageTab->path;
        @endphp
    @endif
    @if ($about_content_details->getBannerImageMobile != null)
        @php
            $banner_mobile_img = $about_content_details->getBannerImageMobile->path;
        @endphp
    @endif
@endsection


@section('page-scripts')
    <script>
        $(document).ready(function() {
            var screen_width = document.body.clientWidth;
            var video = document.getElementById('video_elem');
            // console.log("<?php echo $banner_mobile_img; ?>");
            if (screen_width >= 768 && $(".innerPage_banner_img").length > 0) {
                @if (in_array(pathinfo($banner_img, PATHINFO_EXTENSION), ['jpeg', 'jpg', 'png', 'gif', 'bmp']))
                    document.querySelector(".innerPage_banner_img").src = "<?php echo $banner_img; ?>"
                    $('#video_elem').remove();
                    $('.innerPage_banner_img').css("display", "block");
                @elseif (in_array(pathinfo($banner_img, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                    $('.innerPage_banner_img').css("display", "none");
                    $('#video_elem').css("display", "block");
                    let source = document.getElementById("video_src");
                    source.setAttribute('src', '<?php echo $banner_img; ?>');
                    source.setAttribute('type', 'video/<?php echo pathinfo($banner_img, PATHINFO_EXTENSION); ?>');
                    video.load();
                @endif
            }
            if (screen.width <= 768 && screen.width >= 576 && $(".innerPage_banner_img").length > 0) {
                // console.log(screen_width);


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
                // console.log(screen_width);

                // console.log("{{ $banner_mobile_img }}");
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
@endsection
