@extends('layouts.auth')
@section('main-content')
    <style>
        .code-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 30px 0 20px 0;
        }

        .code {
            border-radius: 5px;
            font-size: 45px;
            height: 85px;
            width: 65px;
            border: 1px solid #eee;
            margin: 8px;
            text-align: center;
            font-weight: 300;
        }

        .code::-webkit-outer-spin-button,
        .code::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .code:valid {
            border-color: #3498db;
            box-shadow: 0 10px 10px -5px rgba(0, 0, 0, 0.25);
        }

        @media (max-width: 600px) {
            .code-container {
                flex-wrap: wrap;
            }

            .code {
                font-size: 60px;
                height: 80px;
                max-width: 70px;
            }
        }
    </style>
    {{-- @dd($QR_Image) --}}
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-5 d-flex justify-content-center align-items-center">
                                <div style="width: 300px; height: auto;">
                                    <img src="{{ url('img/logo.png') }}" alt="..." style="width: 100%; height: auto;">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">{{ __('Two Factor Authentication') }}</h1>
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger border-left-danger" role="alert">
                                            <ul class="pl-4 my-2">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    @if (Session::has('errorMessage'))
                                        <div class="padding p-b-0">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="alert alert-danger m-b-0">
                                                        <button type="button" class="close" data-dismiss="alert"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                        {{ Session::get('errorMessage') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('admin.validate.login') }}" class="user">
                                        @csrf
                                        @if ($status == '0')
                                            <input type="hidden" name="verify_2fa" value="0">
                                            <div class="form-group">
                                                <label>1. Download Google Authenticator app to your phone.</label>
                                                <label>2. Scan this QR code with your authenticator app</label>
                                            </div>
                                            <div class="form-group" style="padding-left: 17px;">
                                                <div>
                                                    {!! $QR_Image !!}
                                                </div>
                                                <label>Type this code down if you can't scan.</label>
                                                <strong>{{ $secret }}</strong>
                                            </div>
                                            <div class="form-group">
                                                <label>3. Enter the 6-digit code provided by your app and then
                                                    verify</label>
                                                <input type="number" title="Enter 6 digit code" pattern="[0-9]{6}"
                                                    width="90%" class="form-control" name="verify_token"
                                                    id="verify_token" required>
                                            </div>
                                        @else
                                            <input type="hidden" name="verify_2fa" value="1">
                                            <div class="code-container">
                                                <input type="text" name="one" class="code" placeholder="0"
                                                    min="0" max="1" maxlength="1" tabindex="1" required />
                                                <input type="text" name="two" class="code" placeholder="0"
                                                    min="0" max="1" maxlength="1" tabindex="2" required />
                                                <input type="text" name="three" class="code" placeholder="0"
                                                    min="0" max="1" maxlength="1" tabindex="3" required />
                                                <input type="text" name="four" class="code" placeholder="0"
                                                    min="0" max="1" maxlength="1" tabindex="4" required />
                                                <input type="text" name="five" class="code" placeholder="0"
                                                    min="0" max="1" maxlength="1" tabindex="5" required />
                                                <input type="text" name="six" class="code" placeholder="0"
                                                    min="0" max="1" maxlength="1" tabindex="6" required />
                                            </div>
                                        @endif
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                                {{ __('Verify') }}
                                            </button>
                                        </div>
                                    </form>

                                    <hr>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('assets/dashboard/js/jquery/dist/jquery.js') }}"></script>
<script>
    jQuery($ => {
        let $inputs = $('input').on('input', e => {
            let $input = $(e.target);
            let index = $inputs.index($input);
            if ($input.val().length === $input.prop('maxlength')) {
                $inputs.eq(index + 1).focus();
            } else {
                $inputs.eq(index - 1).focus();
            }
        });
    });
</script>
