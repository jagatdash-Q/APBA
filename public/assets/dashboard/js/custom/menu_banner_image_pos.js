const showPosition = (elem_id, image_id, left_pos_input_id, top_pos_input_id, lang_code) => {
    setCookie('elem_id', elem_id);
    setCookie('image_id', image_id);
    setCookie('left_pos_input_id', left_pos_input_id);
    setCookie('top_pos_input_id', top_pos_input_id);
    setCookie('lang_code', lang_code);



    $(`#top_position_list_item_${lang_code}`).css("display", "block");
    $(`#left_position_list_item_${lang_code}`).css("display", "block");
    $(`#left_all_pos_list_item_${lang_code}`).css("display", "inline-block");
    $(`#center_all_pos_list_item_${lang_code}`).css("display", "inline-block");
    $(`#right_all_pos_list_item_${lang_code}`).css("display", "inline-block");


    console.log($(`#${elem_id}`).css('left'));
    console.log($(`#${elem_id}`).css('top'));


    if ($(`#${elem_id}`).length > 0) {
        let left_pos = $(`#${elem_id}`).css('left');
        let top_pos = $(`#${elem_id}`).css('top');


        $(`#left_position_test_${lang_code}`).val(left_pos);
        $(`#top_position_test_${lang_code}`).val(top_pos);
    }
}

const changeTextPosition = (value, position) => {
    console.log("position : " + position);
    console.log("value : " + value);
    console.log("elem_id  : " + getCookie('elem_id'));
    console.log("image_id : " + getCookie('image_id'));

    //    console.log(getCookie('elem_id'));
    //    console.log(getCookie('image_id'));
    const elem_id = getCookie('elem_id');
    const parent_div = getCookie('image_id');
    const left_pos_input_id = getCookie('left_pos_input_id');
    const top_pos_input_id = getCookie('top_pos_input_id');

    let parent_div_height = $(`#${parent_div}`).height();
    let parent_div_width = $(`#${parent_div}`).width();

    console.log(parent_div_height);
    console.log(parent_div_width);

    let parsed_value = parseInt(value.substring(0, value.length - 2));


    switch (position) {
        case 'top':
            if (parsed_value > parent_div_height)
                swal({
                    title: "Provided top margin value exceed parent element height. Please provide a lower value",
                    // text: "The Page is locked! Will you like to override ?",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "OK",
                    cancelButtonText: "Cancel",
                    closeOnConfirm: false,
                    closeOnCancel: true,
                });
            else {
                $(`#${elem_id}`).css('top', value);
                let top_margin_percentage = parseFloat((parsed_value / parent_div_height) * 100).toFixed(2);
                $(`#${top_pos_input_id}`).val(top_margin_percentage);
            }
            break;
        case 'left':

            if (parsed_value > parent_div_width)
                swal({
                        title: "Provided left margin value exceed parent element width. Please provide a lower value",
                        // text: "The Page is locked! Will you like to override ?",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "OK",
                        cancelButtonText: "Cancel",
                        closeOnConfirm: false,
                        closeOnCancel: true,
                    }

                );
            else {
                $(`#${elem_id}`).css('left', value);
                let left_margin_percentage = parseFloat((parsed_value / parent_div_width) * 100).toFixed(2);
                $(`#${left_pos_input_id}`).val(left_margin_percentage);
            }
            break;

        default:
            console.log('not implemented');
    }
}


const changeAllTextPosition = (position) => {
    console.log(position);
    const elem_id = getCookie('elem_id');
    console.log('elem_id ' + elem_id);
    const parent_div = getCookie('image_id');
    const left_pos_input_id = getCookie('left_pos_input_id');
    const top_pos_input_id = getCookie('top_pos_input_id');
    const lang_code = getCookie('lang_code');



    console.log('left pos input ' + left_pos_input_id + ' top input id ' + top_pos_input_id);


    let parent_div_height = $(`#${parent_div}`).height();
    let parent_div_width = $(`#${parent_div}`).width();

    console.log(parent_div_height);
    console.log(parent_div_width);

    let elem_width = $(`#${elem_id}`).width();
    let elem_height = $(`#${elem_id}`).outerHeight();

    console.log('parent_div_height: ' + parent_div_height + ' parent_div_width: ' + parent_div_width);

    console.log('Elem width: ' + elem_width + ' elem height: ' + elem_height);
    console.log(Math.floor((parent_div_width - elem_width) / (parent_div_width) * 100));


    // let parsed_value = parseInt(value.substring(0, value.length - 2));


    switch (position) {
        case 'left':
            $(`#${elem_id}`).css('left', '0px');
            $(`#left_position_test_${lang_code}`).val('0px');
            $(`#${left_pos_input_id}`).val('0%');
            break;

        case 'right':
            let right_margin = (Math.floor((parent_div_width - elem_width) / (parent_div_width) *
                100) * parent_div_width) / 100 + 'px';
            let right_margin_percentage = Math.floor((parent_div_width - elem_width) / (parent_div_width) *
                100) + '%';
            console.log('right margin percentage' + right_margin_percentage);
            console.log('right margin ' + right_margin);

            $(`#${elem_id}`).css('left', right_margin_percentage);
            $(`#top_position_test_${lang_code}`).val(right_margin);
            $(`#${left_pos_input_id}`).val(right_margin_percentage);
            break
        case 'center':
            let center_left_margin = (parent_div_width - elem_width) / 2 + 'px';
            let center_left_margin_percentage = ((parent_div_width - elem_width) / (2 * parent_div_width)) * 100 + '%';
            $(`#${elem_id}`).css('left', center_left_margin_percentage);

            let center_top_margin = (parent_div_height - elem_height) / 2 + 'px';
            let center_top_margin_percentage = ((parent_div_height - elem_height) / (2 * parent_div_height)) * 100 + '%';
            $(`#${elem_id}`).css('top', center_top_margin_percentage);

            $(`#left_position_test_${lang_code}`).val(center_left_margin);
            $(`#top_position_test_${lang_code}`).val(center_top_margin);

            $(`#${left_pos_input_id}`).val(center_left_margin_percentage);
            $(`#${top_pos_input_id}`).val(center_top_margin_percentage);

            console.log('left margin : ' + center_left_margin_percentage + ' top margin : ' + center_top_margin_percentage);

            break;
    }
}

const changeTab = () => {
    console.log('tab change');
    const lang_code = getCookie('lang_code');

    $(`#top_position_list_item_${lang_code}`).css("display", "none");
    $(`#left_position_list_item_${lang_code}`).css("display", "none");
    $(`#left_all_pos_list_item_${lang_code}`).css("display", "none");
    $(`#center_all_pos_list_item_${lang_code}`).css("display", "none");
    $(`#right_all_pos_list_item_${lang_code}`).css("display", "none");
}
