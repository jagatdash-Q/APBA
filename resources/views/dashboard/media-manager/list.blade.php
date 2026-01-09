{{-- @extends('layouts.admin') --}}
@extends('dashboard.layouts.master')

@section('title', __('Media Manager'))
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
                <h3>{{ __('Media Manager') }}</h3>
                <small>
                    <a href="{{ route('adminHome') }}">{{ __('Home') }}</a> /
                    <a href="">{{ __('Media Manager') }}</a>
                </small>
            </div>



            {{-- @if ($MediaFiles->total() > 0) --}}
            @if (Auth::user()->hasPermission('media_managers-create'))
                <div class="row p-a pull-right" style="float:right">
                    <div class="col-sm-12">
                        <input type="hidden" id="base" value="<?php echo url('/'); ?>">
                        <div class="btn btn-primary float-right mt-2 mb-2" style="padding: 3px 10px;" id="btns"
                            data-toggle="modal" data-target="#showsModal">
                            <i class="material-icons">&#xe145;</i>
                            {{ __('Upload Images & Videos ') }}
                        </div>

                        <button class="btn btn-primary float-right mt-2 mb-2" style="padding: 3px 10px;margin-right:10px"
                            data-toggle="modal" data-target="#pdfModal">
                            <i class="material-icons">&#xe145;</i>
                            {{ __('Upload PDF/DOC/ZIP') }}
                        </button>
                    </div>
                </div>
            @endif

            {{-- @if ($MediaFiles->total() == 0) --}}
            {{-- <div class="row p-a">
                    <div class="col-sm-12">
                        <div class=" p-a text-center ">
                            {{ __('There is no data here up to now') }}
                            <br>
                            <div class="btn btn-fw primary" id="btns" data-toggle="modal" data-target="#showsModal"><i
                                    class="material-icons">&#xe145;</i>
                                &nbsp; {{ __('Upload Images & Videos') }}</div>

                            <button class="btn btn-fw primary" data-toggle="modal" data-target="#pdfModal">
                                <i class="material-icons">&#xe145;</i>
                                &nbsp; {{ __('Upload PDF') }}
                            </button>
                        </div>
                    </div>
                </div> --}}
            {{-- @endif --}}




            {{-- @if ($MediaFiles->total() > 0) --}}
            <div class="table-responsive">
                <table class="table table-bordered m-a-0" id="media_manager_table">
                    <thead class="dker">
                        <tr>
                            <th class="custom-th">{{ __('Icon') }}</th>
                            <th class="custom-th">{{ __('Name') }}</th>
                            <th class="custom-th">{{ __('Alt Tag') }}</th>
                            <th class="custom-th">{{ __('URL') }}</th>
                            <th class="custom-th">{{ __('Type') }}</th>
                            <th class="custom-th">{{ __('Created By') }}</th>
                            <th class="custom-th">{{ __('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($MediaFiles as $index => $File)
                            <tr>
                                <td class="custom-td text-center" style="width: 200px">
                                    @if ($File->file_ext == 'pdf')
                                        <img src="{{ asset('assets/dashboard/images/PDF_file_icon.svg') }}" alt="Icon"
                                            width="200" max-height="120" height="100" style="    object-fit: fill;">
                                    @elseif ($File->file_ext == 'zip')
                                        <img src="{{ asset('assets/dashboard/images/zip-icon.png') }}" alt="Icon"
                                            max-height="120" height="100" style="object-fit: fill;">
                                    @elseif ($File->file_ext == 'docx' || $File->file_ext == 'csv' || $File->file_ext == 'doc')
                                        <img src="{{ asset('assets/dashboard/images/docx-icon.png') }}" alt="Icon"
                                            max-height="120" height="100" style="    object-fit: fill;">
                                    @elseif (in_array($File->file_ext, ['jpeg', 'jpg', 'png', 'gif', 'bmp']))
                                        <img src="{{ asset($File->path) }}" alt="Icon" width="200" max-height="120"
                                            height="100" style="    object-fit: contain;">
                                    @elseif (in_array($File->file_ext, ['mp4', 'webm', 'ogg']))
                                        <video width="200" controls>
                                            <source src="{{ asset($File->path) }}" type="{{ $File->file_type }}">
                                            Your browser does not support HTML video.
                                        </video>
                                    @else
                                        <img src="{{ asset('assets/dashboard/images/image_not_found.png') }}"
                                            alt="Icon" width="200" max-height="120" height="100"
                                            style="object-fit: contain;">
                                    @endif
                                </td>

                                <td class="custom-td">
                                    <input type="hidden" name="media_uid" value="{{ $File->media_uid }}">
                                    <input type="hidden" name="file_name" value="a">
                                    <input type="text" name="file_name" value=" {!! $File->file_name !!}"
                                        class="form-control text-sm" disabled id="{{ $File->media_uid }}">
                                    <button type="button btn-sm success"
                                        onclick="file_sub('{{ $File->media_uid }}','edit_icons_{{ $File->media_uid }}','file_name_change_form_{{ $index }}')"
                                        class="btn btn-primary btn-xs mt-1" style="margin-top: 8px;"
                                        id="file_edit_{{ $File->media_uid }}" style="padding: 0px 5px; line-height:1px;"><i
                                            class="material-icons" style="font-size: 15px;"
                                            id="edit_icons_{{ $File->media_uid }}">border_color</i></button>

                                </td>

                                <td class="custom-td">
                                    <input type="text" name="alt_tag" value=" {!! $File->alt_tag !!}"
                                        class="form-control text-sm" disabled id="alt_{{ $File->media_uid }}">
                                    <button type="button btn-sm success"
                                        onclick="file_sub_alt('{{ $File->media_uid }}','edit_icons_alt_{{ $File->media_uid }}')"
                                        class="btn btn-primary btn-xs mt-1" style="margin-top: 8px;"
                                        id="file_edit_alt_{{ $File->media_uid }}"
                                        style="padding: 0px 5px; line-height:1px;"><i class="material-icons"
                                            style="font-size: 15px;"
                                            id="edit_icons_alt_{{ $File->media_uid }}">border_color</i></button>

                                </td>

                                <td class="custom-td" style="max-width: 40% !important">
                                    <div id="div<?= $index ?>" class="text-sm"> {!! $File->media_url !!}</div>
                                    <br />
                                    <button id="button1" type="button"
                                        onclick="CopyToClipboard('div{{ $index }}')"
                                        class="btn btn-primary btn-xs">Click to copy</button>
                                </td>
                                <td class="custom-td">
                                    {!! $File->file_ext !!}
                                </td>
                                <td class="custom-td">
                                    {{ $File->userDetails->name }}
                                </td>

                                <td class="custom-td">

                                    <button class="btn btn-sm warning @if (!Auth::user()->hasPermission('media_managers-delete')) disabled @endif"
                                        style="padding: 0px 5px; line-height:1px;@if (!Auth::user()->hasPermission('media_managers-delete')) pointer-events:none; @endif"
                                        data-toggle="modal" data-target="#m-{{ $File->id }}"
                                        ui-toggle-class="bounce" ui-target="#animate">
                                        <small><i class="material-icons" style="font-size: 15px;">&#xe872;</i>
                                        </small>
                                    </button>
                                </td>
                            </tr>
                            <!-- .modal -->
                            <div id="m-{{ $File->id }}" class="modal fade" data-backdrop="true">
                                <div class="modal-dialog" id="animate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">{{ __('Confirmation') }}</h5>
                                        </div>
                                        <div class="modal-body p-lg">
                                            <div>
                                                {{ __('Are you sure you want to delete?') }}
                                            </div>
                                            <div class="confirmation_content_design"> <strong>[
                                                    {{ $File->file_name }}
                                                    ]</strong>
                                            </div>
                                            <ul class="warning-text-design">
                                                <li>
                                                    Deleting an image/pdf will permanently delete image/pdf from our
                                                    system.
                                                </li>
                                                <li>
                                                    Any pages/blogs using this image/pdf may experience not found
                                                    error
                                                    (404)
                                                    !
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn p-x-md dismiss-btn-design"
                                                data-dismiss="modal">{{ __('No') }}</button>
                                            <button type="button" onclick="delete_media('{{ $File->media_uid }}')"
                                                class="btn danger p-x-md">{{ __('Yes') }}</button>
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div>
                            </div>
                            <!-- / .modal -->
                        @endforeach

                    </tbody>
                </table>

            </div>
            {{-- <div class="row">
                    <div class="col-md-12 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">{{ __('Showing') }}
                            {{ $MediaFiles->firstItem() }}
                            -{{ $MediaFiles->lastItem() }} {{ __('Of') }}
                            <strong>{{ $MediaFiles->total() }}</strong> {{ __('records') }}</small>
                    </div>
                </div>
                <div style="margin-top:10px;">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            {{ $MediaFiles->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div> --}}
            {{-- @endif --}}
        </div>
    </div>


    @include('dashboard.media-manager.pdf_upload')
    @include('dashboard.common.index')


    <!-- ENd of pdf ection -->
@endsection
@push('after-scripts')
    <script src="{{ asset('assets/dashboard/media_manager/gallery-manager/js/media.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/datatables/datatables.min.js') }}"></script>


    <script type="text/javascript">
        $("#checkAll").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $(document).ready(function() {
            $('#media_manager_table').DataTable({
                responsive: true,
                paging: true,
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                },
                bInfo: false,
            });
        });
        $("#action").change(function() {
            if (this.value == "delete") {
                $("#submit_all").css("display", "none");
                $("#submit_show_msg").css("display", "inline-block");
            } else {
                $("#submit_all").css("display", "inline-block");
                $("#submit_show_msg").css("display", "none");
            }
        });

        function CopyToClipboard(containerid) {
            if (document.selection) {
                var range = document.body.createTextRange();
                range.moveToElementText(document.getElementById(containerid));
                range.select().createTextRange();
                document.execCommand("copy");
            } else if (window.getSelection) {
                var range = document.createRange();
                range.selectNode(document.getElementById(containerid));
                window.getSelection().addRange(range);
                document.execCommand("copy");
                Swal.fire("Media url has been copied.!");
            }
        }

        const file_sub = (input_id, button_id, form_id) => {

            if ($(`#${input_id}`).hasClass('selected')) {

                var fd = new FormData();
                fd.append("media_uid", input_id);
                fd.append("file_name", $(`#${input_id}`).val());
                $.ajax({
                    url: base_url + "/admin/media-manager/filename-change",
                    data: fd,
                    contentType: false,
                    processData: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    type: "POST",
                    success: function(data) {
                        if (data.status == 'success') {
                            console.log("Success");
                            Swal.fire('File name updated successfully!')
                            $(`#${input_id}`).prop('disabled', true);
                            $(`#${button_id}`).text("border_color");
                            $(`#${input_id}`).removeClass('selected');
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
            $(`#${input_id}`).prop('disabled', false);
            $(`#${input_id}`).val($(`#${input_id}`).val().split('.')[0]);

            $(`#${input_id}`).addClass('selected');
            $(`#${button_id}`).text('sync');
        }

        const file_sub_alt = (input_id, button_id) => {

            if ($(`#alt_${input_id}`).hasClass('selected')) {

                var fd = new FormData();
                fd.append("media_uid", input_id);
                fd.append("alt_tag", $(`#alt_${input_id}`).val());
                $.ajax({
                    url: base_url + "/admin/media-manager/alttag-change",
                    data: fd,
                    contentType: false,
                    processData: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    type: "POST",
                    success: function(data) {
                        if (data.status == 'success') {
                            console.log("Success");
                            Swal.fire('File alt tag updated successfully!')
                            $(`#alt_${input_id}`).prop('disabled', true);
                            $(`#${button_id}`).text("border_color");
                            $(`#alt_${input_id}`).removeClass('selected');
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
            $(`#alt_${input_id}`).prop('disabled', false);
            $(`#alt_${input_id}`).val($(`#alt_${input_id}`).val());

            $(`#alt_${input_id}`).addClass('selected');
            $(`#${button_id}`).text('sync');
        }
    </script>
@endpush
