@extends('frontend.layouts.master')
@section('content')
    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            <h2 class="static_inner_Page_banner_title">Register As Member</h2>
        </div>
    </div>

    <style>
        .inner_page_banner {
            background-image: url("{{ asset('assets/frontend/images/membership_banner.png') }}");
        }

        .banner_content_wrapper {
            display: flex;
            align-items: center;
        }

        .static_inner_Page_banner_title {
            font-size: 42px;
            line-height: 52px;
            font-weight: 700;
            color: #ffffff;
            padding-top: 112px;
        }

        @media (min-width: 576px) and (max-width: 768px) {
            .static_inner_Page_banner_title {
                font-size: 30px;
                line-height: 40px;
                width: auto;
                padding-top: 100px;
                padding-left: 20px;
                padding-right: 20px;
                padding-bottom: 40px;
            }
        }

        @media only screen and (max-width: 576px) {
            .static_inner_Page_banner_title {
                font-size: 30px;
                line-height: 40px;
                width: auto;
                padding-top: 100px;
                padding-left: 20px;
                padding-right: 20px;
                padding-bottom: 40px;
            }
        }
    </style>

    <div class="page_container">

        <div class="small_nav">
            <a href="{{ url('') }}"><img src="{{ asset('assets/frontend/images/home_icon.svg') }}" alt="..."></a>
            <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
            <a href="{{ route('frontend.membership') }}" class="small_nav_text">Membership</a>
            <img class="mx-4" src="{{ asset('assets/frontend/images/right_arrow_blue.svg') }}" alt="...">
            <span class="small_nav_text">Register As Member</span>
        </div>

        <div class="membership_header_div">
            <h2 class="site_heading_h2 mb-5">{{ $is_member_ship_exist->membership_name }}</h2>
        </div>
        <form action="{{ route('customer.register') }}" method="POST" onsubmit="return checkConfirmPass()"
            id="membership_form" enctype="multipart/form-data">
            @csrf

            <div class="membership_payment_details">
                {{-- <h3 class="site_heading_h3 mb-4">Payment Details</h3>
                {!! $is_member_ship_exist->membership_description !!}
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="membership_payment_details_value">Final Price:</p>
                    <p class="membership_payment_details_value">S$ {{ $is_member_ship_exist->membership_price }}</p>
                </div> --}}

                <div class="table_div">
                    <table class="table site_table table-borderless">
                        <thead>
                            <tr>
                                <th style="padding-left: 70px;" scope="col">Payment Details</th>
                                <th scope="col">Final Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding-top: 20px">
                                    <div style="padding-left: 52px;">
                                        {!! $is_member_ship_exist->membership_description !!}
                                    </div>
                                </td>
                                <td style="padding-top: 20px">
                                    <h3 class="site_heading_h3">S$ {{ $is_member_ship_exist->membership_price }}
                                        @php
                                            if ($is_member_ship_exist->membership_plan == 'yearly') {
                                                echo '(Yearly)';
                                            } else {
                                                echo '(1-time fee)';
                                            }
                                        @endphp
                                    </h3>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="membership_header_div">
                    <h2 class="site_heading_h2 mb-5">Registration Form</h2>
                </div>

                <input type="hidden" name="amount" value="{{ $is_member_ship_exist->membership_price }}">
                <input type="hidden" name="payment_for" value="membership registration">
                <input type="hidden" name="package_id" id="package_id" value="{{ $is_member_ship_exist->id }}" />
                <div class="row">
                    <input type="hidden" name="package" id="package" value="{{ $is_member_ship_exist->id }}" />
                    <input type="hidden" name="package_uid" id="package_uid" value="{{ $is_member_ship_exist->uid }}" />
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Full Name*</label>
                        <input type="text" class="form-control custom_input" placeholder="Your full name"
                            name="full_name" id="full_name" value="{{ old('full_name') }}">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Social Media Link</label>
                        <input type="url" class="form-control custom_input" placeholder="Your social media link"
                            name="social_media_link" id="social_media_link" value="{{ old('social_media_link') }}">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">First Name*</label>
                        <input type="text" class="form-control custom_input" placeholder="Your first name"
                            name="first_name" id="first_name" value="{{ old('first_name') }}">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Last Name*</label>
                        <input type="text" class="form-control custom_input" placeholder="Your last name"
                            name="last_name" id="last_name" value="{{ old('last_name') }}">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Country *</label>
                        <select class="form-control custom_select" name="country" id="country">
                            <option value="" selected>-Please select-</option>
                            @foreach ($country as $con)
                                <option value="{{ $con->name }}">{{ $con->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control custom_input" placeholder="Your email address"
                            name="email" id="email" value="{{ old('email') }}">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Password *</label>
                        <input type="password" class="form-control custom_input" placeholder="Your password"
                            name="password" id="password" value="{{ old('password') }}">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" class="form-control custom_input" placeholder="Re-type your password"
                            name="confirm_password" id="confirm_password" value="{{ old('confirm_password') }}">
                        <span id="error_check" style="display: none;"></span>

                    </div>
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Profile Picture(max 200kb) *</label>
                        <input type="file" class="form-control custom_input" accept="image/*" name="profile_pic"
                            id="profile_pic">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <div id="imagePreview">
                            <img src="{{ asset('assets/frontend/images/avatar_white.gif') }}" height="100px"
                                width="auto" style="background:grey;">
                        </div>
                    </div>
                </div>
                <div class="form-check">
                    <label class="checkbox" for="terms_accept">
                        <input type="checkbox" name="terms_accept" checked value="1" id="terms_accept" required>
                        <span class="checkmark"></span>
                        Accept our Terms & Conditions
                    </label>
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
                    <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha"
                        name="captcha" required>
                </div>

                <button type="submit" class="arrow_hover_link mt-5" style="border:none;">Register</button>
            </div>
        </form>
    </div>
@endsection

@section('page-scripts')
    <script>
        $('#membership_form').validate({
            rules: {
                full_name: {
                    required: true,
                },
                // social_media_link: {
                //     required: true,
                // },
                profile_pic: {
                    required: true,
                },
                email: {
                    required: true,
                },
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                country: {
                    required: true,
                },
                password: {
                    required: true,
                },
                confirm_password: {
                    required: true,
                },
                captcha: {
                    required: true,
                },
                'terms_accept[]': {
                    required: true,
                },
                captcha: {
                    required: true,
                },
            },
            messages: {
                full_name: {
                    required: "",
                },
                // social_media_link: {
                //     required: "",
                // },
                profile_pic: {
                    required: "",
                },
                email: {
                    required: "",
                },
                first_name: {
                    required: "",
                },
                last_name: {
                    required: "",
                },
                country: {
                    required: "",
                },
                password: {
                    required: "",
                },
                confirm_password: {
                    required: "",
                },
                'terms_accept[]': {
                    required: "",
                },
                captcha: {
                    required: "",
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-check').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });


        const checkConfirmPass = () => {
            var password = $("#password").val();
            if (password != '') {
                var confirm_password = $("#confirm_password").val();
                if (confirm_password == '') {
                    document.getElementById('confirm_password').style.borderColor = "red";
                    return false;
                } else {
                    document.getElementById('confirm_password').style.borderColor = "#e1e8ee";
                }

                if (password != confirm_password) {
                    $("#error_check").html('Password and confirm password must be same').css({
                        'display': 'block',
                        'color': '#dc3545'
                    });
                    return false;
                } else {
                    $("#error_check").css('display', 'none');
                }
            } else {
                document.getElementById('confirm_password').style.borderColor = "#e1e8ee";
                $("#error_check").css('display', 'none');
            }
        }

        $("#profile_pic").on("change", function(e) {
            var file = e.target.files[0];
            if (file) {
                $("#imagePreview").html('');
                var reader = new FileReader();
                reader.onload = function(e) {
                    var imageData = e.target.result;
                    $("#imagePreview").html('<img src="' + imageData +
                        '" alt="Image Preview" width="200" max-height="120" height="100" style="object-fit: contain;">'
                    );
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
