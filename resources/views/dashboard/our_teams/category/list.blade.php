@extends('dashboard.layouts.master')
@section('title', __('Our Team Category'))
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
    </style>
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Our Teams Category List') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> /
                    <a href="#">{{ __('Our Teams Category List') }}</a>
                </small>
                <a href="{{ route('admin.our_teams.category.create') }}"
                    class="btn btn-primary float-right mt-2 mb-2 @if (!Auth::user()->hasPermission('our_team-create')) disabled @endif">
                    Add
                    Our Team Category
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered m-a-0" id="our_team_cat_table">
                    <thead class="dker">
                        <tr>
                            <th class="custom-th" style="width: 70%;">{{ __('Category Title') }}</th>
                            <th class="custom-th">{{ __('Category status') }}</th>
                            <th class="custom-th">{{ __('Actions ') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($OurTeamCategoryLists) > 0)
                            @foreach ($OurTeamCategoryLists as $OurTeamCategoryList)
                                @if ($OurTeamCategoryList->ourTeamCatContent != null)
                                    <tr>
                                        <td class="custom-td">
                                            {{ $OurTeamCategoryList->ourTeamCatContent->title }}
                                        </td>
                                        <td class="custom-td text-center">

                                            @if ($OurTeamCategoryList->status == 1)
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
                                                        <span class="text">Draft</span>
                                                    </a>
                                            @endif
                                        </td>
                                        <td class="custom-td action-td">
                                            @php
                                                $url = url('') . '/admin/our-teams/category/edit?uid=' . $OurTeamCategoryList->uid;
                                            @endphp


                                            <a href="{{ $url }}"
                                                class="btn btn-info btn-circle btn-sm mr-2 float-right  @if (!Auth::user()->hasPermission('our_team-update')) disabled @endif"><i
                                                    class="fas fa-edit"></i>
                                            </a>
                                            <a href="javascript:void(0)"
                                                onclick="deleteOurTeamCategoryPage('{{ $OurTeamCategoryList->uid }}')"
                                                class="btn btn-danger btn-circle btn-sm  @if (!Auth::user()->hasPermission('our_team-delete')) disabled @endif">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>

                                            {{-- <a href="{{ $url }}" class="btn btn-sm success"
                                                style="padding: 0px 5px; line-height:1px;" data-toggle="tooltip"
                                                data-original-title=" Edit">
                                                <i class="material-icons">&#xe3c9;</i>
                                            </a>
                                            @php
                                                $url = url('') . '/admin/our-teams/category/delete/' . $OurTeamCategoryList->id;
                                            @endphp
                                            <a href="javascript:void(0)"
                                                onclick="deleteOurTeamCategoryPage('{{ $OurTeamCategoryList->uid }}')"
                                                style="color: black;"><i class="material-icons"
                                                    style="font-size: 15px;">&#xe872;</i></a> --}}
                                            {{-- <button type="button" class="btn btn-sm warning"
                                                style="padding: 0px 5px; line-height:1px;" data-toggle="modal"
                                                data-target="#m-{{ $OurTeamCategoryList->uid }}"
                                                data-original-title=" Delete">
                                                <i class="material-icons">&#xe872;</i>
                                            </button> --}}
                                        </td>
                                    </tr>
                                @endif
                                <!-- .modal -->
                                <div id="m-{{ $OurTeamCategoryList->uid }}" class="modal fade" data-backdrop="true">
                                    <div class="modal-dialog" id="animate">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.our_teams.category.delete') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="uid"
                                                    value="{{ $OurTeamCategoryList->uid }}">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ __('backend.confirmation') }}
                                                    </h5>
                                                </div>
                                                <div class="modal-body  p-lg">
                                                    <div>
                                                        {{ __('backend.confirmationDeleteMsg') }}
                                                    </div>
                                                    <div class="confirmation_content_designs">
                                                        <strong>[
                                                            {!! $OurTeamCategoryList->ourTeamCatContent->title !!} Category
                                                            ]</strong>
                                                    </div>
                                                    <ul class="warning-text-design">
                                                        <li>
                                                            Deleting a Our Team Category will be
                                                            permanently deleted from our system ,
                                                            Any our team for this category will not show
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn p-x-md dismiss-btn-design"
                                                        data-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn danger p-x-md">Submit</button>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div>
                                </div>
                                <!-- / .modal -->
                            @endforeach
                    </tbody>
                    @endif
                </table>
            </div>

        </div>
    </div>
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#our_team_cat_table').DataTable();
        });
        let deleteOurTeamCategoryPage = (id) => {
            Swal.fire({
                title: 'Do you want to delete the category?',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                denyButtonText: `Cancel`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.our_teams.category.delete') }}",
                        type: 'post',
                        data: {
                            '_token': "{{ csrf_token() }}",
                            'uid': id
                        },
                        success: function(data) {
                            console.log(data);
                            if (data.status == 'success') {
                                Swal.fire('Success!', data.message, 'success');
                            } else {
                                Swal.fire('Warning!', data.message, 'info')
                            }
                            setTimeout(function() {
                                location.reload(true);
                            }, 3000);
                        },
                        error: function(res) {
                            Swal.fire('Error!', 'Something went wrong please try after sometime',
                                'error');
                            setTimeout(function() {
                                location.reload(true);
                            }, 3000);
                        }
                    });
                }
            })
        }
    </script>
@endpush
