@extends('dashboard.layouts.master')
@section('title', __('Position Details'))
@section('content')
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
    @endpush
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

        th,
        td {
            border: 0px;
        }

        .sub-title-color {
            color: gray;
        }

        #not-allowed {
            pointer-events: none;
            opacity: 0.5;

        }
    </style>

    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Position Details') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">Home</a> /
                    <a href="{{ route('admin.nomination.dashboard') }}">{{ __('Nomination Dashboard') }}</a> /
                    @if (isset($check_details->getPosition))
                        {{ $check_details->getPosition->membership_position }}
                    @endif
                </small>

            </div>

            <div class="card">
                <div class="card-header" style="font-size: 18px;">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="icon text-red-50 mr-2" style="color: blue;">
                                <i class="fas fa-user-friends"></i>
                            </span>Members Nomination List
                        </div>
                        <div class="col-md-6 text-right">
                            <form action="{{ route('nomination.position.export') }}" method="GET">
                                <input type="hidden" name="nomination_position_uuid" value="{{ $check_details->uuid }}">
                                <button type="submit" class="btn">
                                    <i class="fas fa-file-excel text-right" style="font-size:30px;color:green;"
                                        title="Download data in Excel"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-12">
                            <ul>
                                <li>Nomination Start & End Date: <b>
                                        {{ isset($check_details->getNomination) == true ? Carbon\Carbon::parse($check_details->getNomination->start_date)->format('d F Y') : '' }}</b>
                                    to <b>
                                        {{ isset($check_details->getNomination) == true ? Carbon\Carbon::parse($check_details->getNomination->end_date)->format('d F Y') : '' }}</b>
                                </li>
                                <li>Nomination Name: <b>
                                        @if (isset($check_details->getNomination))
                                            {{ $check_details->getNomination->name }}
                                        @endif
                                    </b></li>
                                <li>Membership Type:
                                    <b>
                                        @if (isset($check_details->getPosition))
                                            {{ $check_details->getPosition->getMembershipType->membership_type }}
                                        @endif
                                    </b>
                                </li>
                                <li>Position: <b>
                                        @if (isset($check_details->getPosition))
                                            {{ $check_details->getPosition->membership_position }}
                                        @endif
                                    </b>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered m-a-0 mt-5" id="nomination_list">
                            <thead class="dker">
                                <tr>
                                    <th class="custom-th">{{ __('Member Name') }}</th>
                                    <th class="custom-th">{{ __('Total Vote') }}</th>
                                    <th class="custom-th">{{ __('Total Vote in %') }}</th>
                                    <th class="custom-th">{{ __('Status') }}</th>
                                    <th class="text-center" style="width:200px;">{{ __('Action') }}</th>
                                </tr>
                            </thead>

                            <tbody>

                                @if (count($member_nomination))
                                    @foreach ($member_nomination as $member)
                                        <tr @if ($member['status'] == 1) id="not-allowed" @endif>
                                            <td class="custom-td">
                                                <div class="avatar avatar-md mr-3 mt-1 float-left">
                                                    <img src="{{ $member['profile_pic'] == null ? asset('/assets/frontend/images/avatar_white.gif') : asset('uploads/profile_pic/' . $member['profile_pic']) }}"
                                                        alt="">
                                                </div>
                                                <div class="mt-3">
                                                    <strong>{{ $member['name'] }}</strong>
                                                </div>
                                            </td>

                                            <td>
                                                <a href="javascript:void(0);" style="pointer-events: none;"
                                                    class="btn btn-primary btn-icon-split btn-sm">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-flag"></i>
                                                    </span>
                                                    <span class="text">{{ $member['total_vote'] }}</span>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                            {{ $member['total_percentage'] }}%</div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="progress progress-sm mr-2">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                style="width: {{ $member['total_percentage'] }}%"
                                                                aria-valuenow="{{ $member['total_percentage'] }}"
                                                                aria-valuemin="0" aria-valuemax="{{ $total_customer }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="custom-td">
                                                @if ($member['status'] == 1)
                                                    <a href="javascript:void(0);"
                                                        style="pointer-events: none;border-radius:20px"
                                                        class="btn btn-danger">
                                                        <span class="text">In Active</span>
                                                    </a>
                                                @elseif($member['status'] == 2)
                                                    <a href="javascript:void(0);"
                                                        style="pointer-events: none;border-radius:20px"
                                                        class="btn btn-warning">
                                                        <span class="text">Move to Election</span>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0);"
                                                        style="pointer-events: none;border-radius:20px"
                                                        class="btn btn-success">
                                                        <span class="text">Active</span>
                                                    </a>
                                                @endif
                                            </td>
                                            <td style="text-align:center;display:flex;">
                                                <a href="{{ route('admin.view.member', [$member['member_id'], 'type' => 'nomination', 'position_uuid' => $check_details->uuid]) }}"
                                                    class="btn btn-primary btn-circle btn-sm mr-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="javascript:void(0);"
                                                    onclick="acceptMember('{{ $member['name'] }}','{{ $member['member_id'] }}','{{ $check_details->nomination_uuid }}','{{ $check_details->position_uuid }}')"
                                                    class="btn btn-success btn-circle btn-sm mr-1">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="javascript:void(0);"
                                                    @if ($member['status'] == 2) style="pointer-events: none;" @endif
                                                    onclick="rejectMember('{{ $member['name'] }}','{{ $member['member_id'] }}','{{ $check_details->nomination_uuid }}','{{ $check_details->position_uuid }}')"
                                                    class="btn btn-danger btn-circle btn-sm mr-1">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                                <a href="{{ route('customer.nomination.list', [$check_details->uuid, $member['member_id']]) }}"
                                                    class="btn btn-secondary btn-circle btn-sm">
                                                    <i class="fas fa-fw fa-users"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
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
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#nomination_list').DataTable({
                "columnDefs": [{
                    "width": "5%",
                    "targets": 4
                }, {
                    "width": "30%",
                    "targets": 0
                }],
            });
        });

        const rejectMember = (name, member_id, nomination_uuid, position_uuid) => {
            Swal.fire({
                title: `Do you want to reject ${name} from this position?`,
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `Don't`,
                icon: 'warning'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loader").css('display', 'block');
                    $("body").addClass('disable-loader');
                    $.ajax({
                            url: "{{ route('admin.nomination.position.reject') }}",
                            type: "POST",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                member_id: member_id,
                                nomination_uuid: nomination_uuid,
                                position_uuid: position_uuid
                            }
                        })
                        .done(function(data) {
                            $("#loader").css('display', 'none');
                            $("body").removeClass('disable-loader');
                            Swal.fire({
                                icon: data[0],
                                title: data[0],
                                text: data[1],
                            });
                            if (data[0] == "success")
                                window.setTimeout(function() {
                                    location.reload();
                                }, 2000);
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            $("#loader").css('display', 'none');
                            $("body").removeClass('disable-loader');
                            alert('No response from server');
                        });

                }
            })
        }

        const acceptMember = (name, member_id, nomination_uuid, position_uuid) => {
            Swal.fire({
                title: `Do you want to accept ${name} from this position?`,
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `Don't`,
                icon: 'warning'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#loader").css('display', 'block');
                    $("body").addClass('disable-loader');
                    $.ajax({
                            url: "{{ route('admin.nomination.position.accept') }}",
                            type: "POST",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                member_id: member_id,
                                nomination_uuid: nomination_uuid,
                                position_uuid: position_uuid
                            }
                        })
                        .done(function(data) {
                            $("#loader").css('display', 'none');
                            $("body").removeClass('disable-loader');
                            Swal.fire({
                                icon: data[0],
                                title: data[0],
                                text: data[1],
                            });
                            if (data[0] == "success")
                                window.setTimeout(function() {
                                    location.reload();
                                }, 2000);
                        })
                        .fail(function(jqXHR, ajaxOptions, thrownError) {
                            $("#loader").css('display', 'none');
                            $("body").removeClass('disable-loader');
                            alert('No response from server');
                        });

                }
            })
        }
    </script>
@endpush
