@extends('dashboard.layouts.master')

@section('title', __('User Manager'))
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
@endpush
@section('content')
    <style>
        .custom-th {
            vertical-align: middle !important;
            padding: 8px !important;
            font-size: small !important;
            word-wrap: break-word !important;
        }

        .custom-td {
            vertical-align: middle !important;
            padding: 7px !important;
            font-size: small !important;
            word-wrap: break-word !important;
        }

        .disp-inline {
            display: inline !important;
        }
    </style>

    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('User Manager') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> /
                    <a href="{{ route('adminHome') }}">{{ __('User Manager') }}</a>
                </small>
            </div>
            <div class="row">
                <div class="container">
                    <div class="card pt-2">
                        <form action="{{ route('admin.user.update') }}" method="POST">
                            @csrf
                            @method('put')
                            <input type="hidden" class="" id="" placeholder="Enter user name" name="id" value="{{ $user_details->id }}">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id="" placeholder="Enter user name" name="name" value="{{ $user_details->name }}" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user" id="" placeholder="Enter user email" name="email" readonly  value="{{ $user_details->email }}">
                                </div>
                            </div>
                            {{-- <div class="col-md-12">
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="" placeholder="Enter old password" name="password" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="" placeholder="Enter new password" name="new_password" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user" id="" placeholder="Confirm your new password" name="password_confirmation" required>
                                </div>
                            </div> --}}

                            <div class="col-md-12">
                                <div class="form-group">
                                    <select class="form-select form-control"  aria-label="Default select example" required name="role">
                                        <option selected value="">Select Role</option>
                                        @foreach ($roles as $val)
                                            @if ($user_details->getRole->role_id==$val->id)
                                                <option value="{{ $val->id }}" selected>{{ $val->display_name }}</option>
                                            @else
                                                <option value="{{ $val->id }}">{{ $val->display_name }}</option>
                                            @endif
                                            
                                        @endforeach
                                      </select>
                                </div>
                            </div>
                           
                            <div class="col-md-12 mt-2 mb-2">
                                <button type="submit" class="btn btn-success"> Update </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ENd of pdf ection -->
@endsection
@push('after-scripts')
    <script></script>
@endpush
