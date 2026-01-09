@extends('dashboard.layouts.master')
@section('title', __('Edit Nomination Membership Position'))
@section('content')

    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
    @endpush
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Edit Nomination Membership Position') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home /
                    </a>
                    <a href="{{ route('admin.nomination.membership.position') }}">Manage Nomination Membership Position /
                    </a>
                    {{ __('Edit Nomination Membership Position') }}
                </small>
            </div>
            <div class="card mb-5">
                <div class="card-header" style="font-size: 18px;">
                    Edit Membership Position for Nomination
                </div>
                <form action="{{ route('admin.nomination.membership.position.create') }}" method="POST">
                    @csrf
                    <input type="hidden" name="uuid" value="{{ $memberhip_position->uuid }}">
                    <input type="hidden" name="type" value="1">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="last_name">Membership Type<span
                                        id="danger">*</span></label>
                                <span class="pr-field"><select class="form-control custom_select"
                                        name="membership_type_uuid" id="membership_type_uuid" required>
                                        @if (count($memberhip_type))
                                            @foreach ($memberhip_type as $type)
                                                @if ($type->uuid == $memberhip_position->membership_type_uuid)
                                                    <option value="{{ $type->uuid }}" selected>
                                                        {{ $type->membership_type }}
                                                    </option>
                                                @else
                                                    <option value="{{ $type->uuid }}">{{ $type->membership_type }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </span>
                            </div>
                            <div class="col-6">
                                <label class="form-label">Membership Position<span id="danger">*</span></label>
                                <input type="text" class="form-control text-secondary"
                                    placeholder="Enter membership position" name="membership_position"
                                    id="membership_position" value="{{ $memberhip_position->membership_position }}" required>
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
