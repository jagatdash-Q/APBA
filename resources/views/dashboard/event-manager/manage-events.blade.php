@extends('dashboard.layouts.master')
@section('title', __('Manage Events'))
@section('content')
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
    @endpush
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Manage Events Page') }}</h3>
                <small>
                    {{-- <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> / --}}
                    <a class="btn btn-primary float-right mt-2 mb-2  @if (!Auth::user()->hasPermission('event_management-create')) disabled @endif" href="{{ route('admin.event.create') }}">
                        <i class="material-icons">&#xe145;</i>
                        &nbsp; {{ __('Add New Event') }}
                    </a>
                </small>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered m-a-0" id="manage_events_table">
                    <thead class="dker">
                        <tr>
                            <th class="custom-th">{{ __('Event Name') }}</th>
                            <th class="custom-th">{{ __('Location') }}</th>
                            <th class="custom-th">{{ __('Event Start & End Date') }}</th>
                            {{-- <th class="custom-th">{{ __('Publish Date') }}</th> --}}
                            <th class="custom-th">{{ __('Event Active') }}</th>
                            {{-- <th class="custom-th">{{ __('Total No. of Registrants') }}</th>
                            <th class="custom-th">{{ __('Total Amount Received') }}</th>
                            <th class="custom-th">{{ __('Total Amount Unpaid') }}</th> --}}
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $val)
                            <tr>
                                <td> {{ $val->event_name }} </td>
                                <td> {{ $val->event_location }} </td>
                                <td> {{ \Carbon\Carbon::parse($val->start_date)->format('d F Y') }} -
                                    {{ \Carbon\Carbon::parse($val->end_date)->format('d F Y') }}</td>
                                {{-- <td>
                                    @if ($val->publish_date!='')
                                        {{ \Carbon\Carbon::parse($val->publish_date)->format('d F Y') }}
                                    @endif
                                </td> --}}
                                <td>
                                    @if ($val->status == '0')
                                        <a href="javascript:void();" class="btn btn-warning btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </span>
                                            <span class="text">No</span>
                                        </a>
                                    @else
                                        <a href="javascript:void();" style="pointer-events: none;"
                                            class="btn btn-success btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="text">Yes</span>
                                    @endif

                                </td>
                                {{-- <td> 0 </td>
                                <td> 0 </td>
                                <td> 0 </td> --}}
                                <td class="action-td">
                                    <a href="{{ route('admin.event.edit', ['slug' => $val->uid]) }}"
                                        class="btn btn-info btn-circle btn-sm mr-2 float-right @if (!Auth::user()->hasPermission('event_management-update')) disabled @endif"><i class="fas fa-edit"></i>
                                    </a>
                                    {{-- @if ($val->status == '0')
                                        <a class="btn btn-success btn-circle btn-success btn-sm mr-2 float-right"
                                            href="{{ route('admin.event.status.update', ['status' => '1', 'event_id' => $val->id]) }}"><i class="fas fa-check"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-warning btn-circle btn-sm mr-2 float-right"
                                            href="{{ route('admin.event.status.update', ['status' => '0', 'event_id' => $val->id]) }}"><i class="fas fa-exclamation-triangle"></i>
                                        </a>
                                    @endif --}}
                                    <a href="javascript:void(0)"
                                        class="btn btn-danger btn-circle btn-sm mr-2 float-right  @if (!Auth::user()->hasPermission('event_management-delete')) disabled @endif" onclick="deleteEvent('{{ $val->id }}')"><i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <small class="text-muted inline m-t-sm m-b-sm">{{ __('Showing') }}
                        {{-- {{ $events->firstItem() }}
                        -{{ $events->lastItem() }} {{ __('Of') }}
                        <strong>{{ $events->total() }}</strong> {{ __('records') }}</small> --}}
                </div>
            </div>
            <div style="margin-top:10px;">
                <div class="row">
                    <div class="col-md-12 text-center">
                        {{ $events->links('vendor.pagination.custom') }}
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
            $('#manage_events_table').DataTable({
                responsive: false,
                paging: false,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                },
                bInfo: false,
            });
        });

        let deleteEvent = (id) => {
            Swal.fire({
                title: 'Do you want to delete this Event ?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `Don't`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.event.delete') }}",
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': id,
                        },
                        success: function(data) {
                            // console.log(data);
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

                            setTimeout(() => {
                                window.location.reload();
                            }, 3000);

                            
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: "Something went wrong please contact our technical team",
                            });
                            setTimeout(() => {
                                window.location.reload();
                            }, 3000);
                        }
                    });
                }
            })
        }

    </script>
@endpush
