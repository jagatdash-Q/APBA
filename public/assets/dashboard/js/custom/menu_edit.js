$(document).ready(function() {
    $("#addmore").click(function() {
        var clone = $("#inputFields").html();
        $("#req_input").append('<div class="required_inp"><hr />' + clone +
            '<button type="button" style="float: right;"  class="btn-danger  inputRemove">Remove</button></div>'
        );
        $(".required_inp:last").find("input[type='text']").val("");
    });
    $('body').on('click', '.inputRemove', function() {
        $(this).parent('div.required_inp').remove()
    });

    let langs = <?php echo json_encode($Langs); ?>;
    langs.forEach((item, index) => {
        $(`#draggable_web_${item},#draggable2_web_${item},#draggable3_web_${item}`)
            .draggable({
                containment: $(`#parent_div_web_image_${item}`)
            });
        $(`#draggable_tablet_${item},#draggable2_tablet_${item},#draggable3_tablet_${item}`)
            .draggable({
                containment: $(`#parent_div_tablet_image_${item}`)
            });
        $(`#draggable_mobile_${item},#draggable2_mobile_${item},#draggable3_mobile_${item}`)
            .draggable({
                containment: $(`#parent_div_mobile_image_${item}`)
            });

        document.getElementById('draggable_web_' + item).onmouseup = function() {
            _drag_init(this, `banner_title_left_pos_web_` + item, `banner_title_top_pos_web_` +
                item, `parent_div_web_image_` + item);
            return false;
        };
        document.getElementById('draggable2_web_' + item).onmouseup = function() {
            _drag_init(this, `banner_desc_left_pos_web_` + item, `banner_desc_top_pos_web_` +
                item, `parent_div_web_image_` + item);
            return false;
        };
        document.getElementById('draggable3_web_' + item).onmouseup = function() {
            _drag_init(this, `button_name_left_pos_web_` + item, `button_name_top_pos_web_` +
                item, `parent_div_web_image_` + item);
            return false;
        };

        // Tablet
        document.getElementById('draggable_tablet_' + item).onmouseup = function() {
            _drag_init(this, `banner_title_left_pos_tablet_` + item,
                `banner_title_top_pos_tablet_` +
                item, `parent_div_tablet_image_` + item);
            return false;
        };
        document.getElementById('draggable2_tablet_' + item).onmouseup = function() {
            _drag_init(this, `banner_desc_left_pos_tablet_` + item,
                `banner_desc_top_pos_tablet_` +
                item, `parent_div_tablet_image_` + item);
            return false;
        };
        document.getElementById('draggable3_tablet_' + item).onmouseup = function() {
            _drag_init(this, `button_name_left_pos_tablet_` + item,
                `button_name_top_pos_tablet_` +
                item, `parent_div_tablet_image_` + item);
            return false;
        };

        // Mobile

        document.getElementById('draggable_mobile_' + item).onmouseup = function() {
            _drag_init(this, `banner_title_left_pos_mobile_` + item,
                `banner_title_top_pos_mobile_` +
                item, `parent_div_mobile_image_` + item);
            return false;
        };
        document.getElementById('draggable2_mobile_' + item).onmouseup = function() {
            _drag_init(this, `banner_desc_left_pos_mobile_` + item,
                `banner_desc_top_pos_mobile_` +
                item, `parent_div_mobile_image_` + item);
            return false;
        };
        document.getElementById('draggable3_mobile_' + item).onmouseup = function() {
            _drag_init(this, `button_name_left_pos_mobile_` + item,
                `button_name_top_pos_mobile_` +
                item, `parent_div_mobile_image_` + item);
            return false;
        };
    });
});

/* Change text on draggble window while typing */
const text_change = (input_text_id, replace_text_web_id, replace_text_tablet_id, replace_text_mobile_id) => {
    let final_val = $(`#${input_text_id}`).val();
    // let web_text = final_val.length > 75 ? final_val.substring(0, 75) + " ..." : final_val;
    // let tab_text = final_val.length > 75 ? final_val.substring(0, 75) + " ..." : final_val;
    // let mob_text = final_val.length > 35 ? final_val.substring(0, 35) + " ..." : final_val;
    $(`#${replace_text_web_id}`).html(final_val);
    $(`#${replace_text_tablet_id}`).html(final_val);
    $(`#${replace_text_mobile_id}`).html(final_val);

}

/* End of Change text on draggble window while typing */

function _drag_init(elem, input_left_id = null, input_top_id = null, parent_div = null) {
    // Store the object of the element which needs to be moved
    let elem_id = elem.id;
    let parent_div_height = $(`#${parent_div}`).height();
    let parent_div_width = $(`#${parent_div}`).width();
    let left_pos = $(`#${elem_id}`).css("left");
    let top_pos = $(`#${elem_id}`).css("top");
    let left_final_pos = parseInt(left_pos.substring(0, left_pos.length - 2));
    let top_final_pos = parseInt(top_pos.substring(0, top_pos.length - 2));
    let left_margin_percentage = parseFloat((left_final_pos / parent_div_width) * 100).toFixed(2);
    let top_margin_percentage = parseFloat((top_final_pos / parent_div_height) * 100).toFixed(2);
    let button_final_id = elem_id.substr(0, elem_id.length - 3);

    switch (button_final_id) {
        case 'draggable_web':
            input_left_id = "banner_title_left_pos_web_" + elem.id.substr(elem.id.length - 2, 2);
            input_top_id = "banner_title_top_pos_web_" + elem.id.substr(elem.id.length - 2, 2);
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);
            break;

        case 'draggable2_web':
            input_left_id = "banner_desc_left_pos_web_" + elem.id.substr(elem.id.length - 2,
                2);
            input_top_id = "banner_desc_top_pos_web_" + elem.id.substr(elem.id.length - 2,
                2);
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);

            break;
        case 'draggable3_web':
            input_left_id = "button_name_left_pos_web_" + elem.id.substr(elem.id.length - 2, 2);
            input_top_id = "button_name_top_pos_web_" + elem.id.substr(elem.id.length - 2, 2);
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);
            break;

        case 'draggable_tablet':
            input_left_id = "banner_title_left_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
            input_top_id = "banner_title_top_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);
            break;

        case 'draggable2_tablet':
            input_left_id = "banner_desc_left_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
            input_top_id = "banner_desc_top_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);

            break;
        case 'draggable3_tablet':
            input_left_id = "button_name_left_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
            input_top_id = "button_name_top_pos_tablet_" + elem.id.substr(elem.id.length - 2, 2);
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);
            break;

        case 'draggable_mobile':
            input_left_id = "banner_title_left_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
            input_top_id = "banner_title_top_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);
            break;

        case 'draggable2_mobile':
            input_left_id = "banner_desc_left_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
            input_top_id = "banner_desc_top_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);

            break;
        case 'draggable3_mobile':
            input_left_id = "button_name_left_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
            input_top_id = "button_name_top_pos_mobile_" + elem.id.substr(elem.id.length - 2, 2);
            $(`#${input_left_id}`).val(left_margin_percentage);
            $(`#${input_top_id}`).val(top_margin_percentage);
            break;
        default:
            console.log("No suitable final button id found");
    }
}
/* End of Initialize draggable using total tabs and total langs */