
// Draggable section on banner images code starts here

$(document).ready(function() {
    $(`#draggable_web_,#draggable2_web_,#draggable3_web_`)
        .draggable({
            containment: $(`#parent_div_web_image_`)
        });
    $(`#draggable_tablet_,#draggable2_tablet_,#draggable3_tablet_`)
        .draggable({
            containment: $(`#parent_div_tablet_image_`)
        });
    $(`#draggable_mobile_,#draggable2_mobile_,#draggable3_mobile_`)
        .draggable({
            containment: $(`#parent_div_mobile_image_`)
        });

    document.getElementById('draggable_web_').onmouseup = function() {
        _drag_init(this, `banner_title_left_pos_web_`, `banner_title_top_pos_web_`,
            `parent_div_web_image_`);
        return false;
    };
    document.getElementById('draggable2_web_').onmouseup = function() {
        _drag_init(this, `banner_desc_left_pos_web_`, `banner_desc_top_pos_web_`,
            `parent_div_web_image_`);
        return false;
    };
    document.getElementById('draggable3_web_').onmouseup = function() {
        _drag_init(this, `button_name_left_pos_web_`, `button_name_top_pos_web_`,
            `parent_div_web_image_`);
        return false;
    };

    // Tablet
    document.getElementById('draggable_tablet_').onmouseup = function() {
        _drag_init(this, `banner_title_left_pos_tablet_`,
            `banner_title_top_pos_tablet_`, `parent_div_tablet_image_`);
        return false;
    };
    document.getElementById('draggable2_tablet_').onmouseup = function() {
        _drag_init(this, `banner_desc_left_pos_tablet_`,
            `banner_desc_top_pos_tablet_`, `parent_div_tablet_image_`);
        return false;
    };
    document.getElementById('draggable3_tablet_').onmouseup = function() {
        _drag_init(this, `button_name_left_pos_tablet_`,
            `button_name_top_pos_tablet_`, `parent_div_tablet_image_`);
        return false;
    };

    // Mobile

    document.getElementById('draggable_mobile_').onmouseup = function() {
        _drag_init(this, `banner_title_left_pos_mobile_`,
            `banner_title_top_pos_mobile_`, `parent_div_mobile_image_`);
        return false;
    };
    document.getElementById('draggable2_mobile_').onmouseup = function() {
        _drag_init(this, `banner_desc_left_pos_mobile_`,
            `banner_desc_top_pos_mobile_`, `parent_div_mobile_image_`);
        return false;
    };
    document.getElementById('draggable3_mobile_').onmouseup = function() {
        _drag_init(this, `button_name_left_pos_mobile_`,
            `button_name_top_pos_mobile_`, `parent_div_mobile_image_`);
        return false;
    };
});

