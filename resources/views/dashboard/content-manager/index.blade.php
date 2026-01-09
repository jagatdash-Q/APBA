@extends('dashboard.layouts.master')
@section('title', __('Content Manager'))
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
                <h3>{{ __('Content Manager') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> /
                    <a href="">{{ __('Content Manager') }}</a>
                </small>
                @if (count($templates) && Auth::user()->hasPermission('content_management-create'))
                    <div class="dropdown float-right mt-2 mb-2">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Add Page
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            @foreach ($templates as $temp)
                                <a class="dropdown-item"
                                    href="{{ route('admin.content.create', ['id' => $temp->id, 'slug' => $temp->template_slug]) }}">{{ $temp->template_name }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

            <div class="table-responsive">
                <table class="table table-bordered m-a-0" id="contentTable">
                    <thead class="dker">
                        <tr>
                            <th class="custom-th">{{ __('Sl No.') }}</th>
                            <th class="custom-th">{{ __('Template type') }}</th>
                            <th class="custom-th">{{ __('Created By') }}</th>
                            <th class="custom-th">{{ __('Created On') }}</th>
                            <th class="custom-th">{{ __('Modified On') }}</th>
                            <th class="custom-th">{{ __('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($contents))
                            @foreach ($contents as $index => $val)
                                <tr>
                                    <td class="custom-td">
                                        {{ ++$index }}
                                    </td>
                                    <td class="custom-td">
                                        {{ $val->template_type }}
                                    </td>
                                    <td class="custom-td">
                                        @if ($val->getCreaterDetails != null)
                                            {{ $val->getCreaterDetails->name }}
                                        @endif
                                    </td>
                                    <td class="custom-td">
                                        {{ \Carbon\Carbon::parse($val->created_at)->format('d F Y') }}
                                    </td>
                                    <td class="custom-td">
                                        {{ \Carbon\Carbon::parse($val->updated_at)->format('d F Y') }}
                                    </td>
                                    <td class="custom-td action-td">

                                        @if ($val->template_type == 'about')
                                            <a href="{{ route('admin.content.about-page.edit', ['id' => $val->id]) }}"
                                                class="btn btn-info btn-circle btn-sm mr-2 float-right @if (!Auth::user()->hasPermission('content_management-update')) disabled @endif"><i
                                                    class="fas fa-edit"></i>
                                            </a>
                                            {{-- <a onclick="deletePage('{{ $val->id }}','about')"
                                                class="btn btn-danger btn-circle btn-sm">
                                                <i class="fas fa-trash-alt"></i>
                                            </a> --}}
                                        @elseif ($val->template_type == 'membership')
                                            <a href="{{ route('admin.content.membership.edit', ['id' => $val->id]) }}"
                                                class="btn btn-info btn-circle btn-sm mr-2 float-right @if (!Auth::user()->hasPermission('content_management-update')) disabled @endif"><i
                                                    class="fas fa-edit"></i>
                                            </a>
                                        @elseif ($val->template_type == 'resources')
                                            <a href="{{ route('admin.resource.edit', $val->id) }}"
                                                class="btn btn-info btn-circle btn-sm mr-2 float-right @if (!Auth::user()->hasPermission('content_management-update')) disabled @endif"><i
                                                    class="fas fa-edit"></i>
                                            </a>
                                        @elseif ($val->template_type == 'contact-us')
                                            <a href="{{ route('admin.contact.us.edit', $val->id) }}"
                                                class="btn btn-info btn-circle btn-sm mr-2 float-right @if (!Auth::user()->hasPermission('content_management-update')) disabled @endif"><i
                                                    class="fas fa-edit"></i>
                                            </a>
                                        @elseif ($val->template_type == 'home')
                                            <a href="{{ route('admin.home.page.edit', $val->id) }}"
                                                class="btn btn-info btn-circle btn-sm mr-2 float-right @if (!Auth::user()->hasPermission('content_management-update')) disabled @endif"><i
                                                    class="fas fa-edit"></i>
                                            </a>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

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
            $('#contentTable').DataTable();
        });

        let deletePage = (id, page_type) => {
            Swal.fire({
                title: 'Do you want to delete this content page?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                denyButtonText: `Don't`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.content.page.delete') }}",
                        type: 'POST',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id': id,
                            'page_type': page_type
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
                        },
                        error: function(error) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: "Something went wrong please contact our technical team",
                            });
                        }
                    });
                }
            })
        }
    </script>
@endpush
