@extends('dashboard.layouts.master')
@section('title', __('Manage Event Activities'))
@section('content')
    @include('dashboard.common.index')
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
        <style>
            .select2-container {
                width: 100% !important;
            }
        </style>
    @endpush
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Manage Event Activities Page') }}</h3>
                @if (Auth::user()->hasPermission('event_management-create'))
                    <small>
                        <button type="button" class="btn btn-primary float-right mt-2 mb-2" data-toggle="modal"
                            data-target="#EventModal">
                            <i class="material-icons">&#xe145;</i>
                            &nbsp; {{ __('Add New Activity') }}
                        </button>
                    </small>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-bordered m-a-0" id="manage_event_activity_table">
                    <thead class="dker">
                        <tr>
                            <th class="custom-th">{{ __('Event Name') }}</th>
                            <th class="custom-th">{{ __('Activities Names') }}</th>
                            <th class="custom-th">{{ __('Activities Dates') }}</th>
                            {{-- <th class="custom-th">{{ __('No. of Registrants') }}</th>
                            <th class="custom-th">{{ __('Amount Received') }}</th>
                            <th class="custom-th">{{ __('Amount Unpaid') }}</th> --}}
                            <th class="custom-th">{{ __('Activities Status') }}</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($workshops) > 0)
                            @foreach ($workshops as $data)
                                <tr>
                                    <td>{{ $data->event_name }}</td>
                                    <td>
                                        <?php $count_wp = 1; ?>
                                        @if (count($data->GetEventWorkshops) > 0)
                                            @foreach ($data->GetEventWorkshops as $item)
                                                <p>WS {{ $count_wp }}:{{ $item->workshop_name }}</p>
                                                <?php $count_wp++; ?>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        @if (count($data->GetEventWorkshops) > 0)
                                            @foreach ($data->GetEventWorkshops as $item)
                                                <p>{{ Carbon\Carbon::parse($item->workshop_date)->format('d F Y') }}</p>
                                            @endforeach
                                        @endif

                                    </td>
                                    {{-- <td>0</td>
                                    <td>0</td>
                                    <td>0</td> --}}
                                    <td>
                                        @if ($data->activities_status == '1')
                                            <a href="javascript:void();" style="pointer-events: none;"
                                                class="btn btn-success btn-icon-split">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">Active</span>
                                            @else
                                                <a href="javascript:void();" class="btn btn-warning btn-icon-split">
                                                    <span class="icon text-white-50">
                                                        <i class="fas fa-exclamation-triangle"></i>
                                                    </span>
                                                    <span class="text">No</span>
                                                </a>
                                        @endif
                                    </td>
                                    <td class="action-td">
                                        <a href="{{ route('admin.event.workshop.edit', $data->uid) }}"
                                            class="btn btn-info btn-circle btn-sm mr-2 float-right  @if (!Auth::user()->hasPermission('event_management-update')) disabled @endif"><i
                                                class="fas fa-edit"></i>
                                        </a>
                                        {{-- <form action="{{ route('admin.event.workshop.status') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="uuid" value="{{ $data->uid }}">
                                            @if ($data->activities_status == '0')
                                                <a class="btn btn-success btn-circle btn-success btn-sm mr-2 float-right"
                                                    href="javascript:void(0)" onclick="$(this).closest('form').submit();"><i
                                                        class="fas fa-check"></i>
                                                </a>
                                                <input type="hidden" name="status" value="1">
                                            @else
                                                <input type="hidden" name="status" value="0">
                                                <a class="btn btn-warning btn-circle btn-sm mr-2 float-right"
                                                    href="javascript:void(0)" onclick="$(this).closest('form').submit();"><i
                                                        class="fas fa-exclamation-triangle"></i>
                                                </a>
                                            @endif
                                        </form> --}}
                                    </td>

                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    {{-- <small class="text-muted inline m-t-sm m-b-sm">{{ __('Showing') }}
                        {{ $workshops->firstItem() }}
                        -{{ $workshops->lastItem() }} {{ __('Of') }}
                        <strong>{{ $workshops->total() }}</strong> {{ __('records') }}</small> --}}
                </div>
            </div>
            <div style="margin-top:10px;">
                <div class="row">
                    <div class="col-md-12 text-center">
                        {{-- {{ $workshops->links('vendor.pagination.custom') }} --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')

    <div class="modal fade" id="EventModal" tabindex="-1" aria-labelledby="EventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EventModalLabel">Choose Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="container">
                            <div class="pt-2">
                                <div class="card p-3">
                                    <form action="{{ route('admin.event.workshop.create') }}" method="get">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="eventpicker">Choose Event</label>
                                                    <select name="eventpicker" class="form-control" id="eventpicker"
                                                        required>
                                                        @foreach ($all_events as $eve)
                                                            <option value="{{ $eve->uid }}">{{ $eve->event_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-2">
                                                <button type="submit" class="btn btn-primary"> Create Activity </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
            $('#manage_event_activity_table').DataTable({
                responsive: false,
                paging: false,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                },
                bInfo: false,
            });
            $('#eventpicker').select2({
                dropdownParent: $('#EventModal')
            });
        });
    </script>
@endpush
