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

        .disp-inline {
            display: inline !important;
        }
    </style>

    <input type="hidden" name="base_url" id="base_url" value="{{ url('/') }}">
    <div class="padding">
        <div class="box">
            <div class="box-header dker">
                <h3>{{ __('Role Manager') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> /
                    <a href="{{ route('admin.roles.manage') }}">{{ __('Role Management') }}</a> /
                    {{ $role_details->display_name }}
                </small>
            </div>
            <div class="row">
                <div class="container">
                    <div class="card pt-2">
                        <form action="{{ route('admin.role.update') }}" method="POST">
                            <input type="hidden" name="role_id" value="{{ $role_details->id }}">
                            @csrf
                            @method('put')
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" id=""
                                        placeholder="" readonly value="{{ $role_details->display_name }}">
                                </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    @if (count($permissions))
                                        @foreach ($permissions as $index => $per)
                                            @php
                                                $count = 0;
                                                $per_name = explode('-', $per->name);
                                            @endphp
                                            @foreach ($role_details->getPermissions as $per_role)
                                                @if ($per->id == $per_role->permission_id)
                                                    @php $count++; @endphp
                                                @endif
                                            @endforeach
                                            <div class="col-md-3">
                                                @if ($count)
                                                    <div class="custom-control custom-checkbox small disp-inline">
                                                        <input type="checkbox" class="custom-control-input {{ $per->name }}"
                                                            id="customCheck{{ $index }}" checked @if ($per_name[1] != 'read') onclick="checkSpecificCheckbox('{{ $per_name[0] }}')" @endif
                                                            name="permissions[]" value="{{ $per->id }}">
                                                        <label class="custom-control-label"
                                                            for="customCheck{{ $index }}">{{ $per->display_name }}</label>
                                                    </div>
                                                @else
                                                    <div class="custom-control custom-checkbox small disp-inline">
                                                        <input type="checkbox" class="custom-control-input {{ $per->name }}"
                                                            id="customCheck{{ $index }}" @if ($per_name[1] != 'read') onclick="checkSpecificCheckbox('{{ $per_name[0] }}')" @endif name="permissions[]"
                                                            value="{{ $per->id }}">
                                                        <label class="custom-control-label"
                                                            for="customCheck{{ $index }}">{{ $per->display_name }}</label>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                            </div>
                            <div class="col-md-12 mt-2 mb-2">
                                <button type="submit" class="btn btn-success"> Publish </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ENd of pdf ection -->
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.min.js') }}"></script>
    <script>
        function checkSpecificCheckbox(permission) {
            if ($(`.${permission}-create:checkbox`).is(":checked") == true || $(`.${permission}-update:checkbox`).is(
                    ":checked") == true || $(`.${permission}-delete:checkbox`).is(":checked") == true) {
                $(`.${permission}-read`).prop('checked', true);
            } else {
                $(`.${permission}-read`).removeAttr('checked');
            }
        }
    </script>
@endpush
