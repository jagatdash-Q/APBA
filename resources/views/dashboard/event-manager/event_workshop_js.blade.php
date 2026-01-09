<script>
    let activity_counter = 0;
    let program_dates = @php echo json_encode($program_dates) @endphp;
    let dates = ``;
    program_dates.forEach(element => {
        dates += `<option value="${element}">${element}</option>`;
    });
    $(document).ready(function() {
        $(".accordion-sort").sortable({
            revert: true,
            cancel: 'input,select',
        });

        $(".accordion-sort").on("sortstop", function(event, ui) {
            $(`.main-container`).each(function(indexInArray, valueOfElement) {
                let counter = indexInArray;
                counter++;
                $(valueOfElement).find('.sort-val').val(counter);
            });
        });
    });
    let page = $('#page').val();
    let addActivity = () => {
        Swal.fire({
            title: 'Enter Activity Name',
            input: 'text',
            inputLabel: 'Activity Name',
            showCancelButton: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'Activity name is required!'
                } else {
                    activity_counter++;
                    $('#activity_container').append(`
                    <input type="hidden" name="activity_id_${activity_counter}" value="0" />
                   
                    <div class="card mb-2 main-container" id="activity_container_${activity_counter}">
                        <input type="hidden" class="sort-val" name="sort_activity_${activity_counter}"
                                                id="sort_activity_${activity_counter}" value="${activity_counter}" />
                        <div class="d-flex align-items-center">
                            <div class="card-header w-100 mr-3 collapsed" data-toggle="collapse"
    data-target="#collapse_${activity_counter}" aria-expanded="false" aria-controls="heading_${activity_counter}">
                                <h4 class="m-0"><i class="fas fa-arrows-alt mr-3"></i><span id="tab_name_${activity_counter}" name="tab_name_${activity_counter}">${value}</span> </h4>
                            </div>
                            <div class="text-center">
                                <i class="del_icon material-icons" onclick="$(this).closest('.main-container').remove();">&#xe872;</i>
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
                                            <input type="text" name="activity_title_${activity_counter}" id="activity_title_${activity_counter}" oninput="changeText(${activity_counter},this.value)" class="form-control" value="${value}"/>
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
                                            <select name="select_date_${activity_counter}" id="select_date_${activity_counter}" class="form-control">
                                                ${dates}
                                            </select>
                                        </div>
                                   
                                        
                                        </div>

                                        <div class="form-group row" id="append_optional_price_${activity_counter}">

                                       <!-- <div class="col-md-4" style="display:flex !important;">
                            <span>Conference Registration Fee for Local Participant : </span>
                            <input type="number" name="conference_registration_fee_local_${activity_counter}" id="conference_registration_fee_local_${activity_counter}"
                                class="form-control"/>
                        </div>
                        <div class="col-md-4" style="display:flex !important;">
                            <span>Conference Registration Fee for International Participant : </span>
                            <input type="number" name="conference_registration_fee_international_${activity_counter}" id="conference_registration_fee_international_${activity_counter}"
                                class="form-control"/>
                        </div>
                        <div class="col-md-4" style="display:flex !important;">
                            <span>Networking Dinner Fee : </span>
                            <input type="number" name="networking_dinner_fee_${activity_counter}" id="networking_dinner_fee_${activity_counter}"
                                class="form-control" />
                        </div> --!>
                       
                                    </div>
                                    <div id="sub_activity_container_${activity_counter}" class="sub_activity_container">
                                        <input type="hidden" name="sub_activity_length_${activity_counter}" id="sub_activity_length_${activity_counter}" value="0"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);
                    $('#total_activity').val(activity_counter);
                    if (page == "0") {
                        $('#submit-container').removeClass('disp-none');
                    }
                }
            }
        })
    }


    let changeText = (indx, val) => {
        $('#tab_name_' + indx).html(val);
    }

    let addSubActivity = (count) => {
        let subactivity_count = parseInt($(`#sub_activity_length_${count}`).val());
        let selected_date = $(`#select_date_${count}`).val();
        subactivity_count++;
        $(`#sub_activity_container_${count}`).append(`
        <input type="hidden" name="sub_activity_id_${activity_counter}_${subactivity_count}" value="0" />
        <div class="sub-activity-container">
                        <div class="form-group row">
                            <div class="col-md-4">
                                Sub-activity Program Name <span class="text-danger">*</span>:-
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="sub_activity_name_${count}_${subactivity_count}" id="sub_activity_name_${count}_${subactivity_count}" class="form-control" />
                            </div>
                            <div class="col-md-2">
                                <button type="button" name="remove_sub_activity_${count}_${subactivity_count}" id="remove_sub_activity_${count}_${subactivity_count}"
                                    class="btn btn-danger" onclick="$(this).closest('.sub-activity-container').remove()">Delete</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                Survey Certification <span class="text-danger">*</span>:- 
                            </div>
                            <div class="col-md-8">
                                <span class="pr-field ml-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sub_activity_survey_${count}_${subactivity_count}"
                                        id="sub_activity_survey_${count}_${subactivity_count}" value="yes" >
                                        <label class="form-check-label" for="sub_activity_survey_${count}_${subactivity_count}">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="sub_activity_survey_${count}_${subactivity_count}"
                                        id="sub_activity_survey_${count}_${subactivity_count}" value="no" checked>
                                        <label class="form-check-label" for="sub_activity_survey_${count}_${subactivity_count}">No</label>
                                    </div>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                Sub-activity Date <span class="text-danger">*</span>:- 
                            </div>
                            <div class="col-md-8">
                                <input type="text" readonly name="sub_activity_program_date_${count}_${subactivity_count}" id="sub_activity_program_date_${count}_${subactivity_count}" class="form-control" value="${selected_date}" />
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
                                <input type="text" name="sub_activity_room_${count}_${subactivity_count}" id="sub_activity_room_${count}_${subactivity_count}" class="form-control" placeholder="Enter room number"/>
                            </div>
                            <div class="col-md-1">
                                <label>Workshop Number</label>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="sub_activity_workshop_${count}_${subactivity_count}" id="sub_activity_workshop_${count}_${subactivity_count}" class="form-control" placeholder="Enter workshop number"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                Sub-activity Time <span class="text-danger">*</span>
                            </div>
                            <div class="col-md-3"><input type="time" class="form-control"
                                    id="sub_activity_start_time_${count}_${subactivity_count}" name="sub_activity_start_time_${count}_${subactivity_count}"> </div>
                            <div class="col-md-2 text-center"> to </div>
                            <div class="col-md-3"><input type="time" class="form-control"
                                    id="sub_activity_end_time_${count}_${subactivity_count}" name="sub_activity_end_time_${count}_${subactivity_count}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                Sub-activity Programme Details <span class="text-danger">*</span>
                            </div>
                            <div class="col-md-8">
                                <textarea name="sub_activity_program_${count}_${subactivity_count}" id="sub_activity_program_${count}_${subactivity_count}"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                Sub-activity Trainer Details <span class="text-danger">*</span>
                            </div>
                            <div class="col-md-8">
                                <textarea name="sub_activity_trainers_${count}_${subactivity_count}" id="sub_activity_trainers_${count}_${subactivity_count}"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                Sub-activity Member Fee <span class="text-danger">*</span>
                            </div>
                            <div class="col-md-8">
                                <input type="number" name="sub_activity_member_fee_${count}_${subactivity_count}" id="sub_activity_member_fee_${count}_${subactivity_count}" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                Sub-activity Non-member Fee <span class="text-danger">*</span>
                            </div>
                            <div class="col-md-8">
                                <input type="number" name="sub_activity_non_member_fee_${count}_${subactivity_count}" id="sub_activity_non_member_fee_${count}_${subactivity_count}" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                Sub-activity Status <span class="text-danger">*</span>
                            </div>
                            <div class="col-md-8">
                                <span class="pr-field ml-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sub_activity_status_${count}_${subactivity_count}"
                                                id="sub_activity_status_${count}_${subactivity_count}" value="1" checked>
                                            <label class="form-check-label" for="sub_activity_status_${count}_${subactivity_count}">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="sub_activity_status_${count}_${subactivity_count}"
                                                id="sub_activity_status_${count}_${subactivity_count}" value="0">
                                            <label class="form-check-label" for="sub_activity_status_${count}_${subactivity_count}">In Active</label>
                                        </div>
                                    </span>
                            </div>
                        </div>
                        
                    </div>`);
        CKEDITOR.replace(`sub_activity_trainers_${count}_${subactivity_count}`, {
            filebrowserUploadUrl: "{{ route('ck.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });

        CKEDITOR.replace(`sub_activity_program_${count}_${subactivity_count}`, {
            filebrowserUploadUrl: "{{ route('ck.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        $(`#sub_activity_length_${count}`).val(subactivity_count);
        document.getElementById(`sub_activity_name_${count}_${subactivity_count}`).focus();
    }


    let createWorkshop = (status) => {
        $('#activities_status').val(status);

        var activity_title = [];
        var conference_registration_fee = [];
        var networking_dinner_fee = [];
        var member_fee = [];
        var non_member_fee = [];
        var sub_activity_name = [];
        var sub_activity_room = [];
        var sub_activity_workshop = [];
        var sub_activity_start_time = [];
        var sub_activity_end_time = [];
        var sub_activity_program = [];
        var sub_activity_trainers = [];
        var sub_activity_member_fee = [];
        var sub_activity_non_member_fee = [];
        var activity_optional_name = [];
        var activity_optional_price_member = [];
        var activity_optional_price_non_member = [];
        var count_sub_activity = 0;



        let activity_optional_count = $(`#activity_optional_count`).val();
        if (activity_optional_count != 0) {

            for (let optional_count = 1; optional_count <= parseInt(
                    activity_optional_count); optional_count++) {
                if (document.getElementById('activity_optional_name_' +
                        optional_count)) {

                    activity_optional_name[optional_count] = $('#activity_optional_name_' + optional_count)
                        .val();

                    if (activity_optional_name[optional_count] == '') {
                        document.getElementById('activity_optional_name_' + optional_count)
                            .style
                            .borderColor =
                            "red";
                        document.getElementById('activity_optional_name_' + optional_count)
                            .focus();
                        return false;
                    } else {
                        document.getElementById('activity_optional_name_' + optional_count)
                            .style
                            .borderColor =
                            "#cbd5e0";
                    }
                }

                if (document.getElementById('activity_optional_price_member_' +
                        optional_count)) {

                    activity_optional_price_member[optional_count] = $('#activity_optional_price_member_' +
                            optional_count)
                        .val();

                    if (activity_optional_price_member[optional_count] == '') {
                        document.getElementById('activity_optional_price_member_' + optional_count)
                            .style
                            .borderColor =
                            "red";
                        document.getElementById('activity_optional_price_member_' + optional_count)
                            .focus();
                        return false;
                    } else {
                        document.getElementById('activity_optional_price_member_' + optional_count)
                            .style
                            .borderColor =
                            "#cbd5e0";
                    }
                }

                if (document.getElementById('activity_optional_price_non_member_' +
                        optional_count)) {

                    activity_optional_price_non_member[optional_count] = $('#activity_optional_price_non_member_' +
                            optional_count)
                        .val();

                    if (activity_optional_price_non_member[optional_count] == '') {
                        document.getElementById('activity_optional_price_non_member_' + optional_count)
                            .style
                            .borderColor =
                            "red";
                        document.getElementById('activity_optional_price_non_member_' + optional_count)
                            .focus();
                        return false;
                    } else {
                        document.getElementById('activity_optional_price_non_member_' + optional_count)
                            .style
                            .borderColor =
                            "#cbd5e0";
                    }
                }
            }
        }

        for (let index = 0; index <= activity_counter; index++) {

            if (document.getElementById('activity_title_' + index)) {
                activity_title[index] = $('#activity_title_' + index).val();
                if (activity_title[index] == '') {
                    document.getElementById('activity_title_' + index).style.borderColor = "red";
                    document.getElementById('activity_title_' + index).focus();
                    return false;
                } else {
                    document.getElementById('activity_title_' + index).style.borderColor = "#cbd5e0";
                }
            }

            // if (document.getElementById('conference_registration_fee_' + index)) {
            //     conference_registration_fee[index] = $('#conference_registration_fee_' + index).val();
            //     if (conference_registration_fee[index] == '') {
            //         document.getElementById('conference_registration_fee_' + index).style.borderColor = "red";
            //         document.getElementById('conference_registration_fee_' + index).focus();
            //         return false;
            //     } else {
            //         document.getElementById('conference_registration_fee_' + index).style.borderColor = "#cbd5e0";
            //     }
            // }

            // if (document.getElementById('networking_dinner_fee_' + index)) {
            //     networking_dinner_fee[index] = $('#networking_dinner_fee_' + index).val();
            //     if (networking_dinner_fee[index] == '') {
            //         document.getElementById('networking_dinner_fee_' + index).style.borderColor = "red";
            //         document.getElementById('networking_dinner_fee_' + index).focus();
            //         return false;
            //     } else {
            //         document.getElementById('networking_dinner_fee_' + index).style.borderColor = "#cbd5e0";
            //     }
            // }

            let sub_actitivty_count = $(`#sub_activity_length_${index}`).val();

            for (let sub_index = 1; sub_index <= sub_actitivty_count; sub_index++) {

                if (document.getElementById('sub_activity_name_' + index + '_' +
                        sub_index)) {

                    sub_activity_name[count_sub_activity] = $('#sub_activity_name_' + index + '_' +
                            sub_index)
                        .val();
                    if (sub_activity_name[count_sub_activity] == '') {
                        document.getElementById('sub_activity_name_' + index + '_' + sub_index).style
                            .borderColor =
                            "red";
                        document.getElementById('sub_activity_name_' + index + '_' + sub_index).focus();
                        return false;
                    } else {
                        document.getElementById('sub_activity_name_' + index + '_' + sub_index).style
                            .borderColor =
                            "#cbd5e0";
                    }
                }

                // if (document.getElementById('sub_activity_room_' + index + '_' +
                //         sub_index)) {

                //     sub_activity_room[count_sub_activity] = $('#sub_activity_room_' + index + '_' +
                //             sub_index)
                //         .val();
                //     if (sub_activity_room[count_sub_activity] == '') {
                //         document.getElementById('sub_activity_room_' + index + '_' + sub_index).style
                //             .borderColor =
                //             "red";
                //         document.getElementById('sub_activity_room_' + index + '_' + sub_index).focus();
                //         return false;
                //     } else {
                //         document.getElementById('sub_activity_room_' + index + '_' + sub_index).style
                //             .borderColor =
                //             "#cbd5e0";
                //     }
                // }

                // if (document.getElementById('sub_activity_workshop_' + index + '_' +
                //         sub_index)) {

                //     sub_activity_workshop[count_sub_activity] = $('#sub_activity_workshop_' + index + '_' +
                //             sub_index)
                //         .val();
                //     if (sub_activity_workshop[count_sub_activity] == '') {
                //         document.getElementById('sub_activity_workshop_' + index + '_' + sub_index).style
                //             .borderColor =
                //             "red";
                //         document.getElementById('sub_activity_workshop_' + index + '_' + sub_index).focus();
                //         return false;
                //     } else {
                //         document.getElementById('sub_activity_workshop_' + index + '_' + sub_index).style
                //             .borderColor =
                //             "#cbd5e0";
                //     }
                // }

                if (document.getElementById('sub_activity_start_time_' + index + '_' +
                        sub_index)) {

                    sub_activity_start_time[count_sub_activity] = $('#sub_activity_start_time_' + index + '_' +
                            sub_index)
                        .val();
                    if (sub_activity_start_time[count_sub_activity] == '') {
                        document.getElementById('sub_activity_start_time_' + index + '_' + sub_index).style
                            .borderColor =
                            "red";
                        document.getElementById('sub_activity_start_time_' + index + '_' + sub_index).focus();
                        return false;
                    } else {
                        document.getElementById('sub_activity_start_time_' + index + '_' + sub_index).style
                            .borderColor =
                            "#cbd5e0";
                    }
                }

                if (document.getElementById('sub_activity_end_time_' + index + '_' +
                        sub_index)) {

                    sub_activity_end_time[count_sub_activity] = $('#sub_activity_end_time_' + index + '_' +
                            sub_index)
                        .val();
                    if (sub_activity_end_time[count_sub_activity] == '') {
                        document.getElementById('sub_activity_end_time_' + index + '_' + sub_index).style
                            .borderColor =
                            "red";
                        document.getElementById('sub_activity_end_time_' + index + '_' + sub_index).focus();
                        return false;
                    } else {
                        document.getElementById('sub_activity_end_time_' + index + '_' + sub_index).style
                            .borderColor =
                            "#cbd5e0";
                    }
                }

                if (document.getElementById('sub_activity_start_time_' + index + '_' + sub_index) && document
                    .getElementById('sub_activity_end_time_' + index + '_' + sub_index)) {


                    var startTimeParts = sub_activity_start_time[count_sub_activity].split(':');
                    var endTimeParts = sub_activity_end_time[
                        count_sub_activity].split(':');

                    var startHour = parseInt(startTimeParts[0], 10);
                    var startMinute = parseInt(startTimeParts[1], 10);

                    var endHour = parseInt(endTimeParts[0], 10);
                    var endMinute = parseInt(endTimeParts[1], 10);

                    if (startHour < endHour || (startHour === endHour && startMinute < endMinute)) {
                        console.log('Start time is before end time');
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Start time is not before end time of \"' + sub_activity_name[
                                    count_sub_activity] +
                                "\" sub activity program name.",
                        });
                        console.log('Start time is not before end time');
                        return false;
                    }
                }

                if (document.getElementById('sub_activity_program_' + index + '_' +
                        sub_index)) {

                    sub_activity_program[count_sub_activity] = CKEDITOR.instances['sub_activity_program_' +
                        index + '_' +
                        sub_index];
                    var content_program = sub_activity_program[count_sub_activity].getData();
                    content_program = content_program.trim();
                    var editorElement_program;
                    if (content_program === '') {
                        editorElement_program = sub_activity_program[count_sub_activity].container.$;
                        editorElement_program.classList.add('empty-editor');
                        sub_activity_program[count_sub_activity].focus();
                        return false;
                    } else {
                        editorElement_program = sub_activity_program[count_sub_activity].container.$;
                        editorElement_program.classList.remove('empty-editor');
                    }
                }

                if (document.getElementById('sub_activity_trainers_' + index + '_' +
                        sub_index)) {

                    sub_activity_trainers[count_sub_activity] = CKEDITOR.instances['sub_activity_trainers_' +
                        index + '_' +
                        sub_index];
                    var content_trainers = sub_activity_trainers[count_sub_activity].getData();
                    content_trainers = content_trainers.trim();
                    var editorElement_trainers;
                    if (content_trainers === '') {
                        editorElement_trainers = sub_activity_trainers[count_sub_activity].container.$;
                        editorElement_trainers.classList.add('empty-editor');
                        sub_activity_trainers[count_sub_activity].focus();
                        return false;
                    } else {
                        editorElement_trainers = sub_activity_trainers[count_sub_activity].container.$;
                        editorElement_trainers.classList.remove('empty-editor');
                    }
                }

                if (document.getElementById('sub_activity_member_fee_' + index + '_' +
                        sub_index)) {

                    sub_activity_member_fee[count_sub_activity] = $('#sub_activity_member_fee_' + index + '_' +
                            sub_index)
                        .val();
                    if (sub_activity_member_fee[count_sub_activity] == '') {
                        document.getElementById('sub_activity_member_fee_' + index + '_' + sub_index).style
                            .borderColor =
                            "red";
                        document.getElementById('sub_activity_member_fee_' + index + '_' + sub_index).focus();
                        return false;
                    } else {
                        document.getElementById('sub_activity_member_fee_' + index + '_' + sub_index).style
                            .borderColor =
                            "#cbd5e0";
                    }
                }

                if (document.getElementById('sub_activity_non_member_fee_' + index + '_' +
                        sub_index)) {

                    sub_activity_non_member_fee[count_sub_activity] = $('#sub_activity_non_member_fee_' +
                            index + '_' +
                            sub_index)
                        .val();
                    if (sub_activity_non_member_fee[count_sub_activity] == '') {
                        document.getElementById('sub_activity_non_member_fee_' + index + '_' + sub_index).style
                            .borderColor =
                            "red";
                        document.getElementById('sub_activity_non_member_fee_' + index + '_' + sub_index)
                            .focus();
                        return false;
                    } else {
                        document.getElementById('sub_activity_non_member_fee_' + index + '_' + sub_index).style
                            .borderColor =
                            "#cbd5e0";
                    }
                }
                count_sub_activity++;
            }

        }

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        // if (page == "0") {
        //     var url = "{{ route('admin.event.workshop.store') }}";
        // } else {
        //     var url = "{{ route('admin.event.workshop.update') }}";
        // }

        var url = "{{ route('admin.event.workshop.update') }}";


        $.ajax({
            url: url,
            type: "POST",
            header: {
                '_token': "{{ csrf_token() }}"
            },
            data: $("#workshop_form").serialize(),
            datatype: 'json',
            success: function(response) {
                console.log(response);
                if (response[0] == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response[1],
                    });
                    window.setTimeout(function() {
                        window.location.href =
                            "{{ route('admin.manage.event.workshops') }}";
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
    const addActivityOptional = () => {
        var optional_field_count = parseInt($(`#activity_optional_count`).val());
        optional_field_count++;
        var fieldHTML = `<div id="append_optional_data_${optional_field_count}">
                            <input type="hidden" id="event_workshop_optional_id_${optional_field_count}" name="event_workshop_optional_id_${optional_field_count}" value="0">
                         <div class="row">
                         <div class="col-5">
                            <div class="form-group m-0">
                                 <label for="activity_optional_name_${optional_field_count}" class="col-form-label s-12">Optional Activity Name:<span class="text-danger">*</span></label>
                                  <input id="activity_optional_name_${optional_field_count}" placeholder="Enter optional name" class="form-control r-0 light s-12" name="activity_optional_name_${optional_field_count}" type="text" value="">
                                </div>
                              </div>
                                <div class="col-2">
                                    <div class="form-group m-0">
                                        <label for="activity_optional_price_member_${optional_field_count}" class="col-form-label s-12">Member Fee:<span class="text-danger">*</span></label>
                                            <input id="activity_optional_price_member_${optional_field_count}" placeholder="Enter member fee"
                                                                class="form-control r-0 light s-12" name="activity_optional_price_member_${optional_field_count}"
                                                                type="number" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                    <div class="form-group m-0">
                                        <label for="activity_optional_price_non_member_${optional_field_count}" class="col-form-label s-12">Non-Member
                                                                Fee:<span class="text-danger">*</span></label>
                                            <input id="activity_optional_price_non_member_${optional_field_count}" placeholder="Enter non member fee"
                                                                class="form-control r-0 light s-12" name="activity_optional_price_non_member_${optional_field_count}"
                                                                type="number" value="">
                                                        </div>
                                                    </div>
                                                    <div class="col-3" style="margin-top:40px;">
                                                        <div class="text-center">
                                                            <i class="del_icon material-icons" style="font-size:20px;" onclick="removeActivityOptional(${optional_field_count})">&#xe872;</i>
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                <div class="form-group m-0">
                                     <label for="optional_survey_${optional_field_count}" class="col-form-label s-12">Survey Certification:<span class="text-danger">*</span></label>

                                      <span class="pr-field ml-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="optional_survey_${optional_field_count}"
                                            id="optional_survey_${optional_field_count}" value="yes" >
                                            <label class="form-check-label" for="optional_survey_${optional_field_count}">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="optional_survey_${optional_field_count}"
                                            id="optional_survey_${optional_field_count}" value="no" checked>
                                            <label class="form-check-label" for="optional_survey_${optional_field_count}">No</label>
                                        </div>
                                    </span>
                                    </div>
                                  </div>
                                                </div>
                                            `;
        $(`#append_optional_price`).append(fieldHTML);
        $(`#activity_optional_count`).val(optional_field_count);
        optional_field_count++;
    }

    const removeActivityOptional = (count) => {

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
                $(`#append_optional_data_${count}`).remove();
            }
        });
    }
</script>
