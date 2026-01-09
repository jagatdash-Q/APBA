@extends('dashboard.layouts.master')
@section('title', __('Default Membership'))
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}">
    <style>

    </style>
@endpush
@section('content')
    @include('dashboard.common.index')
    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Default Membership') }}</h3>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card pt-2">
                        <form action="{{ route('admin.set.default.membership.package') }}" method="POST" id="membership_form" onsubmit="return validateForm();">
                            @csrf
                            <input type="hidden" name="base_url" id="base_url" value="{{ url('') }}">
                            <input type="hidden" name="content_id" id="content_id" value="{{ $mebership->content_id }}">
                            <input type="hidden" name="membership_content_details_id" id="membership_content_details_id" value="{{ $mebership->id }}">

                            <fieldset>
                                <legend>Default Membership Info :</legend>
                                <div class="form-group row">
                                    <div class="col-md-2">
                                        <label for="defaultMembership">Default Membership</label>
                                    </div>
                                    <div class="col-md-10">
                                        @if (count($mebership->getMemberships))
                                            @if ($default != null)
                                                @if ($default->getPackageInfo != null)
                                                    <select class="form-control" id="defaultMembership" name="default_membership">
                                                        @foreach ($mebership->getMemberships as $val)
                                                            @if ($val->id == $default->membership_package_id)
                                                                <option value="{{ $val->id }}" selected>
                                                                    {{ $val->membership_name }}</option>
                                                            @else
                                                                <option value="{{ $val->id }}">
                                                                    {{ $val->membership_name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <select class="form-control" id="defaultMembership" name="default_membership">
                                                        <option value="" selected>Please choose</option>
                                                        @foreach ($mebership->getMemberships as $val)
                                                            <option value="{{ $val->id }}">
                                                                {{ $val->membership_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            @else
                                                <select class="form-control" id="defaultMembership" name="default_membership">
                                                    <option value="" selected>Please choose</option>
                                                    @foreach ($mebership->getMemberships as $val)
                                                        <option value="{{ $val->id }}">
                                                            {{ $val->membership_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        @else
                                            <select class="form-control" id="defaultMembership" name="default_membership">
                                                <option value="" selected>Please choose</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-success"
                                            style="margin-left: 20px;margin-bottom:20px" id="submit_btn">Update</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')



@endsection

@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script>
        $(document).ready(function() {

        });
    </script>
@endpush
