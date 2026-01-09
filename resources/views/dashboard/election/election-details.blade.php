@extends('dashboard.layouts.master')
@section('title', __('Election Details'))
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

        .row-disabled {
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
                    <a href="{{ route('admin.election.dashboard') }}">{{ __('Election Dashboard') }}</a> /
                    @if ($voting_details != null)
                        @if ($voting_details->getNominationPositionDetails != null)
                            @if ($voting_details->getNominationPositionDetails->getPosition != null)
                                {{ $voting_details->getNominationPositionDetails->getPosition->membership_position }}
                            @endif
                        @endif
                    @endif
                </small>

            </div>


            <div class="card">
                <div class="card-header" style="font-size: 18px;">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="icon text-red-50 mr-2" style="color: blue;">
                                <i class="fas fa-user-friends"></i>
                            </span>Members Election List
                        </div>
                        <div class="col-md-6 text-right">
                            @if ($position_details != null)
                                <form action="{{ route('election.position.export') }}" method="GET">
                                    <input type="hidden" name="voting_position_uuid"
                                        value="{{ $position_details->voting_position_uuid }}">
                                    <button type="submit" class="btn">
                                        <i class="fas fa-file-excel text-right" style="font-size:30px;color:green;"
                                            title="Download data in Excel"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <ul>
                                <li>Election Start & End Date: <b>
                                        @if ($voting_details != null)
                                            @if ($voting_details->getVotingDetails != null)
                                                {{ Carbon\Carbon::parse($voting_details->getVotingDetails->start_date)->format('F jS,Y') }}
                                                to
                                                {{ Carbon\Carbon::parse($voting_details->getVotingDetails->end_date)->format('F jS,Y') }}
                                    </b>
                                    @endif
                                    @endif
                                </li>
                                <li>Nomination Name: <b>
                                        @if ($voting_details != null)
                                            @if ($voting_details->getVotingDetails != null)
                                                @if ($voting_details->getVotingDetails->getNominationDetails != null)
                                                    {{ $voting_details->getVotingDetails->getNominationDetails->name }}
                                                @endif
                                            @endif
                                        @endif
                                    </b></li>
                                <li>Membership Type: <b>
                                        {{-- @if ($position_details != null)
                                            @if (isset($position_details->getVotingPositionDetails))
                                                @if (isset($position_details->getVotingPositionDetails->getNominationPositionDetails))
                                                    @if (isset($position_details->getVotingPositionDetails->getNominationPositionDetails->getPosition))
                                                        @if (isset($position_details->getVotingPositionDetails->getNominationPositionDetails->getPosition->getMembershipType))
                                                            {{ $position_details->getVotingPositionDetails->getNominationPositionDetails->getPosition->getMembershipType->membership_type }}
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        @endif --}}
                                        @if ($voting_details != null)
                                            @if ($voting_details->getNominationPositionDetails != null)
                                                @if ($voting_details->getNominationPositionDetails->getPosition != null)
                                                    @if ($voting_details->getNominationPositionDetails->getPosition->getMembershipType != null)
                                                        {{ $voting_details->getNominationPositionDetails->getPosition->getMembershipType->membership_type }}
                                                    @endif
                                                @endif
                                            @endif
                                        @endif
                                    </b>
                                </li>
                                <li>Position: <b>
                                        @if ($voting_details != null)
                                            @if ($voting_details->getNominationPositionDetails != null)
                                                @if ($voting_details->getNominationPositionDetails->getPosition != null)
                                                    {{ $voting_details->getNominationPositionDetails->getPosition->membership_position }}
                                                @endif
                                            @endif
                                        @endif
                                    </b>
                                </li>
                                @if ($is_member_elected != null)
                                    @if ($is_member_elected->getElectedMemberDetails != null)
                                        <li>Elected Member: <b>
                                                {{ $is_member_elected->getElectedMemberDetails->user_name }}
                                            </b> </li>
                                    @endif
                                @endif
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
                                    <th class="text-center" style="width:200px;">{{ __('Action') }}</th>
                                </tr>
                            </thead>

                            <tbody>

                                @php
                                    $class = '';
                                @endphp

                                @if ($is_member_elected != null)
                                    @php $class = 'row-disabled' @endphp
                                @endif


                                @if ($voting_details->getVotingDetails != null)
                                    @foreach ($details as $val)
                                        <tr>
                                            <td class="custom-td">
                                                <div class="avatar avatar-md mr-3 mt-1 float-left">
                                                    <img src="@if ($val['customer_image'] == '') {{ asset('/assets/frontend/images/avatar_white.gif') }}
                            @else
                                {{ asset('uploads/profile_pic/' . $val['customer_image']) }} @endif"
                                                        alt="">
                                                </div>
                                                <div class="mt-3">
                                                    <strong>{{ $val['customer_name'] }}</strong>
                                                </div>
                                            </td>

                                            <td>
                                                <a href="javascript:void();" style="pointer-events: none;"
                                                    class="btn btn-primary btn-icon-split btn-sm">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-flag"></i>
                                                    </span>
                                                    <span class="text">{{ $val['total_vote'] }}</span>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="row no-gutters align-items-center">
                                                    <div class="col-auto">
                                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                            {{ $val['total_vote_percentage'] }}%</div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="progress progress-sm mr-2">
                                                            <div class="progress-bar bg-info" role="progressbar"
                                                                style="width: {{ $val['total_vote_percentage'] }}%"
                                                                aria-valuenow="{{ $val['total_vote_percentage'] }}"
                                                                aria-valuemin="0" aria-valuemax="{{ $total_customer }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td style="justify-content:center;display:flex;">
                                                <a href="{{ route('admin.view.member', [$val['customer_id'], 'type' => 'election', 'position_uuid' => $voting_details->uuid]) }}"
                                                    class="btn btn-primary btn-circle btn-sm mr-1">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="javascript:void(0);"
                                                    class="btn btn-success btn-circle btn-sm mr-1 {{ $class }}"
                                                    onclick="electMember('{{ $voting_details->getVotingDetails->uuid }}','{{ $voting_details->uuid }}','{{ $val['customer_id'] }}','{{ $val['customer_name'] }}')">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="{{ route('admin.election.get.choosed.member.list', ['uuid' => $val['voting_position_uuid'], 'member_id' => $val['customer_id']]) }}"
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
                    "targets": 3
                }]
            });
        });

        let electMember = (voting_uuid, voting_position_uuid, member_id, customer_name) => {

            Swal.fire({
                title: `Do you want to elect ${customer_name} for this position?`,
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `Don't`,
                icon: 'warning'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#nomination_position').html('');
                    $("#loader").css('display', 'block');
                    $("body").addClass('disable-loader');
                    $.ajax({
                        url: "{{ route('admin.election.position.select.member') }}",
                        type: 'post',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'voting_uuid': voting_uuid,
                            'voting_position_uuid': voting_position_uuid,
                            'member_id': member_id,
                        },
                        success: function(data) {
                            console.log(data);
                            $("#loader").css('display', 'none');
                            $("body").removeClass('disable-loader');
                            if (data.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: data.message,
                                });
                            } else {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Oops...',
                                    text: data.message,
                                });
                            }
                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);

                        },
                        error: function(res) {
                            console.log(res);
                            $("#loader").css('display', 'none');
                            $("body").removeClass('disable-loader');
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: "Something went wrong please contact our technical team",
                            });
                            setTimeout(function() {
                                window.location.reload();
                            }, 3000);
                        }
                    });
                }
            });




        }
    </script>
@endpush
