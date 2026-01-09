@extends('dashboard.layouts.master')
@section('title', __('Edit Member'))
@section('content')
    <style>
        #danger {
            color: red;
        }
    </style>
    @include('dashboard.common.index')
    <div class="padding">
        <div class="box m-b-0">
            <div class="box-header dker">
                <h3>{{ __('Edit Member') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    <a href="{{ route('admin.member.dashboard') }}">Member Dashboard</a> /
                    {{ __('Edit Member') }}
                </small>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                        {{-- <a class="nav-link" href="{{ route('admin.our_teams.category') }}">
                            <i class="material-icons md-18">×</i>
                        </a> --}}
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <div class="card pt-2">
                    <form action="{{ route('admin.update.member') }}" method="post" onsubmit="return checkConfirmPass()" 
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" value="{{ $member->id }}">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">Full Name<span id="danger">*</span></label>
                                    <input type="text" class="form-control text-secondary" placeholder="Your full name"
                                        name="full_name" id="full_name" value="{{ $member->user_name }}" required>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Social Media Link</label>
                                    <input type="url" class="form-control text-secondary"
                                        placeholder="Your social media link" name="social_media_link" id="social_media_link"
                                        value="{{ $member->social_media_link }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="first_name">First Name<span
                                            id="danger">*</span></label>
                                    <span class="pr-field"><input type="text" class="form-control text-secondary"
                                            name="first_name" id="first_name" placeholder="Enter first name" required
                                            value="{{ $member->first_name }}"></span>
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="last_name">Last Name<span id="danger">*</span></label>
                                    <span class="pr-field"><input type="text" class="form-control text-secondary"
                                            name="last_name" id="last_name" placeholder="Enter last name" required
                                            value="{{ $member->last_name }}"></span>
                                </div>
                                <div class="col-6 mt-2">
                                    <label class="form-label" for="last_name">Country<span id="danger">*</span></label>
                                    <span class="pr-field"><select class="form-control custom_select" name="country"
                                            id="country" required>
                                            <option value="">-Please select-</option>

                                            @foreach ($country as $con)
                                                <option value="{{ $con->name }}"
                                                    @if ($con->name == $member->country) selected @endif>{{ $con->name }}
                                                </option>
                                            @endforeach
                                        </select></span>
                                </div>
                                <div class="col-6 mt-2">
                                    <label class="form-label" for="last_name">Email<span id="danger">*</span></label>
                                    <span class="pr-field"> <input type="email" class="form-control custom_input"
                                            placeholder="Your email address" name="email" id="email"
                                            value="{{ $member->email }}" required></span>
                                </div>
                                <div class="col-6 mt-2">
                                    <label class="form-label" for="last_name">Password</label>
                                    <span class="pr-field"> <input type="password" class="form-control custom_input"
                                            placeholder="Your password" name="password" id="password"
                                            value=""></span>
                                </div>
                                <div class="col-6 mt-2">
                                    <label class="form-label" for="last_name">Confirm Password<span id="danger"
                                            class="conf_pass"></span></label>
                                    <span class="pr-field"> <input type="password" class="form-control custom_input"
                                            placeholder="Re-type your password" name="confirm_password"
                                            id="confirm_password" value="">
                                        <span id="error_check" style="display: none;"></span></span>
                                </div>
                                <div class="col-6 mt-2">
                                    <label class="form-label">Profile Picture(max 200kb)</label>
                                    <input type="file" class="form-control text-secondary" accept="image/*"
                                        name="profile_pic" id="profile_pic">
                                </div>
                                <div class="col-6 mt-2">
                                    <div id="imagePreview">
                                        <img src="{{ $member->profile_pic == null ? asset('assets/frontend/images/avatar_white.gif') : asset('uploads/profile_pic/' . $member->profile_pic) }}"
                                            height="100px" width="auto"
                                            @if ($member->profile_pic == null) style="background:grey;" @endif>
                                    </div>
                                </div>
                                {{-- <div class="col-12 mt-4">
                                    <label class="form-label" for="last_name">Packages : <span
                                            id="danger">*</span></label>

                                    <span class="pr-field ml-3">
                                        @if (count($packages) > 0)
                                            @foreach ($packages as $data)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="package"
                                                        id="package" value="{{ $data->id }}" required>
                                                    <label class="form-check-label"
                                                        for="package">{{ $data->membership_name }}({{ $data->membership_plan }})(S$
                                                        {{ $data->membership_price }})</label>
                                                </div>
                                            @endforeach

                                        @endif
                                    </span>
                                </div> --}}
                                <div class="col-6 mt-2">
                                    <label class="form-label" for="last_name">Nomination : <span
                                            id="danger">*</span></label>
                                    <span class="pr-field ml-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="nomination"
                                                id="nomination" value="yes"
                                                @if ($member->nomination == 'yes') checked @endif>
                                            <label class="form-check-label" for="nomination">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="nomination"
                                                id="nomination" value="no"
                                                @if ($member->nomination == 'no') checked @endif>
                                            <label class="form-check-label" for="nomination">No</label>
                                        </div>
                                    </span>
                                </div>
                                {{-- <div class="col-12 mt-2">
                                    <label class="form-label" for="last_name">Payment Mode : <span
                                            id="danger">*</span></label>
                                    <span class="pr-field ml-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment_mode"
                                                id="payment_mode" value="check">
                                            <label class="form-check-label" for="payment_mode">Check</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="payment_mode"
                                                id="payment_mode" value="cash" checked>
                                            <label class="form-check-label" for="payment_mode">Cash</label>
                                        </div>
                                    </span>
                                </div> --}}
                            </div>
                        </div>

                        <div id="end-content">
                            <div class="col-md-12">
                                <div class="form-group row" style="margin-top: 20px;padding-bottom: 5px;">
                                    <button class="btn btn-success" type="submit" id="submit_btn"
                                        style="margin-left:20px;">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/script.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/menu_banner_image_pos.js') }}"></script>
    <script>
        $("#password").keyup(function() {
            var password = $("#password").val();
            if (password != '') {
                $(".conf_pass").html('');
                $(".conf_pass").html('*');
            } else {
                $(".conf_pass").html('');
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
@endpush
