const base_url = $("#base_url").val();
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(";");
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == " ") c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

function eraseCookie(name) {
    document.cookie =
        name + "=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
}


const setModalClickBtnId = (element, web_div_id = null , tablet_div_id = null, mobile_div_id = null, type = null) => {
    // console.log('clicked');
    setCookie("button_id", element.id);
    // Store optional div id in cookie
    if (web_div_id != null) {
        setCookie("web_div_id", web_div_id.id);
    } else  {
        setCookie("web_div_id", '');
    }

    if (tablet_div_id != null) {
        setCookie("tablet_div_id", tablet_div_id.id);
    } else  {
        setCookie("tablet_div_id", '');
    }


    if (mobile_div_id != null) {
        setCookie("mobile_div_id", mobile_div_id.id);
    } else  {
        setCookie("mobile_div_id", '');
    }
    console.log(type);
    // if (type != null) {
    //     setCookie("type", type);
    // } else  {
    //     setCookie("type", '');
    // }

    // if ($('#iframe').length == 0) {
    //     $('#image_modal_body').append(`<iframe id="iframe" src="${base_url+ '/admin/media-manager?type=news_image'}" frameborder="0"
    //         style="width: 100%; height: 475px;"></iframe>`)
    // }
};


const generatePageSlug = (page_name, page_slug_id, page_type = null, draft_btn_id = null, submit_btn_id = null,original_page_name=null) => {
    process_page_name = page_name.replaceAll('&', '');
    $.ajax({
        url: base_url + '/admin/check-unique-page-slug?page_name=' + process_page_name + '&page_type=' + page_type + '&original_page_name='+original_page_name,
        contentType: false,
        processData: false,
        type: 'GET',
        success: function (data) {

            if (data.includes('success')) {
                let page_slug = JSON.parse(data).page_slug;
                $(`#` + page_slug_id).val(page_slug);
                $(`#${draft_btn_id}`).prop('disabled', false);
                $(`#${submit_btn_id}`).prop('disabled', false);
                $(`#` + page_slug_id + "_error").html('* page slug is  avalible');
                $(`#` + page_slug_id + "_error").css('color', 'black');


            } else {
                let page_slug = JSON.parse(data).page_slug;
                // let message = JSON.parse(data).page_slug;
                if (original_page_name != page_slug) {
                    $(`#` + page_slug_id).val(page_slug);
                    $(`#${draft_btn_id}`).prop('disabled', true);
                    $(`#${submit_btn_id}`).prop('disabled', true);

                    $(`#` + page_slug_id + "_error").html('* page slug is not avalible');
                    $(`#` + page_slug_id + "_error").css('color', 'red');
                }

            }

        },
        error: function (data) {
            console.log(data);
        }

    });
}