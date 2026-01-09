@extends('dashboard.layouts.master')
@section('title', __('Manage News'))
@section('content')
    @push('after-styles')
        <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
    @endpush
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Manage News Page') }}</h3>
                <small>
                    {{-- <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> / --}}
                    <a class="btn btn-primary float-right mt-2 mb-2  @if (!Auth::user()->hasPermission('news_management-create')) disabled @endif" href="{{ route('admin.create.news') }}">
                        <i class="material-icons">&#xe145;</i>
                        &nbsp; {{ __('Add New News') }}
                    </a>
                </small>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered m-a-0" id="manage_news_table">
                    <thead class="dker">
                        <tr>
                            <th class="custom-th">{{ __('Name') }}</th>
                            {{-- <th class="custom-th">{{ __('Image') }}</th> --}}
                            <th class="custom-th">{{ __('Start Date') }}</th>
                            <th class="custom-th">{{ __('End Date') }}</th>
                            <th class="custom-th">{{ __('Publish Date') }}</th>
                            <th class="custom-th">{{ __('Status') }}</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($news as $val)
                            <tr>
                                <td> {{ $val->event_name }} </td>
                                {{-- <td class="custom-td sorting_1" style="width: 200px" tabindex="0">
                                    <img src="{{ asset($val->getFeaturedImage->path) }}" alt="Icon" width="200"
                                        max-height="120" height="100" style="object-fit: contain;">
                                </td> --}}
                                <td>
                                    @if ($val->start_date != null)
                                        {{ \Carbon\Carbon::parse($val->start_date)->format('d F Y') }}
                                    @endif
                                </td>
                                <td>
                                    @if ($val->end_date != null)
                                        {{ \Carbon\Carbon::parse($val->end_date)->format('d F Y') }}
                                    @endif
                                </td>
                                <td> @if ($val->publish_date!='')
                                    {{ \Carbon\Carbon::parse($val->publish_date)->format('d F Y') }}
                                @endif</td>
                                <td>
                                    @if ($val->status == '0')
                                        <a href="javascript:void();" class="btn btn-warning btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-exclamation-triangle"></i>
                                            </span>
                                            <span class="text">Inactive</span>
                                        </a>
                                    @else
                                        <a href="javascript:void();" style="pointer-events: none;"
                                            class="btn btn-success btn-icon-split">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span class="text">Active</span>
                                    @endif

                                </td>
                                <td class="action-td">
                                    <a href="{{ route('admin.edit.news', $val->uid) }}"
                                        class="btn btn-info btn-circle btn-sm mr-2 float-right  @if (!Auth::user()->hasPermission('news_management-update')) disabled @endif"><i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.delete.news') }}" method="POST"
                                        id="delete_news_form_{{ $val->id }}">
                                        @method('delete')
                                        @csrf
                                        <input type="hidden" name="uuid" id="uuid" value="{{ $val->uid }}">

                                        <a href="javascript:void(0)" onclick="deleteFunction('{{ $val->id }}')"
                                            class="btn btn-danger btn-circle btn-sm  @if (!Auth::user()->hasPermission('news_management-delete')) disabled @endif">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>

                                    </form>

                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <small class="text-muted inline m-t-sm m-b-sm">{{ __('Showing') }}
                        {{ $news->firstItem() }}
                        -{{ $news->lastItem() }} {{ __('Of') }}
                        <strong>{{ $news->total() }}</strong> {{ __('records') }}</small>
                </div>
            </div>
            <div style="margin-top:10px;">
                <div class="row">
                    <div class="col-md-12 text-center">
                        {{ $news->links('vendor.pagination.custom') }}
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
            $('#manage_news_table').DataTable({
                responsive: false,
                paging: false,
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
