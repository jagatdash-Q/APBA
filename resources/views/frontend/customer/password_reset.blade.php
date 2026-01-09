@extends('frontend.layouts.master')
@section('content')
    <div class="inner_page_banner bg-animation">
        <div class="banner_content_wrapper">
            <h2 class="static_inner_Page_banner_title">Reset your password</h2>
        </div>
    </div>

    <style>
        .inner_page_banner {
            background-image: url("{{ asset('assets/frontend/images/contact_us_banner.png') }}");
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
            <span class="small_nav_text">Reset Password</span>
        </div>

        <div>
            <form class="my-5" action="{{ route('customer.update.password') }}" method="POST" onsubmit="return checkConfirmPass()"
            id="password_reset_form">
                @csrf
                <input type="hidden" name="password_reset_token"
                    value="{{ $password_reset_details->password_reset_token }}" />
                <div class="row">
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">New Password *</label>
                        <input type="password" class="form-control custom_input" placeholder="" name="password"
                            id="password">
                    </div>
                    <div class="col-sm-6 mb-4">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" class="form-control custom_input" placeholder="" name="cnfrm_password"
                            id="confirm_password">
                    <span id="error_check" style="display: none;"></span>
                    </div>
                </div>
                <button type="submit" class="arrow_hover_link password-reset-btn mt-5"
                    style="border:none;">Update
                    Password</button>
            </form>
        </div>

    </div>
@endsection

@section('page-scripts')
    <script>
        $('#password_reset_form').validate({
            rules: {
                password: {
                    required: true,
                },
                confirm_password: {
                    required: true,
                }
            },
            messages: {
                password: {
                    required: "",
                },
                confirm_password: {
                    required: "",
                }
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


        // let passwordValidator = () => {
        //     // return false;
        //     let pass = $('#password').val();
        //     let cnfr = $('#cnfrm_password').val();

        //     let msg = '';

        //     if(pass==''){
        //         msg = 'Password field is required';
        //     }
        //     if(pass!=cnfr){
        //         msg = 'Password and confirm password must be same';
        //     }


        //     // return false;
        //     // let check_valid_password = checkPassword(pass);
        //     // console.log(check_valid_password);
        //     // if (!check_valid_password) {
        //     //     msg = 'Password must contain at least one lowercase letter, one uppercase letter, one numeric digit, and one special character';
        //     // }
        //     // console.log(msg);
        //     // return false;
        //     if(msg==''){
        //         return true;
        //     }else{
        //         // return false;
        //         Swal.fire({
        //             icon: 'warning',
        //             title: 'Oops...',
        //             text: msg,
        //         });
        //         return false;
        //     }

        // }
    </script>
@endsection