/* End of Change text on draggble window while typing */
function _drag_init(elem, input_left_id = null, input_top_id = null, parent_div = null) {
    // Store the object of the element which needs to be moved
    // console.log(elem.id + 'left id: ' + input_left_id + ' top id: ' + input_top_id + ' parent id: ' + parent_div);
    let elem_id = elem.id;
    let parent_div_height = $(`#${parent_div}`).height();
    let parent_div_width = $(`#${parent_div}`).width();
    let left_pos = $(`#${elem_id}`).css("left");
    let top_pos = $(`#${elem_id}`).css("top");
    let left_final_pos = parseInt(left_pos.substring(0, left_pos.length - 2));
    let top_final_pos = parseInt(top_pos.substring(0, top_pos.length - 2));
    let left_margin_percentage = parseFloat((left_final_pos / parent_div_width) * 100).toFixed(2);
    let top_margin_percentage = parseFloat((top_final_pos / parent_div_height) * 100).toFixed(2);
    // let button_final_id = elem_id.substr(0, elem_id.length - 3);
    let button_final_id = elem_id.substr(0, elem_id.length - 1);
    console.log(button_final_id);
    // left_margin_percentage = left_margin_percentage.substring(0, left_margin_percentage.length-1);
    // top_margin_percentage = top_margin_percentage.substring(0, top_margin_percentage.length-1);
    switch (button_final_id) {
        case 'draggable_web':
            // input_left_id = "banner_title_left_pos_web_" + elem.id.substr(elem.id.length - 2, 2);
            // input_top_id = "banner_title_top_pos_web_" + elem.id.substr(elem.id.length - 2, 2);
            input_left_id = "banner_title_left_pos_web_";
            input_top_id = "banner_title_top_pos_web_";
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);
            break;

        case 'draggable2_web':
            // input_left_id = "banner_desc_left_pos_web_" + elem.id.substr(elem.id.length - 2,
            //     2);
            // input_top_id = "banner_desc_top_pos_web_" + elem.id.substr(elem.id.length - 2,
            //     2);
            input_left_id = "banner_desc_left_pos_web_";
            input_top_id = "banner_desc_top_pos_web_";
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);

            break;
        case 'draggable3_web':
            // input_left_id = "button_name_left_pos_web_" + elem.id.substr(elem.id.length - 2, 2);
            // input_top_id = "button_name_top_pos_web_" + elem.id.substr(elem.id.length - 2, 2);
            input_left_id = "button_name_left_pos_web_";
            input_top_id = "button_name_top_pos_web_";
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);
            break;

        case 'draggable_tablet':
            // input_left_id = "banner_title_left_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
            // input_top_id = "banner_title_top_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
            input_left_id = "banner_title_left_pos_tablet_";
            input_top_id = "banner_title_top_pos_tablet_";
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);
            break;

        case 'draggable2_tablet':
            // input_left_id = "banner_desc_left_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
            // input_top_id = "banner_desc_top_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
            input_left_id = "banner_desc_left_pos_tablet_";
            input_top_id = "banner_desc_top_pos_tablet_";
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);

            break;
        case 'draggable3_tablet':
            // input_left_id = "button_name_left_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
            // input_top_id = "button_name_top_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
            input_left_id = "button_name_left_pos_tablet_";
            input_top_id = "button_name_top_pos_tablet_";
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);
            break;

        case 'draggable_mobile':
            // input_left_id = "banner_title_left_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
            // input_top_id = "banner_title_top_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
            input_left_id = "banner_title_left_pos_mobile_";
            input_top_id = "banner_title_top_pos_mobile_";
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);
            break;

        case 'draggable2_mobile':
            // input_left_id = "banner_desc_left_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
            // input_top_id = "banner_desc_top_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
            input_left_id = "banner_desc_left_pos_mobile_";
            input_top_id = "banner_desc_top_pos_mobile_";
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);

            break;
        case 'draggable3_mobile':
            // input_left_id = "button_name_left_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
            // input_top_id = "button_name_top_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
            input_left_id = "button_name_left_pos_mobile_";
            input_top_id = "button_name_top_pos_mobile_";
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);
            break;
        default:
            console.log("No suitable final button id found");
    }
}
/* End of Initialize draggable using total tabs */


 /* Change text on draggble window while typing */
 const text_change = (input_text_id, replace_text_web_id, replace_text_tablet_id, replace_text_mobile_id) => {
    let final_val = $(`#${input_text_id}`).val();
    $(`#${replace_text_web_id}`).html(final_val);
    $(`#${replace_text_tablet_id}`).html(final_val);
    $(`#${replace_text_mobile_id}`).html(final_val);

}

// Expanding the draggable div
function expandDiv() {
    $("#expand_icon").css("display", "none");
    $("#compress_icon").css("display", "");
    $('#image_preview_container').addClass('box_full');
    setTimeout(function() {
        $('#webviewtabmenu').addClass('active');
        $('#expand_icon a').removeClass('active');
    }, 500);
}

// Compressing the draggable div
function compressDiv() {
    $("#expand_icon").css("display", "");
    $("#compress_icon").css("display", "none");
    $('#image_preview_container').removeClass('box_full');
    setTimeout(function() {
        $('#webviewtabmenu').addClass('active');
        $('#compress_icon a').removeClass('active');
    }, 500);
}


// Draggable section on banner images code ends here