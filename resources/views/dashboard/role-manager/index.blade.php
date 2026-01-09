@extends('dashboard.layouts.master')

@section('title', __('Role Manager'))
@push('after-styles')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/js/datatables/datatables.min.css') }}">
@endpush
@section('content')


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

    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <div class="padding">
        <div class="box">

            <div class="box-header dker">
                <h3>{{ __('Role Manager') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> /
                    {{ __('Role Manager') }}
                </small>
                <a href="{{ route('admin.role.create') }}"
                    class="btn btn-primary float-right mt-2 mb-2 @if (!Auth::user()->hasPermission('role-create')) disabled @endif"> Create
                    New
                    Role </a>
            </div>
            @if (count($roles))
                <div class="table-responsive">
                    <table class="table table-bordered m-a-0" id="rolestable">
                        <thead class="dker">
                            <tr>
                                <th class="custom-th">{{ __('Sl No.') }}</th>
                                <th class="custom-th">{{ __('Roles Name') }}</th>
                                <th class="custom-th">{{ __('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($roles as $index => $val)
                                <tr>
                                    <td class="custom-td">
                                        {{ ++$index }}
                                    </td>
                                    <td class="custom-td">
                                        {{ $val->display_name }}
                                    </td>
                                    <td class="custom-td">
                                        @if ($val->display_name == 'Superadmin')
                                            System Reserved
                                        @else
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item @if (!Auth::user()->hasPermission('role-update')) disabled @endif"
                                                        href="{{ route('admin.role.edit', ['id' => $val->id]) }}">Edit</a>
                                                    <a class="dropdown-item @if (!Auth::user()->hasPermission('role-delete')) disabled @endif"
                                                        href="JavaScript:void(0)"
                                                        onclick="deleteFunction('{{ $val->id }}')">Delete</a>
                                                </div>
                                            </div>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    <!-- ENd of pdf ection -->
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // let rolestable = new DataTable('#rolestable');
            $('#rolestable').DataTable();
        });

        let deleteFunction = (id) => {
            Swal.fire({
                title: 'Are you sure to delete?',
                text: "You won't be able to revert this role",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.role.delete') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            role_id: id
                        },
                        type: "post",
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire(data.message, '', 'success')
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            }
                            if (data.status == 'error') {
                                Swal.fire(data.message);
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
            })
        }
    </script>
@endpush
