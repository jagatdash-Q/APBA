@extends('dashboard.layouts.master')
@section('title', __('Create Event Workshops'))
@section('content')
    @include('dashboard.common.index')
    <div class="padding">
        <div class="box m-b-0">
            <div class="box-header dker">
                <h3>Event Name :- {{ $is_event_exist->event_name }}</h3>
                <small>

                </small>
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
                <div class="pt-2">
                    <div class="card p-3">
                        <form action="{{ route('admin.save.event.workshop') }}" method="post"
                            onsubmit="return validateWorkshop()">
                            @csrf
                            <input type="hidden" name="event_uid" value="{{ $is_event_exist->uid }}" id="event_uid" />
                            <input type="hidden" name="event_id" value="{{ $is_event_exist->id }}" id="event_id" />
                            <input type="hidden" name="total_workshop" id="total_workshop" value="0" />
                            <div class="row">
                                <div class="col-md-12"><label>Choose Event Date :- </label></div>
                                <div class="col-md-9">
                                    <select name="datepicker" class="form-control" id="datepicker">
                                        @foreach ($program_dates as $date)
                                            <option value="{{ $date }}"> {{ $date }} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" id="add_workshop" class="btn btn-primary"
                                        onclick="addWorkshopGroup()"> Add
                                        Workshop
                                        details </button>
                                </div>
                            </div>
                            <div id="workshop_container">
                                
                            </div>
                            <div id="form-footer-button" class="disp-none row">
                                <div class="col-md-12">
                                    <button type="submit" id="submit" name="submit" value="1"
                                        class="btn btn-success"> Save </button>
                                    <button type="submit" id="submit" style="margin-right: 10px" name="submit"
                                        value="0" class="btn btn-warning"> Draft </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="Workshopprogrammodel" tabindex="-1" role="dialog" aria-labelledby="WorkshopModelLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="WorkshopprogrammodelLabel">Program Model</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div>
                            <input type="hidden" class="form-control" id="workshop_section_id">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="workshop_program_head"
                                placeholder="Workshop Program Name:">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6"><input type="number" class="form-control" id="workshop_number"
                                        placeholder="Workshop Number:"></div>
                                <div class="col-md-6"><input type="number" class="form-control" id="workshop_room_number"
                                        placeholder="Workshop Room Number:"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="workshop_program_desc" class="col-form-label">Program Desc:</label>
                            <input type="text" class="form-control" id="workshop_program_desc">
                        </div>
                        <div class="form-group">
                            <label for="workshop_program_desc" class="col-form-label">Program trainers:</label>
                            <textarea class="form-control" id="workshop_trainers" placeholder="Workshop trainers:"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3"><label for="workshop_program_price_mem" class="col-form-label">
                                        Program Price For Member:</label></div>
                                <div class="col-md-9"><input type="number" class="form-control"
                                        id="workshop_program_price_mem" placeholder="Workshop Program Price:"
                                        value="0"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3"><label for="workshop_program_price_guest" class="col-form-label">
                                        Program Price For Guest:</label></div>
                                <div class="col-md-9"><input type="number" class="form-control"
                                        id="workshop_program_price_guest" placeholder="Workshop Program Price:"
                                        value="0"></div>
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="row">
                                <div class="col-md-3">
                                    <label for="" class="col-form-label">Program Time:</label>
                                </div>
                                <div class="col-md-4"><input type="time" class="form-control"
                                        id="workshop_program_time_from"> </div>
                                <div class="col-md-1"> - </div>
                                <div class="col-md-4"><input type="time" class="form-control"
                                        id="workshop_program_time_to"></div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" type="button" class="btn btn-primary"
                        onclick="saveWorkshopProgramDetails();">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('after-scripts')
    <script src="{{ asset('assets/dashboard/js/custom/common.js') }}"></script>
    <script src="{{ asset('assets/dashboard/moment/moment.js') }}"></script>
    <script>
        let i = 1;
        let j = 1;
        $(document).ready(function() {
            CKEDITOR.replace('workshop_trainers', {
                filebrowserUploadUrl: "{{ route('ck.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });

            CKEDITOR.replace('workshop_program_desc', {
                filebrowserUploadUrl: "{{ route('ck.upload', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form'
            });
        });
        let addWorkshopGroup = () => {
            if ($('#datepicker').val() != '') {
                let date_val = $('#datepicker').val();
                if (!$('#workshop_container').find(`#fieldset_${date_val}`).length) {
                    $('#workshop_container').append(
                        `<div class="workshop_section_container" id="workshop_section_container_${j}" secdate="${$('#datepicker').val()}">
                    <fieldset id="fieldset_${$('#datepicker').val()}">
                    <legend >Workshop :${$('#datepicker').val()}</legend>
                    <div class="col-md-12">
                        <label> Workshop name</label>
                        <input type = "hidden" name="Workshop_date_${j}" id="Workshop_date_${j}" value="${date_val}">
                        <input type = "hidden" name="Workshop_program_len_${j}" id="Workshop_program_len_${j}" value="0">
                        <input type="text" class="form-control Workshop_group_name" id="Workshop_group_name_${j}" placeholder="Workshop name" name="Workshop_group_name_${j}"/>
                    </div>
                    <div class="col-md-12">
                        <label> Workshop Description</label>
                        <input type="text" class="form-control" id="Workshop_group_desc_${j}" placeholder="Workshop description" name="Workshop_group_desc_${j}"/>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="min-height:50px;">
                        <button type="button" class="btn btn-danger float-right" style="margin-top: 10px;" onclick="$(this).closest('.workshop_section_container').remove()"> Remove workshop </button>
                        <button type="button" class="btn btn-success float-right" onclick="addWorkshop(${j})" data-toggle="modal" data-target="#Workshopprogrammodel" style="margin-top: 10px;margin-right:10px;"> Add workshop </button>
                        </div>
                        
                    </div>
                    
                    <div class="col-md-12">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Program Name</th>
                                    <th scope="col">Work shop number</th>
                                    <th scope="col">Room Number</th>
                                    <th scope="col">Workshop Description</th>
                                    <th scope="col">Workshop trainers</th>
                                    <th scope="col">Workshop Price for member</th>
                                    <th scope="col">Workshop Price for guest</th>
                                    <th scope="col">Workshop Time</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="workshopContainer_${j}" class="workshopcontainer">
                                
                            </tbody>
                        </table>
                    </div>
                    </fieldset>
                    
                </div>`
                    );
                    $('#total_workshop').val(j);
                    j++;
                }


            }
            $('#form-footer-button').removeClass('disp-none');
        }
        let addWorkshop = (section_id) => {
            $('#workshop_section_id').val(section_id);
        }

        let saveWorkshopProgramDetails = () => {
            let check = 0;
            let is_exist = 0;
            let sub_container = 1;
            let heading = '';
            let msg = '';
            let is_error = 0;
            let is_room_exist = 0;
            let is_time_slot_not_available = 0;
            let workshop_section_id = $('#workshop_section_id').val();
            let workshop_number = $('#workshop_number').val();
            let workshop_program_head = $('#workshop_program_head').val();
            let workshop_room_number = $('#workshop_room_number').val();
            let workshop_program_desc = CKEDITOR.instances['workshop_program_desc'].getData();
            let workshop_trainers = CKEDITOR.instances['workshop_trainers'].getData();
            let workshop_program_price_mem = $('#workshop_program_price_mem').val();
            let workshop_program_price_guest = $('#workshop_program_price_guest').val();
            let workshop_program_time_from = $('#workshop_program_time_from').val();
            let workshop_program_time_to = $('#workshop_program_time_to').val();
            let program_len = parseInt($(`#Workshop_program_len_${workshop_section_id}`).val());
            $(`#workshopContainer_${workshop_section_id}`).children('.workshop_program_details_section').each(function(
                indexInArray, valueOfElement) {
                // console.log($(valueOfElement).find('.workshop_heading').html());
                if ($(valueOfElement).find('.workshop_heading').html().trim() == $('#workshop_program_head')
                    .val().trim()) {
                    check++;
                }
                is_exist++;
            });

            $(`#workshopContainer_${workshop_section_id}`).children('.workshop_program_details_section').each(function(
                indexInArray, valueOfElement) {

                if ($(valueOfElement).find('.workshop-room').val() == workshop_room_number) {
                    is_room_exist++;
                }
            });
            if (workshop_program_time_to == '') {
                is_error++;
                msg = 'Please choose program end time';
            }
            if (workshop_program_time_from == '') {
                is_error++;
                msg = 'Please choose program start time';
            }
            if (workshop_program_price_guest == '' || workshop_program_price_guest == 0) {
                is_error++;
                msg = 'Please enter guest member price';
            }
            if (workshop_program_price_mem == '' || workshop_program_price_mem == 0) {
                is_error++;
                msg = 'Please enter existing member price';
            }
            if (workshop_program_desc == '') {
                is_error++;
                msg = 'Please enter program Description';
            }
            if (workshop_trainers == '') {
                is_error++;
                msg = 'Please enter program trainers';
            }
            if (workshop_number == '' || workshop_number == 0) {
                is_error++;
                msg = 'Please enter workshop number';
            }
            if (workshop_room_number == '' || workshop_room_number == 0) {
                is_error++;
                msg = 'Please enter room number';
            }
            if (workshop_program_head == '') {
                is_error++;
                msg = 'Please enter program name';
            }
            if (is_error) {
                Swal.fire(
                    'Warning!',
                    msg,
                    'warning'
                );
                return false;
            }

            // Checking time validation for start and end time

            var start_time = moment(workshop_program_time_from, 'HH:mm');
            var end_time = moment(workshop_program_time_to, 'HH:mm');
            let is_valid_time = moment(start_time).isBefore(end_time);
            if (!is_valid_time) {
                if (workshop_program_time_from == workshop_program_time_to) {
                    Swal.fire(
                        'Warning!',
                        "Program start time and end time can't be same",
                        'warning'
                    );
                } else {
                    Swal.fire(
                        'Warning!',
                        'Invalid end time',
                        'warning'
                    );
                }

                return false;
            }



            if (is_room_exist) {
                $(`#workshopContainer_${workshop_section_id}`).children('.workshop_program_details_section').each(
                    function(indexInArray, valueOfElement) {
                        let prgrm_start_time = moment($(valueOfElement).find('.program_start').val(), 'HH:mm');
                        let prgrm_end_time = moment($(valueOfElement).find('.program_end').val(), 'HH:mm');

                        console.log("start_time :- " + start_time);
                        console.log("prgrm_start_time :- " + prgrm_start_time);
                        console.log("prgrm_end_time :- " + prgrm_end_time);
                        console.log("isBetween :- " + start_time.isBetween(prgrm_start_time, prgrm_end_time));
                        if (start_time == prgrm_start_time) {
                            is_time_slot_not_available++;
                            msg = 'A program is with same start time created for the room :-' +
                                workshop_room_number;
                        }
                        if (start_time.isBetween(prgrm_start_time, prgrm_end_time)) {
                            is_time_slot_not_available++;
                            msg = 'Time slot not available for room :-' + workshop_room_number;
                        }
                    });
            }

            if (is_time_slot_not_available) {
                Swal.fire(
                    'Warning!',
                    msg,
                    'warning'
                );
                return false;
            }


            let html = ``;
            html +=
                `<tr id="workshop_program_details_section_${workshop_section_id}_${program_len}" class="workshop_program_details_section">`;

            if (!is_exist) {
                program_len++;
                heading = $('#workshop_program_head').val();
                html += `<td><input type="hidden" name="workshop_heading_${workshop_section_id}_${program_len}" id="workshop_heading_${workshop_section_id}_${program_len}" value="${heading}"/> <span class="workshop_heading">${heading} 
                        
                    </td>`;
            } else {
                if (!check) {
                    program_len++;
                    heading = $('#workshop_program_head').val();
                    html +=
                        `<td><input type="hidden" name="workshop_heading_${workshop_section_id}_${program_len}" id="workshop_heading_${workshop_section_id}_${program_len}" value="${heading}"/> <span class="workshop_heading">${heading}</span></td>`;
                } else {
                    Swal.fire(
                        'Warning!',
                        'Program already exist for this date',
                        'warning'
                    );
                    return false;
                }
            }



            html += `<td> <input type="hidden" name="workshop_number_${workshop_section_id}_${program_len}" id="workshop_number_${workshop_section_id}_${program_len}" value="${workshop_number}"/>   ${workshop_number}</td>
                <td> <input type="hidden" class="workshop-room" name="workshop_room_number_${workshop_section_id}_${program_len}" id="workshop_room_number_${workshop_section_id}_${program_len}" value="${workshop_room_number}"/>${workshop_room_number}</td>
                    <td><input type="hidden" name="workshop_program_desc_${workshop_section_id}_${program_len}" id="workshop_program_desc_${workshop_section_id}_${program_len}" value="${CKEDITOR.instances['workshop_program_desc'].getData()}"/>${CKEDITOR.instances['workshop_program_desc'].getData()}</td>
                        <td><input type="hidden" name="workshop_trainers_${workshop_section_id}_${program_len}" id="workshop_trainers_${workshop_section_id}_${program_len}" value="${CKEDITOR.instances['workshop_trainers'].getData()}"/>${CKEDITOR.instances['workshop_trainers'].getData()}</td>
                        <td><input type="hidden" name="workshop_program_price_mem_${workshop_section_id}_${program_len}" id="workshop_program_price_mem_${workshop_section_id}_${program_len}" value="${workshop_program_price_mem}"/>${workshop_program_price_mem}</td>
                            <td><input type="hidden" name="workshop_program_price_guest_${workshop_section_id}_${program_len}" id="workshop_program_price_guest_${workshop_section_id}_${program_len}" value="${workshop_program_price_guest}"/>${workshop_program_price_guest}</td>
                                <td> <input type="hidden" name="workshop_program_time_from_${workshop_section_id}_${program_len}" class="program_start" id="workshop_program_time_from_${workshop_section_id}_${program_len}" value="${workshop_program_time_from}"/> <input type="hidden" class="program_end"name="workshop_program_time_to_${workshop_section_id}_${program_len}" id="workshop_program_time_to_${workshop_section_id}_${program_len}" value="${workshop_program_time_to}"/> Workshop Program Slot:- ${workshop_program_time_from} to ${workshop_program_time_to}</td>
                                <td> <button type="button" class="btn btn-danger" onclick="$(this).closest('.workshop_program_details_section').remove()"> Remove </button> </td>
                </tr>`;
            $(`#workshopContainer_${workshop_section_id}`).append(html);

            $(`#Workshop_program_len_${workshop_section_id}`).val(program_len);
            CKEDITOR.instances['workshop_program_desc'].setData('');
            CKEDITOR.instances['workshop_trainers'].setData('');
            $('#Workshopprogrammodel').modal('hide');
            $('#workshop_program_head').val('')
            $('#workshop_section_id').val('')
            $('#workshop_number').val('');
            $('#workshop_room_number').val('');
            $('#workshop_program_price_mem').val('');
            $('#workshop_program_price_guest').val('');
            $('#workshop_program_time_from').val('');
            $('#workshop_program_time_to').val('');
        }


        let validateWorkshop = () => {
            let is_workshop_name_given = 0;
            let is_programs_given = 0;
            let workshop_not_given = 0;
            if($('#workshop_container').children('.workshop_section_container').length<1){
                Swal.fire(
                    'Warning!',
                    'Please add at lease one Workshop',
                    'warning'
                );
                return false;
                
            }
            $('#workshop_container').children('.workshop_section_container').each(function(
                indexInArray, valueOfElement) {
                    console.log($(valueOfElement).find('.Workshop_group_name').val());
                if ($(valueOfElement).find('.Workshop_group_name').val()=='') {
                    is_workshop_name_given++;
                }
            });
            if(is_workshop_name_given){
                Swal.fire(
                    'Warning!',
                    'Please enter Workshop name',
                    'warning'
                );
                return false;
            }
            
            $(`#workshop_container`).children('.workshop_section_container').each(function(
                indexInArray, valueOfElement) {
                if (!$(valueOfElement).find('.workshop_program_details_section').length) {
                    is_programs_given++;
                }
            });

            if(is_programs_given){
                Swal.fire(
                    'Warning!',
                    'Please add at least one program',
                    'warning'
                );
                return false;
            }
            return true;
        }
    </script>
@endpush
