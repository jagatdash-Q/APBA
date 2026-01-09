@extends('frontend.layouts.master')
@section('content')


    <style>
        .inner_page_banner {
            background-image: url("{{ asset('assets/frontend/images/contact_us_banner.png') }}");
        }

        .innerPage_banner_title {
            top: 120px;
        }

        @media (min-width: 576px) and (max-width: 768px) {
            .innerPage_banner_title {
                top: 95px;
            }
        }

        @media only screen and (max-width: 576px) {
            .innerPage_banner_title {
                top: 95px;
            }
        }
    </style>
    <style>
        @media only screen and (min-width: 769px) {

            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $contact_us->getBannerImageWeb->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $contact_us->banner_title_left_pos_web; ?>%;
                top: <?php echo $contact_us->banner_title_top_pos_web; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $contact_us->banner_desc_left_pos_web; ?>%;
                top: <?php echo $contact_us->banner_desc_top_pos_web; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $contact_us->button_name_left_pos_web; ?>%;
                top: <?php echo $contact_us->button_name_top_pos_web; ?>%;
            }
        }

        @media only screen and (min-width: 577px) and (max-width:768px) {
            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $contact_us->getBannerImageTab->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $contact_us->banner_title_left_pos_tablet; ?>%;
                top: <?php echo $contact_us->banner_title_top_pos_tablet; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $contact_us->banner_desc_left_pos_tablet; ?>%;
                top: <?php echo $contact_us->banner_desc_top_pos_tablet; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $contact_us->button_name_left_pos_tablet; ?>%;
                top: <?php echo $contact_us->button_name_top_pos_tablet; ?>%;
            }
        }

        @media only screen and (max-width: 576px) {

            .inner_page_banner {
                background-image: url("{{ asset('') }}{{ $contact_us->getBannerImageMobile->path }}");
            }

            .innerPage_banner_title {
                left: <?php echo $contact_us->banner_title_left_pos_mobile; ?>%;
                top: <?php echo $contact_us->banner_title_top_pos_mobile; ?>%;
            }

            .innerPage_banner_desc {
                left: <?php echo $contact_us->banner_desc_left_pos_mobile; ?>%;
                top: <?php echo $contact_us->banner_desc_top_pos_mobile; ?>%;
            }

            .innerPage_banner_link {
                left: <?php echo $contact_us->button_name_left_pos_mobile; ?>%;
                top: <?php echo $contact_us->button_name_top_pos_mobile; ?>%;
            }
        }

        .arrow_hover_link:hover {
            border: none !important
        }
    </style>
    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            <h1 class="innerPage_banner_title">
                {{ $contact_us->banner_title != null ? $contact_us->banner_title : '' }}
            </h1>
            <p class="innerPage_banner_desc">
                {{ $contact_us->banner_desc != null ? $contact_us->banner_desc : '' }}
            </p>
            @if ($contact_us->button_name != null && $contact_us->button_link != '')
                <span class="innerPage_banner_link">
                    <a class="arrow_hover_link" href="{{ $contact_us->button_link }}">{{ $contact_us->button_name }}</a>
                </span>
            @endif
        </div>
    </div>

    <div class="page_container">

        <div class="small_nav">
            <a href="{{ url('') }}"><img src="{{ asset('assets/frontend/images/home_icon.svg') }}"
                    alt="..."></a>
            <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
            <span class="small_nav_text">{{ $contact_us->banner_title }}</span>
        </div>

        <div class="contact_header_div">
            <h2 class="site_heading_h2 mb-5">{{ $contact_us->title }}</h2>
            <p>{{ $contact_us->description }}</p>
        </div>


        <div class="contact_top_div">
            @if ($contact_us->google_map != null)
                <div class="contact_map_div">
                    <iframe src="{{ $contact_us->google_map }}" width="800" height="600" style="border:0;"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            @endif
            <div class="contact_details_div">
                <div>
                    <p style="font-weight: 500;">{{ $contact_us->address_1 }}</p>
                    <p>{{ $contact_us->address_2 }}</p>
                    @if ($contact_us->email != null)
                        <p>Email: <a class="site_links"
                                href="mailto:{{ $contact_us->email }}">{{ $contact_us->email }}</a></p>
                    @endif
                    @if ($contact_us->mobile != null)
                        <p>Phone Number: <a class="site_links"
                                href="tel:{{ $contact_us->mobile }}">{{ $contact_us->mobile }}</a></p>
                    @endif
                </div>
            </div>
        </div>

        <div class="contact_header_div">
            <h2 class="site_heading_h2">Enquiry Form</h2>
            <p>Please complete the form in below and we will look into your enquiry promptly</p>
        </div>

        <div>
            <form class="my-5" action="{{ route('frontend.submit.contact') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Company Name</label>
                        <input type="text" required class="form-control custom_input" placeholder="Your company name"
                            name="Company_name">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Company Person</label>
                        <input type="text" required class="form-control custom_input" placeholder="Your full name"
                            name="full_name">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Designation</label>
                        <input type="text" required class="form-control custom_input" placeholder="Your Designation"
                            name="designation">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Contact No</label>
                        <input type="number" required class="form-control custom_input" placeholder="Your contact"
                            name="contact_no">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Email *</label>
                        <input type="email" required class="form-control custom_input" placeholder="Your email address"
                            name="email">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Country</label>
                        <select class="form-control custom_select" name="country" required>
                            <option value="0" selected>-Please select-</option>
                            @if (count($country) > 0)
                                @foreach ($country as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Query</label>
                        <textarea class="form-control custom_input" name="query" placeholder="Your query" rows="5" required></textarea>
                    </div>

                    <div class="col-sm-12 mt-4 mb-4">
                        <div class="captcha">
                            <span>{!! captcha_img() !!}</span>
                            <button type="button" class="btn btn-danger" class="reload" id="reload">
                                &#x21bb;
                            </button>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha"
                            required>
                    </div>
                </div>
                <button type="submit" class="arrow_hover_link login-btn mt-3 mb-5" style="border:none;">Submit</button>
            </form>
        </div>

    </div>
@endsection
