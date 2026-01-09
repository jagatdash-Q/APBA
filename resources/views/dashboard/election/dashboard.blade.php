@extends('dashboard.layouts.master')
@section('title', __('Election Dashboard'))
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
                    {{ __('Election Dashboard') }}
                </small>
            </div>
            <form action="{{ route('admin.election.dashboard') }}" method="GET">
                <div class="row mb-2">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="election">Nomination Name:</label>
                            <select name="election" class="form-control form-control-user"
                                id="election" required>
                                <option value="" selected>- Choose Nomination -</option>
                                @foreach ($all_votings as $val)
                                    @if ($val->getNominationDetails != null)
                                        <option value="{{ $val->uuid }}">
                                            {{ $val->getNominationDetails->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2 d-flex">
                        <button type="submit" class="btn btn-info btn-circle btn-sm ml-1" name="submit"
                            style="margin-top: 33px;">
                            <i class="fas fa-filter"></i>
                        </button>
                        <button type="button" onclick="window.location.href='{{ route('admin.election.dashboard') }}'" class="btn btn-danger btn-circle btn-sm ml-1"
                            style="margin-top: 33px;">
                            <i class="fas fa-undo"></i>
                        </button>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('admin.election.create') }}" class="btn btn-primary float-right @if (!Auth::user()->hasPermission('election_management-create')) disabled @endif"
                            style="margin-top: 30px;">
                            {{ __('+ Create Election') }}
                        </a>
                    </div>
                </div>
            </form>

            @if (count($vote_progress_data))
                <div class="card shadow mb-4">
                    <div class="card-header" style="font-size: 18px;">
                        <span class="icon text-red-50 mr-2" style="color: blue;">
                            <i class="fas fa-tasks"></i>
                        </span>Election Progress
                    </div>
                    <div class="card-body">

                        @foreach ($vote_progress_data as $chart)
                            <h4 class="small font-weight-bold">{{ $chart['position_name'] }} <span
                                    class="float-right">{{ $chart['total_vote'] }}%</span>
                            </h4>
                            <div class="progress mb-4">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-{{ $chart['color'] }}"
                                    role="progressbar" style="width: {{ $chart['total_vote'] }}%"
                                    aria-valuenow="{{ $chart['total_vote'] }}" aria-valuemin="0"
                                    aria-valuemax="{{ $chart['total_customers'] }}"></div>
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
                            </span>Election List
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered m-a-0" id="nomination_membership_type">
                            <thead class="dker">
                                <tr>
                                    <th class="custom-th">{{ __('Nomination Name') }}</th>
                                    <th class="custom-th">{{ __('Election Postion Name') }}</th>
                                    <th class="custom-th">{{ __('Start Date') }}</th>
                                    <th class="custom-th">{{ __('End Date') }}</th>
                                    <th class="custom-th">{{ __('Status') }}</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($votings !=null)
                                    @if (count($votings->getVotingPositions))
                                        @foreach ($votings->getVotingPositions as $vot)
                                            @if ($vot->getNominationPositionDetails != null && $votings->getNominationDetails != null)
                                                @if ($vot->getNominationPositionDetails->getPosition!=null)
                                                <tr>
                                                    <td>{{ $votings->getNominationDetails->name }}</td>
                                                    <td>{{ $vot->getNominationPositionDetails->getPosition->membership_position }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($votings->start_date)->format('d F Y') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($votings->end_date)->format('d F Y') }}</td>
                                                    <td>
                                                        @if (\Carbon\Carbon::parse(\Carbon\Carbon::now()->format('Y-m-d'))->gt($votings->end_date))
                                                            <a href="javascript:void();" style="pointer-events: none;"
                                                                class="btn btn-danger btn-icon-split">
                                                                <span class="icon text-white-50">
                                                                    <i class="fas fa-exclamation-triangle"></i>
                                                                </span>
                                                                <span class="text">Expired</span>
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
                                                        <a href="{{ route('admin.election.details',['uuid'=>$vot->uuid]) }}"
                                                            class="btn btn-primary btn-circle btn-sm mr-1">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endif
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
    </script>
@endpush
