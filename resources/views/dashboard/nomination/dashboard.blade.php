@extends('dashboard.layouts.master')
@section('title', __('Dashboard'))
@section('content')
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
    @endpush
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Dashboard') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    {{ __('Nomination Dashboard') }}
                </small>
            </div>
            <form action="{{ route('admin.nomination.dashboard') }}" method="GET">
                <div class="row mb-2">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="nomination_uuid">Nomination Name:</label>
                            <select name="nomination_uuid" class="form-control form-control-user" id="nomination_uuid">
                                <option value="" selected>-Choose Nomination-</option>
                                @if (count($all_nomination_list))
                                    @foreach ($all_nomination_list as $nomination_name)
                                        <option value="{{ $nomination_name->uuid }}">{{ $nomination_name->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-1 d-flex">
                        <button type="submit" class="btn btn-info btn-circle btn-sm ml-1" name="filter"
                            style="margin-top: 33px;">
                            <i class="fas fa-filter"></i>
                        </button>
                        <button type="submit" name="restore" class="btn btn-danger btn-circle btn-sm ml-1"
                            style="margin-top: 33px;">
                            <i class="fas fa-undo"></i>
                        </button>
                    </div>

                    <div class="col-2"></div>
                    <div class="col-6">
                        <a href="{{ route('admin.nomination.create') }}" class="btn btn-primary float-right  @if (!Auth::user()->hasPermission('nomination_management-create')) disabled @endif"
                            style="margin-top: 30px;">
                            {{ __('+ Create Nomination') }}
                        </a>
                    </div>
                </div>
            </form>

            @if (count($nomination_progress_chart))
                <div class="card shadow mb-4">
                    <div class="card-header" style="font-size: 18px;">
                        <span class="icon text-red-50 mr-2" style="color: blue;">
                            <i class="fas fa-tasks"></i>
                        </span>Nomination Progress
                    </div>
                    <div class="card-body">

                        @foreach ($nomination_progress_chart as $chart)
                            @php
                                $percentage = ($chart['total_nomination'] * 100) / $total_customer;
                            @endphp
                            <h4 class="small font-weight-bold">{{ $chart['position'] }} <span
                                    class="float-right">{{ number_format(floatval($percentage), 2, '.', '') }}%</span>
                            </h4>
                            <div class="progress mb-4">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-{{ $chart['color_class'] }}"
                                    role="progressbar" style="width: {{ $percentage }}%"
                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                    aria-valuemax="{{ $total_customer }}"></div>
                            </div>
                        @endforeach

                    </div>
                </div>
            @endif

            <div class="card">
                <div class="card-header" style="font-size: 18px;">
                    <div class="row">
                        <div class="col-6">

                            <span class="icon text-red-50 mr-2" style="color: blue;">
                                <i class="fas fa-person-booth"></i>
                            </span>{{ $nomination != null ? $nomination->name : '' }}
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered m-a-0" id="nomination_membership_type">
                            <thead class="dker">
                                <tr>
                                    <th class="custom-th">{{ __('Membership Type Name') }}</th>
                                    <th class="custom-th">{{ __('Membership Postion Name') }}</th>
                                    <th class="custom-th">{{ __('Start Date') }}</th>
                                    <th class="custom-th">{{ __('End Date') }}</th>
                                    <th class="custom-th">{{ __('Status') }}</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($nomination->getNominationPosition))
                                    @if (count($nomination->getNominationPosition))
                                        @foreach ($nomination->getNominationPosition as $data)
                                            <tr>
                                                <td>
                                                    @if (isset($data->getPosition))
                                                        @if (isset($data->getPosition->getMembershipType))
                                                            {{ $data->getPosition->getMembershipType->membership_type }}
                                                        @endif
                                                    @endif

                                                </td>
                                                <td>
                                                    @if (isset($data->getPosition))
                                                        {{ $data->getPosition->membership_position }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ Carbon\Carbon::parse($nomination->start_date)->format('d F Y') }}
                                                </td>
                                                <td>{{ Carbon\Carbon::parse($nomination->end_date)->format('d F Y') }}</td>
                                                <td>
                                                    @if ($nomination->status == '0')
                                                        <a href="javascript:void();" style="pointer-events: none;"
                                                            class="btn btn-danger btn-icon-split">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-exclamation-triangle"></i>
                                                            </span>
                                                            <span class="text">In Active</span>
                                                        </a>
                                                    @else
                                                        <a href="javascript:void();" style="pointer-events: none;"
                                                            class="btn btn-success btn-icon-split">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-check"></i>
                                                            </span>
                                                            <span class="text">Active</span>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td style="text-align:center;">
                                                    <a href="{{ route('admin.nomination.position.details', $data->uuid) }}"
                                                        class="btn btn-primary btn-circle btn-sm mr-1">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#nomination_membership_type').DataTable({
                responsive: false,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                },
                bInfo: false,
            });
        });
        const deleteFunction = (id) => {
            Swal.fire({
                title: 'Are you sure to delete?',
                text: "You won't be able to revert this! This member will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete_news_form_' + id).submit();
                }
            })
        }
    </script>
@endpush
