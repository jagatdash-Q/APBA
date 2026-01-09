@extends('frontend.layouts.master')
@section('content')
    <style>
        @media only screen and (min-width: 769px) {

            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $mebership->getBannerImageWeb->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $mebership->banner_title_left_pos_web; ?>%;
                top: <?php echo $mebership->banner_title_top_pos_web; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $mebership->banner_desc_left_pos_web; ?>%;
                top: <?php echo $mebership->banner_desc_top_pos_web; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $mebership->button_name_left_pos_web; ?>%;
                top: <?php echo $mebership->button_name_top_pos_web; ?>%;
            }
        }

        @media only screen and (min-width: 577px) and (max-width:768px) {
            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $mebership->getBannerImageTab->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $mebership->banner_title_left_pos_tablet; ?>%;
                top: <?php echo $mebership->banner_title_top_pos_tablet; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $mebership->banner_desc_left_pos_tablet; ?>%;
                top: <?php echo $mebership->banner_desc_top_pos_tablet; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $mebership->button_name_left_pos_tablet; ?>%;
                top: <?php echo $mebership->button_name_top_pos_tablet; ?>%;
            }
        }

        @media only screen and (max-width: 576px) {

            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $mebership->getBannerImageMobile->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $mebership->banner_title_left_pos_mobile; ?>%;
                top: <?php echo $mebership->banner_title_top_pos_mobile; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $mebership->banner_desc_left_pos_mobile; ?>%;
                top: <?php echo $mebership->banner_desc_top_pos_mobile; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $mebership->button_name_left_pos_mobile; ?>%;
                top: <?php echo $mebership->button_name_top_pos_mobile; ?>%;
            }
        }
    </style>

    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            <h1 class="innerPage_banner_title">
                {{ $mebership->banner_title != null ? $mebership->banner_title : '' }}
            </h1>
            <p class="innerPage_banner_desc">
                {{ $mebership->banner_desc != null ? $mebership->banner_desc : '' }}
            </p>
            @if ($mebership->button_name != null && $mebership->button_link != '')
                <span class="innerPage_banner_link">
                    <a class="arrow_hover_link" href="{{ $mebership->button_link }}">{{ $mebership->button_name }}</a>
                </span>
            @endif
        </div>
    </div>
    <div class="page_container">

        <div class="small_nav">
            <a href="{{ url('') }}"><img src="{{ asset('assets/frontend/images/home_icon.svg') }}"
                    alt="..."></a>
            <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
            <span class="small_nav_text">Membership</span>
        </div>
        <div class="row my-5 mx-1">
            <div class="col-md-6 my-5 membership_thumb">
                @if ($mebership->getfirstSectionImage != null)
                    @if (in_array(pathinfo($mebership->getfirstSectionImage->path, PATHINFO_EXTENSION), ['mp4', 'webm', 'ogg']))
                        <video autoplay muted loop playsinline class="d-block video_elem" style="width:100%"
                            id="video_elem_second_section">
                            <source src="{{ asset('') }}{{ $mebership->getfirstSectionImage->path }}"
                                type="video/{{ pathinfo($mebership->getfirstSectionImage->path, PATHINFO_EXTENSION) }}"
                                id="video_src_second_section">
                            Your browser does not support HTML video.
                        </video>
                    @else
                        <img class="" src="{{ asset('') }}{{ $mebership->getfirstSectionImage->path }}"
                            alt="...">
                    @endif
                @endif

            </div>
            <div class="col-md-6 memebrship_benifits">
                <h2 class="site_heading_h2 mb-4">{{ $mebership->section_1_head }}</h2>
                <div class="memebrship_benifits_desc">
                    {!! $mebership->section_1_desc !!}
                </div>
            </div>
        </div>
        <h2 class="site_heading_h2 membership_type_head">{{ $mebership->section_2_head }}</h2>
        @if (count($mebership->getMemberships))
            <div class="row my-5">
                @foreach ($mebership->getMemberships as $mem)
                    <div class="col-sm-6 mb-5 membership_type">
                        <div class="membership_type_top">
                            <div class="membership_type_top_thumb">
                                @if ($mem->getMembershipImage != null)
                                    @if (in_array($mem->getMembershipImage->file_ext, ['mp4', 'webm', 'ogg']))
                                        <video autoplay muted loop playsinline class="video_elem" style="width:100%">
                                            <source src="{{ asset('') }}{{ $mem->getMembershipImage->path }}"
                                                type="">
                                            Your browser does not support HTML video.
                                        </video>
                                    @else
                                        <img src="{{ asset('') }}{{ $mem->getMembershipImage->path }}" />
                                    @endif
                                @else
                                    <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}" />
                                @endif
                            </div>
                            <div class="membership_type_top_content">
                                <h3 class="site_heading_h3 mb-0">{{ $mem->membership_name }}</h3>
                                <h3 class="site_heading_h3"> S$ {{ $mem->membership_price }}
                                    @php
                                        if ($mem->membership_plan == 'yearly') {
                                            echo '(Yearly)';
                                        } else {
                                            echo '(1-time fee)';
                                        }
                                    @endphp
                                </h3>
                                <p class="membership_type_top_desc">
                                    {{ $mem->membership_srt_desc }}
                                </p>
                            </div>
                            <span class="membership_type_link">
                                @if ($mem->subscription_type == 'sub')
                                    <a class="arrow_hover_link"
                                        href="{{ route('frontend.membership.register', ['uid' => $mem->uid]) }}">{{ $mem->membership_button_text }}
                                    </a>
                                @else
                                    <a class="arrow_hover_link" href="{{ route('frontend.contact') }}">Contact Us</a>
                                @endif
                            </span>
                        </div>
                        <div class="membership_type_bottom">
                            {!! $mem->membership_description !!}
                        </div>

                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
