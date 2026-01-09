$(document).ready(function () {
    $("form").bind("keypress", function (e) {
        if (e.keyCode == 13) {
            return false;
        }
    });

    $("#txt_value").hide();
    $("#btn,#btn_2,#image").click(function () {
        setCookie("button_id", this.id);
        let base_url = $("#base").val();
        setCookie("base_url", base_url);

        $("#txt_value").val();
        $("#showsModal").on("show", function () { });
        $("#showsModal").modal({
            show: true
        });
        $("iframe").load(function () {
            $(".loading").hide();
        });
    });

    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
        let expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(";");
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == " ") {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    window.closeModal = function () {
        let host = window.location.host + "/";
        const media_url = "/admin/media-manager/check-media-data";
        $.ajax({
            method: "post",
            url: media_url,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (data) {
                let btn_id = getCookie("button_id");
                let field_id = "#" + btn_id;
                const image_preview_id = field_id + "_preview";
                image_src = "/uploads/media/" + data;

                let data_array = data.split(".");
                if (data_array.length == 2) {
                    if (['mp4', 'webm', 'ogg'].includes(data_array[1])) {
                        image_src = "/assets/dashboard/images/demo_img.jpg";
                    } else if (['pdf'].includes(data_array[1])) {
                        image_src = "/assets/dashboard/images/PDF_file_icon.svg";
                    }
                }
                $(`${image_preview_id}`)
                    .attr("src", image_src)
                    .height(100)
                    .width(100);
                $("#txt_value2").hide();
                $(`${field_id}`).show();
                $(`${field_id}`).val(data);

                /* Division preview optional */
                let web_div_id = getCookie("web_div_id");
                if (web_div_id != null) {
                    $(`#${web_div_id}`).attr("src", image_src);
                }

                let tablet_div_id = getCookie("tablet_div_id");
                if (tablet_div_id != null) {
                    $(`#${tablet_div_id}`).attr("src", image_src);
                }

                let mobile_div_id = getCookie("mobile_div_id");
                if (mobile_div_id != null) {
                    $(`#${mobile_div_id}`).attr("src", image_src);
                }


                /* End of preview */

                $("#showsModal").modal("hide");

            },
        });
    };
});
