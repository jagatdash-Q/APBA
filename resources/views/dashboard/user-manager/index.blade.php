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
                <h3>{{ __('User Manager') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> /
                    <a href="">{{ __('User Manager') }}</a>
                </small>
                <a href="{{ route('admin.user.create') }}"
                    class="btn btn-primary float-right mt-2 mb-2 @if (!Auth::user()->hasPermission('users-create')) disabled @endif"> Create
                    New
                    User
                </a>
            </div>
            @if (count($user))
                <div class="table-responsive">
                    <table class="table table-bordered m-a-0" id="rolestable">
                        <thead class="dker">
                            <tr>
                                <th class="custom-th">{{ __('Sl No.') }}</th>
                                <th class="custom-th">{{ __('Name') }}</th>
                                <th class="custom-th">{{ __('Email ') }}</th>
                                <th class="custom-th">{{ __('Role') }}</th>
                                @if (Auth::user()->hasRole('superadmin'))
                                    <th class="custom-th">{{ __('2FA Reset') }}</th>
                                @endif
                                <th class="custom-th">{{ __('Options') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($user as $index => $val)
                                <tr>
                                    <td class="custom-td">
                                        {{ ++$index }}
                                    </td>
                                    <td class="custom-td">
                                        {{ $val->name }}
                                    </td>
                                    <td class="custom-td">
                                        {{ $val->email }}
                                    </td>
                                    <td class="custom-td">
                                        @if ($val->getRole != null)
                                            @if ($val->getRole->getRoleDetails != null)
                                                {{ $val->getRole->getRoleDetails->display_name }}
                                            @else
                                                No data available
                                            @endif
                                        @endif
                                    </td>
                                    @if (Auth::user()->hasRole('superadmin'))
                                        <td class="custom-td">
                                            <form action="{{ route('admin.reset.2fa') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $val->id }}">
                                                <input type="submit" class="btn btn-danger" value="Reset">
                                            </form>
                                        </td>
                                    @endif
                                    <td class="custom-td">
                                        @if ($val->getRole != null)
                                            @if ($val->getRole->getRoleDetails != null)
                                                @if ($val->getRole->getRoleDetails->display_name == 'Superadmin')
                                                    System Reserved
                                                @else
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item @if (!Auth::user()->hasPermission('users-update')) disabled @endif"
                                                                href="{{ route('admin.user.edit', ['id' => $val->id]) }}">Edit</a>
                                                            <a class="dropdown-item @if (!Auth::user()->hasPermission('users-delete')) disabled @endif"
                                                                href="JavaScript:void(0)"
                                                                onclick="deleteFunction('{{ $val->id }}')">Delete</a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="dropdown">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item @if (!Auth::user()->hasPermission('users-update')) disabled @endif"
                                                            href="{{ route('admin.user.edit', ['id' => $val->id]) }}">Edit</a>
                                                        <a class="dropdown-item @if (!Auth::user()->hasPermission('users-delete')) disabled @endif"
                                                            href="JavaScript:void(0)"
                                                            onclick="deleteFunction('{{ $val->id }}')">Delete</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    Action
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item @if (!Auth::user()->hasPermission('users-update')) disabled @endif"
                                                        href="{{ route('admin.user.edit', ['id' => $val->id]) }}">Edit</a>
                                                    <a class="dropdown-item @if (!Auth::user()->hasPermission('users-delete')) disabled @endif"
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
                text: "You won't be able to revert this user",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.user.delete') }}",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            id: id
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
