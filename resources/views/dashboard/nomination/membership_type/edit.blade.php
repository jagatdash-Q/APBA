@extends('dashboard.layouts.master')
@section('title', __('Edit Nomination Membership Type'))
@section('content')
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
    @endpush
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Manage Nomination Membership Type') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    <a href="{{ route('admin.nomination.membership.type') }}">Manage Nomination Membership Type</a> /
                    {{ __('Edit Nomination Membership Type') }}
                </small>
            </div>
            <div class="card mb-5">
                <div class="card-header" style="font-size: 18px;">
                    Edit Membership Type for Nomination
                </div>
                <form action="{{ route('admin.nomination.membership.type.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="uuid" value="{{ $memberhip_type->uuid }}">
                    <input type="hidden" name="type" value="1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Membership Type<span id="danger">*</span></label>
                                <input type="text" class="form-control text-secondary"
                                    placeholder="Enter membership type" name="membership_type" id="membership_type"
                                    value="{{ $memberhip_type->membership_type }}" required>
                            </div>
                        </div>
                    </div>
                    <div id="end-content">
                        <div class="col-md-12">
                            <div class="form-group row" style="margin-top: 10px;padding-bottom: 5px;">
                                <button class="btn btn-success" type="submit" id="submit_btn" style="margin-left:20px;">
                                    Update
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
@endpush
