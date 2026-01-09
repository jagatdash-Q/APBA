
@include('frontend.layouts.header')

@yield('content')

@include('frontend.layouts.footer')

@yield('page-scripts')
<style>
    .aft_35::after {
        top: 35%;
    }
</style>
<div class="cd_popup" role="alert" id="login_cd_popup">
    <div class="cd_popup_container">
        <h2 class="site_heading_h2 mb-3 cd_popup_alingment">Login</h2>
        <img class="cd_popup_close close_modal" src="{{ asset('assets/frontend/images/nav_toggle_close.svg') }}" alt="...">
        <form action="{{ route('customer.account.validate') }}" method="post">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" class="custom_tb" placeholder="Your login email address" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="custom_tb" placeholder="Your login password" name="password" required>
            </div>

            <div class="cd_popup_flex_1 py-2">
                <label class="checkbox" for="remember_me" style="font-weight: 500">
                    <input type="checkbox" name="color" checked value="remember_me" id="remember_me">
                    <span class="checkmark"></span>Remember Me
                </label>
                <a class="cd_popup_links" href="javascript:void(0)" id="lost_pass_cd_popup_trigger">Lost your
                    password?</a>
            </div>
            <div class="cd_popup_alingment">
                {{-- <a class="arrow_hover_link" style="min-width: 130px;" href="{{ route('customer.home') }}">
                    Login
                </a> --}}
                <button type="submit" class="arrow_hover_link login-btn mt-3"
                    style="border: none">Login</button>
            </div>
            <div class="cd_popup_flex_2 my-4">
                <p class="mr-2" style="font-weight: 500">Don't have an account?</p> <a class="cd_popup_links"
                    href="{{ route('frontend.customer.register') }}">Sign Up Now</a>
            </div>
        </form>
    </div>
</div>

<div class="cd_popup" role="alert" id="lost_pass_cd_popup">
    <div class="cd_popup_container">
        <h2 class="site_heading_h2 mb-5 cd_popup_alingment">Reset Password</h2>
        <img class="cd_popup_close close_modal" src="{{ asset('assets/frontend/images/nav_toggle_close.svg') }}" alt="...">
        <form action="{{ route('customer.reset.password') }}" method="POST">
            @csrf
            <div class="form-group mb-5">
                <label>Email Address</label>
                <input type="email" class="custom_tb" placeholder="Your login email address" name="email" required>
            </div>
            <div class="cd_popup_alingment">
                <button type="submit" class="arrow_hover_link login-btn mt-5" style="border: none">Get New
                    Password</button>
                {{-- <a class="arrow_hover_link" href="javascript:void(0)">Get New Password</a> --}}
            </div>
        </form>
    </div>
</div>


@if (isset($packages) && isset($customer_details))
    <div class="cd_popup" role="alert" id="package_cd_popup" style="display: block;">
        <div class="cd_popup_container"
            style="max-width: 1000px; max-height: 1000px; padding: 0px; border: none; height: 100%; overflow: auto;">
            <img class="cd_popup_close close_modal" src="{{ asset('assets/frontend/images/nav_toggle_close.svg') }}" alt="...">
            <form action="{{ route('upgradePayment') }}" method="POST">
                @csrf
                <input type="hidden" name="payment_for" id="payment_for" value="">
                @if (count($packages) > 0)
                    <div class="table_div">
                        <table class="table site_table table-borderless" style="margin-bottom: 0px; box-shadow: none;">
                            <thead>
                                <tr>
                                    <th style="padding-left: 100px;" scope="col">Memberships</th>
                                    <th scope="col">Final Price</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($packages as $packages_data)
                                    <tr
                                        @if ($customer_details->active_subscription == $packages_data->id) style="cursor: not-allowed;opacity:0.5;" @endif>
                                        <td>
                                            <div class="radio_container" style="margin-bottom: 0px;">
                                                <input class="radio_input"
                                                    @if ($customer_details->active_subscription == $packages_data->id) disabled @endif type="radio"
                                                    name="subscription_id" id="subscription_id"
                                                    value="{{ $packages_data->id }}" required>
                                                <span class="radio_checkmark"></span>
                                                <h4 class="site_heading_h4 ml-3 pt-1">
                                                    {{ $packages_data->membership_name }}
                                                </h4>
                                            </div>
                                            <div style="padding-left: 52px;">
                                                {!! $packages_data->membership_description !!}
                                            </div>
                                        </td>
                                        <td>
                                            <h4 class="site_heading_h4 pt-1">S$ {{ $packages_data->membership_price }}
                                            </h4>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="cd_popup_alingment">
                    <button type="submit" class="arrow_hover_link login-btn mt-3 mb-5"
                        style="border: none">Subscribe</button>
                    {{-- <a class="arrow_hover_link" href="javascript:void(0)">Get New Password</a> --}}
                </div>
            </form>
        </div>
    </div>
@endif


<div class="cd_popup" role="alert" id="bookings_cd_popup">
    <div class="cd_popup_container"
        style="height: 100%; max-width: 800px; overflow-y: scroll;">
        <h3 class="site_heading_h3 cd_popup_alingment" id="heading_details"></h3>
        <img class="cd_popup_close close_modal" src="{{ asset('assets/frontend/images/nav_toggle_close.svg') }}"
            alt="...">
        <div id="append_booking_data">

        </div>
    </div>
</div>


<div id="nav_backdrop" class="modal-backdrop-transition"></div>
<div id="cd_popup_backdrop" class="cd_popup_transition"></div>
