@extends('dashboard.layouts.master')
@section('title', __('Update Event Activity'))
@section('content')
    @push('after-styles')
        <style>
            .card-header {
                cursor: pointer;
            }

            .card .card-header[data-toggle="collapse"]::after {
                color: #4e73df;
                content: '\f077';
            }

            .card .card-header[data-toggle="collapse"].collapsed::after {
                color: #4e73df;
                content: '\f078';
            }

            .del_icon {
                width: 50px;
                margin-left: -30px;
                margin-right: 10px;
                color: red;
                cursor: pointer;
            }

            .speaker-sec {
                padding: 10px;
                border: 1px solid black;
                border-radius: 10px;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .sub-activity-container {
                padding: 10px;
                border: 1px solid black;
                border-radius: 10px;
                margin-top: 5px;
                margin-bottom: 5px;
            }

            .main-container {
                margin: 10px;
            }

            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                margin: 0;
            }

            .empty-editor {
                border: 2px solid red !important;
            }
        </style>
    @endpush
    @include('dashboard.common.index')
    <div class="padding">
        <div class="box m-b-0">
            <div class="box-header dker">
                <h3>{{ __('Edit Event Activity Details') }}</h3>
            </div>
            <div class="box-tool">
                <ul class="nav">
                    <li class="nav-item inline">
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <form id="workshop_form">
                    @csrf
                    <input type="hidden" id="total_activity" name="total_activity"
                        value="{{ count($workshops->GetEventWorkshops) }}">
                    <input type="hidden" name="event_id" value="{{ $workshops->id }}">
                    <input type="hidden" id="activity_optional_count" name="activity_optional_count"
                        value="{{ count($workshops->getEventWorkshopOptional) }}">
                    <input type="hidden" name="page" value="1">
                    <input type="hidden" name="activities_status" id="activities_status" value="1">
                    <div class="form-group row mt-2 mb-2">
                        <div class="col-md-12 text-right">
                            <button onclick="addActivityOptional();" class="btn btn-primary" type="button">Add activity
                                optional price</button>
                        </div>
                        <div class="col-12" id="append_optional_price"></div>

                        {{-- <div class="col-md-6" style="display:flex !important;">
                            <span>Conference Registration Fee : </span>
                            <input type="number" name="conference_registration_fee" id="conference_registration_fee"
                                class="form-control" value="{{ $workshops->conference_registration_fee }}" />
                        </div>
                        <div class="col-md-6" style="display:flex !important;">
                            <span>Networking Dinner Fee : </span>
                            <input type="number" name="networking_dinner_fee" id="networking_dinner_fee"
                                class="form-control" value="{{ $workshops->networking_dinner_fee }}" />
                        </div> --}}
                    </div>
                    <div class="pt-2 card">
                        <div id="activity_container" class="accordion-sort">
                        </div>
                        <div class="col-md-12 mt-2 mb-2">
                            <button class="btn btn-primary" type="button" onclick="addActivity()">Add new Activity</button>
                        </div>
                        <div class="col-md-12 mt-2 mb-2" id="submit-container">
                            <button class="btn btn-warning" type="button" name="submit" value="0" id="draft_btn"
                                onclick="createWorkshop('0')"> Draft </button>
                            <button class="btn btn-success" type="button" name="submit" value="1" id="submit_btn"
                                style="margin-left:20px;" onclick="createWorkshop('1')">
                                Publish
                            </button>
                            {{-- <button class="btn btn-success" type="button">Update</button> --}}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script>
        $(document).ready(function() {
            var activity_content_section = {!! json_encode($workshops->GetEventWorkshops) !!};
            var event_workshop_optionals = {!! json_encode($workshops->getEventWorkshopOptional) !!};

            if (activity_content_section != null)
                get_event_activity(activity_content_section);
            if (event_workshop_optionals != null)
                get_event_optinals(event_workshop_optionals);
        });

        const get_event_optinals = (optionals) => {
            $('#append_optional_price').html('');
            var optional_field_count = 1;
            var FieldOptionalData = ``;
            optionals.forEach(element => {
                FieldOptionalData = `<div id="append_optional_data_${optional_field_count}">
                            <input type="hidden" id="event_workshop_optional_id_${optional_field_count}" name="event_workshop_optional_id_${optional_field_count}" value="${element['id']}">
                         <div class="row">
                         <div class="col-5">
                            <div class="form-group m-0">
                                 <label for="activity_optional_name_${optional_field_count}" class="col-form-label s-12">Activity Optional Name:<span class="text-danger">*</span></label>
                                  <input id="activity_optional_name_${optional_field_count}" placeholder="Enter optional name" class="form-control r-0 light s-12" name="activity_optional_name_${optional_field_count}" type="text" value="${element['activity_optional_name']}">
                                </div>
                              </div>
                                <div class="col-2">
                                    <div class="form-group m-0">
                                        <label for="activity_optional_price_member_${optional_field_count}" class="col-form-label s-12">Member Fee:<span class="text-danger">*</span></label>
                                            <input id="activity_optional_price_member_${optional_field_count}" placeholder="Enter member fee"
                                                                class="form-control r-0 light s-12" name="activity_optional_price_member_${optional_field_count}"
                                                                type="number" value="${element['price_member']}">
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                    <div class="form-group m-0">
                                        <label for="activity_optional_price_non_member_${optional_field_count}" class="col-form-label s-12">Non-Member Fee:<span class="text-danger">*</span></label>
                                            <input id="activity_optional_price_non_member_${optional_field_count}" placeholder="Enter non member fee"
                                                                class="form-control r-0 light s-12" name="activity_optional_price_non_member_${optional_field_count}"
                                                                type="number" value="${element['price_guest']}">
                                                        </div>
                                                    </div>
                                                    <div class="col-3" style="margin-top:40px;">
                                                        <div class="text-center">
                                                            <i class="del_icon material-icons" style="font-size:20px;" onclick="removeOptional(${element['id']})">&#xe872;</i>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                <div class="form-group m-0">
                                     <label for="activity_optional_name_${optional_field_count}" class="col-form-label s-12">Survey Certification:<span class="text-danger">*</span></label>

                                      <span class="pr-field ml-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="optional_survey_${optional_field_count}"
                                            id="optional_survey_${optional_field_count}" value="yes" ${element['survey']=='yes'?'checked':''}>
                                            <label class="form-check-label" for="optional_survey_${optional_field_count}">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="optional_survey_${optional_field_count}"
                                            id="optional_survey_${optional_field_count}" value="no" ${element['survey']=='no'?'checked':''}>
                                            <label class="form-check-label" for="optional_survey_${optional_field_count}">No</label>
                                        </div>
                                    </span>
                                    </div>
                                  </div>
                                                </div>
                                            `;

                $(`#append_optional_price`).append(FieldOptionalData);
                $(`#activity_optional_count`).val(optional_field_count);
                optional_field_count++;

            });
        }

        const get_event_activity = (activity_data) => {
            $('#activity_container').html('');
            var fieldHTML = '';
            activity_data.forEach(element => {
                activity_counter++;

                fieldHTML +=
                    `<input type="hidden" name="activity_id_${activity_counter}" value="${element['id']}" />
                    <div class="card mb-2 main-container" id="activity_container_${activity_counter}">
                        <input type="hidden" class="sort-val" name="sort_activity_${activity_counter}"
                                                id="sort_activity_${activity_counter}" value="${element['sorting_order']}"/>
                            <div class="d-flex align-items-center">
                                <div class="card-header w-100 mr-3 collapsed" data-toggle="collapse"
        data-target="#collapse_${activity_counter}" aria-expanded="false" aria-controls="heading_${activity_counter}">
                                    <h4 class="m-0"><i class="fas fa-arrows-alt mr-3"></i><span id="tab_name_${activity_counter}" name="tab_name_${activity_counter}">${element['workshop_name']}</span> </h4>
                                </div>
                                <div class="text-center">
                                    <i class="del_icon material-icons" onclick="removeActivity('${element['id']}')">&#xe872;</i>
                                </div>
                            </div>
                                <div id="collapse_${activity_counter}" class="collapse" aria-labelledby="heading_${activity_counter}"
                                    data-parent="#activity_container" >
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <label for="activity_title_${activity_counter}">Activity Name <span class="text-danger">*</span> : </label>
                                            </div>
                                            <div class="col-md-10">
                                                <input type="text" name="activity_title_${activity_counter}" id="activity_title_${activity_counter}" oninput="changeText(${activity_counter},this.value)" class="form-control" value="${element['workshop_name']}"/>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            </hr>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-3">
                                                <button onclick="addSubActivity(${activity_counter});" class="btn btn-primary" type="button" >Add Sub-activity</button> 
                                            </div> 
                                            <div class="col-md-3 text-center">
                                                <select name="select_date_${activity_counter}" id="select_date_${activity_counter}" class="form-control">`;
                program_dates
                    .forEach(date_data => {
                        if (date_data == element['workshop_date']) {
                            fieldHTML += `<option value="${date_data}" selected>${date_data}</option>`;
                        } else {
                            fieldHTML += `<option value="${date_data}">${date_data}</option>`;
                        }
                    });
                fieldHTML +=
                    `</select>
                                            </div>
                                        </div>
                                       
                                        <input type="hidden" name="sub_activity_length_${activity_counter}" id="sub_activity_length_${activity_counter}" value="0" />`;

                if (element['get_workshop_programs'].length > 0) {
                    let subactivity_count = 0;

                    element['get_workshop_programs'].forEach(programs => {
                        subactivity_count++;
                        fieldHTML +=
                            `
                        <input type="hidden" name="sub_activity_id_${activity_counter}_${subactivity_count}" value="${programs['id']}" />
                        <div class="sub-activity-container">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    Sub-activity Program Name <span class="text-danger">*</span>:-
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="sub_activity_name_${activity_counter}_${subactivity_count}" id="sub_activity_name_${activity_counter}_${subactivity_count}" value="${programs['program_name']}" class="form-control"/>
                                </div>
                               <!-- <div class="col-md-2">
                                    <button type="button" name="remove_sub_activity_${activity_counter}_${subactivity_count}" id="remove_sub_activity_${activity_counter}_${subactivity_count}"
                                        class="btn btn-danger" onclick="$(this).closest('.sub-activity-container').remove()">Delete</button>
                                </div> --!>
                            </div>
                            <div class="form-group row">
                            <div class="col-md-4">
                                Survey Certification <span class="text-danger">*</span>:- 
                            </div>
                                <div class="col-md-8">
                                    <span class="pr-field ml-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sub_activity_survey_${activity_counter}_${subactivity_count}"
                                            id="sub_activity_survey_${activity_counter}_${subactivity_count}" value="yes" ${programs['survey']=='yes'?'checked':''}>
                                            <label class="form-check-label" for="sub_activity_survey_${activity_counter}_${subactivity_count}">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sub_activity_survey_${activity_counter}_${subactivity_count}"
                                            id="sub_activity_survey_${activity_counter}_${subactivity_count}" value="no" ${programs['survey']=='no'?'checked':''}>
                                            <label class="form-check-label" for="sub_activity_survey_${activity_counter}_${subactivity_count}">No</label>
                                        </div>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    Sub-activity Date <span class="text-danger">*</span>:- 
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="sub_activity_program_date_${activity_counter}_${subactivity_count}" id="sub_activity_program_date_${activity_counter}_${subactivity_count}" class="form-control" value="${programs['program_date']}"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    Sub-activity Venue Details
                                </div>
                                <div class="col-md-1">
                                    <label>Room Number</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="sub_activity_room_${activity_counter}_${subactivity_count}" id="sub_activity_room_${activity_counter}_${subactivity_count}" value="${programs['room_no']!=null?programs['room_no']:""}" class="form-control" placeholder="Enter room number"/>
                                </div>
                                <div class="col-md-1">
                                    <label>Workshop Number</label>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="sub_activity_workshop_${activity_counter}_${subactivity_count}" id="sub_activity_workshop_${activity_counter}_${subactivity_count}" value="${programs['workshop_number']!=null?programs['workshop_number']:""}" class="form-control" placeholder="Enter workshop number"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    Sub-activity Time <span class="text-danger">*</span>
                                </div>
                                <div class="col-md-3"><input type="time" class="form-control"
                                        id="sub_activity_start_time_${activity_counter}_${subactivity_count}" name="sub_activity_start_time_${activity_counter}_${subactivity_count}" value="${programs['start_time']}"> </div>
                                <div class="col-md-2 text-center"> to </div>
                                <div class="col-md-3"><input type="time" class="form-control"
                                        id="sub_activity_end_time_${activity_counter}_${subactivity_count}" name="sub_activity_end_time_${activity_counter}_${subactivity_count}" value="${programs['end_time']}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    Sub-activity Programme Details <span class="text-danger">*</span>
                                </div>
                                <div class="col-md-8">
                                    <textarea name="sub_activity_program_${activity_counter}_${subactivity_count}" id="sub_activity_program_${activity_counter}_${subactivity_count}">${programs['program_desc']}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    Sub-activity Trainer Details <span class="text-danger">*</span>
                                </div>
                                <div class="col-md-8">
                                    <textarea name="sub_activity_trainers_${activity_counter}_${subactivity_count}" id="sub_activity_trainers_${activity_counter}_${subactivity_count}">${programs['program_trainers']}</textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    Sub-activity Member Fee <span class="text-danger">*</span>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" name="sub_activity_member_fee_${activity_counter}_${subactivity_count}" id="sub_activity_member_fee_${activity_counter}_${subactivity_count}" value="${programs['price_member']}" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    Sub-activity Non-member Fee <span class="text-danger">*</span>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" name="sub_activity_non_member_fee_${activity_counter}_${subactivity_count}" value="${programs['price_guest']}" id="sub_activity_non_member_fee_${activity_counter}_${subactivity_count}" class="form-control"/>
                                </div>
                            </div>
                            <div class="form-group row">
                            <div class="col-md-4">
                                Sub-activity Status <span class="text-danger">*</span>
                            </div>
                            <div class="col-md-8">
                                <span class="pr-field ml-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sub_activity_status_${activity_counter}_${subactivity_count}"
                                                id="sub_activity_status_${activity_counter}_${subactivity_count}" value="1"`;
                        if (programs['status'] == '1') {
                            fieldHTML += `checked`;
                        } else {
                            fieldHTML += ``;
                        }
                        fieldHTML +=
                            `>
                                            <label class="form-check-label" for="sub_activity_status_${activity_counter}_${subactivity_count}">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sub_activity_status_${activity_counter}_${subactivity_count}"
                                                id="sub_activity_status_${activity_counter}_${subactivity_count}" value="0"`;
                        if (programs['status'] == '0') {
                            fieldHTML += `checked`;
                        } else {
                            fieldHTML += ``;
                        }
                        fieldHTML += `>
                                            <label class="form-check-label" for="sub_activity_status_${activity_counter}_${subactivity_count}">In Active</label>
                                        </div>
                                    </span>
                            </div>
                        </div>
                        </div>`;
                    });
                }
                fieldHTML += ` <div id="sub_activity_container_${activity_counter}" class="sub_activity_container">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
            });
            $('#activity_container').append(fieldHTML);
            if (activity_data.length > 0) {
                let count_activity = 0;
                activity_data.forEach(element => {
                    count_activity++;
                    if (element['get_workshop_programs'].length > 0) {
                        let count_subactivity = 0;
                        element['get_workshop_programs'].forEach(programs => {
                            count_subactivity++;

                            CKEDITOR.replace(
                                `sub_activity_trainers_${count_activity}_${count_subactivity}`, {
                                    filebrowserUploadUrl: "{{ route('ck.upload', ['_token' => csrf_token()]) }}",
                                    filebrowserUploadMethod: 'form'
                                });

                            CKEDITOR.replace(
                                `sub_activity_program_${count_activity}_${count_subactivity}`, {
                                    filebrowserUploadUrl: "{{ route('ck.upload', ['_token' => csrf_token()]) }}",
                                    filebrowserUploadMethod: 'form'
                                });
                            $(`#sub_activity_length_${count_activity}`).val(count_subactivity);
                        });
                    }

                });
            }
        }

        const removeActivity = (workshopId) => {
            Swal.fire({
                title: 'Are you sure to delete?',
                text: "You won't be able to revert this! This record will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.event.workshop.program.delete') }}",
                        type: "POST",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            workshopId: workshopId
                        },
                        datatype: 'json',
                        success: function(response) {
                            if (response[0] == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response[1],
                                });
                                window.setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response[1],
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: "Something went wrong! Please try again.",
                            });
                        }
                    });
                }
            })
        }


        const removeOptional = (id) => {
            Swal.fire({
                title: 'Are you sure to delete?',
                text: "You won't be able to revert this! This record will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.event.optional.delete') }}",
                        type: "POST",
                        data: {
                            '_token': "{{ csrf_token() }}",
                            id: id
                        },
                        datatype: 'json',
                        success: function(response) {
                            if (response[0] == "success") {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response[1],
                                });
                                window.setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response[1],
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: "Something went wrong! Please try again.",
                            });
                        }
                    });
                }
            })
        }
    </script>
    @include('dashboard/event-manager/event_workshop_js')
@endpush
