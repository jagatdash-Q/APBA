/*  Modal insert form for youtube popup content  */
$("#youtube_modal_insert_form").on("submit", function (event) {
    event.preventDefault();
    const region_id = $("#input_region_id").val();
    const uid = $("#blog_uid").val();
    const content_type = $("#content_type").val();
    $(`#youtube_content_body`).empty();
    $.ajax({
        type: "POST",
        url: base_url + "/admin/blog/bloglistingcontent/store",
        data:
            $("#youtube_modal_insert_form").serialize() +
            `&region_id=${region_id}&uid=${uid}`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            $("#youtube_modal_insert_form").trigger("reset");
            if (data.includes("success")) {
                // update the form with the region selected
                const result = JSON.parse(data).data;
                $("#youtube_add_modal").modal("toggle");
                let temp_html = "";
                result.forEach(function (data, idx, result) {

                    temp_html += `<tr>   <td> <span> ${data.desc} </span> </td> <td> <span> ${data.link} </span> </td> <td> <span> <button type="button" class="btn btn-success" onclick="content_edit('${region_id}','${data.content_id}','${data.content_type}','')" data-toggle="modal" data-target="#youtube_edit_modal" > Edit </button>  <button type="button" class="btn btn-danger" data-region-id="${region_id}" data-content-id="${data.content_id}" data-content-type="youtube" data-toggle="modal" data-target="#blog_modal_content_delete" > Delete</button>   </span></td></tr>`;

                    if (idx === result.length - 1) {
                        $(`#youtube_content_body`).append(temp_html);
                    }

                    // $("#media_uid").val(data.media_uid);
                });
            }
        },
        error: function (jqXHR, textStatus, error) {
            $("#youtube_modal_insert_form").trigger("reset");

            console.log(jqXHR);
        },
    });
});
/*  End of Modal insert form for youtube popup content  */

/* Content edit function */
const content_edit = (region_id, content_id, content_type, content_url) => {
    const uid = $("#blog_uid").val();

    $.ajax({
        type: "GET",
        url:
            base_url +
            `/admin/blog/bloglistingcontent/get-blog-content?content_id=${content_id}&region_id=${region_id}&uid=${uid}&content_type=${content_type}&content_url=${content_url}`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.includes("success")) {
                //     // update the form with the region selected
                const result = JSON.parse(response).data;
                const language_list = JSON.parse(response).langs;
                const media_manager_contents = JSON.parse(response).media_manager_contents;

                for (i = 0; i < language_list.length; i++) {
                    let default_lang =
                        language_list[i].language.id ==
                            language_list[i].region.default_lang
                            ? "required"
                            : "";
                    let active_tab =
                        language_list[i].language.id ==
                            language_list[i].region.default_lang
                            ? "active"
                            : "";
                    direction = language_list[i].language.direction;
                    code = language_list[i].language.code;
                    icon = language_list[i].language.icon;
                    title = language_list[i].language.title;

                    switch (content_type) {
                        case "youtube":
                            $(`#youtube_desc_edit_${code}`).val('');
                            $(`#youtube_link_edit_${code}`).val('');
                            result.forEach(function (data, idx, result) {
                                if (
                                    data.lang_id == language_list[i].language.id
                                ) {
                                    $(`#youtube_desc_edit_${code}`).val(
                                        data.desc
                                    );
                                    $(`#youtube_link_edit_${code}`).val(
                                        data.link
                                    );
                                    $(`#youtube_content_id`).val(content_id);
                                }

                            });
                            break;
                        case "pdf":
                            $(`#pdf_desc_edit_${code}`).val('');
                            $(`#pdf_link_edit_${code}`).val('');
                            result.forEach(function (data, idx, result) {
                                if (
                                    data.lang_id == language_list[i].language.id
                                ) {
                                    $(`#pdf_desc_edit_${code}`).val(data.desc);
                                    $(`#pdf_link_edit_${code}`).val(data.link);
                                    $(`#pdf_content_id`).val(content_id);
                                    if (media_manager_contents.indexOf(data.image) !== -1) {
                                        if (data.image != null) {
                                            $(`#pdf_edit_image_preview`).attr(
                                                "src",
                                                base_url +
                                                "/uploads/media/" +
                                                data.image
                                            );
                                        }

                                        $(`#pdf_edit_image`).val(data.image);
                                    }
                                }
                            });

                            break;
                        case "flipsnack":
                            $(`#flipsnack_desc_edit_${code}`).val('');
                            $(`#flipsnack_view_link_edit_${code}`).val('');
                            $(`#flipsnack_download_link_edit_${code}`).val('');
                            result.forEach(function (data, idx, result) {
                                if (
                                    data.lang_id == language_list[i].language.id
                                ) {
                                    $(`#flipsnack_desc_edit_${code}`).val(
                                        data.desc
                                    );
                                    $(`#flipsnack_view_link_edit_${code}`).val(
                                        data.link
                                    );
                                    $(
                                        `#flipsnack_download_link_edit_${code}`
                                    ).val(data.download_link);
                                    $(`#flipsnack_content_id`).val(content_id);

                                    if (media_manager_contents.indexOf(data.image) !== -1) {

                                        if (data.image != null) {
                                            $(`#flipsnack_image_edit_preview`).attr(
                                                "src",
                                                base_url +
                                                "/uploads/media/" +
                                                data.image
                                            );
                                        }
                                        $(`#flipsnack_image_edit`).val(data.image);
                                    }
                                }
                            });
                            break;
                    }
                }
            }
        },
        error: function (jqXHR, textStatus, error) {
            console.log(jqXHR);
        },
    });
};
/* ENd of Content edit function */

/* Blog popup content delete function */
const blog_content_delete = (
    region_id,
    content_id,
    content_type,
    content_url
) => {
    const uid = $("#blog_uid").val();
    switch (content_type) {
        case "youtube":
            $(`#youtube_content_body`).empty();
            break;
        case "pdf":
            $(`#pdf_content_body`).empty();
            break;
        case "flipsnack":
            $(`#flipsnack_content_body`).empty();
            break;
    }

    $.ajax({
        type: "POST",
        url: base_url + "/admin/blog/bloglistingcontent/delete",
        data: `content_id=${content_id}&region_id=${region_id}&uid=${uid}&content_type=${content_type}&content_url=${content_url}`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            $('#blog_modal_content_delete').modal("hide");

            if (data.includes("success")) {
                // update the form with the region selected
                const result = JSON.parse(data).data;

                let temp_html = "";
                result.forEach(function (data, idx, result) {
                    image_src =
                        data.image != null
                            ? base_url + `/uploads/media/${data.image}`
                            : base_url +
                            `/assets/dashboard/images/image_not_found.jpg`;
                    let temp_data = '';
                    if (content_type != 'youtube') {
                        temp_data = `<td> <img src="${image_src}" height="100px" width="100px" alt="image not found" /> </td>`;
                    }

                    temp_html += `<tr> ${temp_data}   <td> <span> ${data.desc} </span> </td> <td> <span> ${data.link} </span> </td>`
                    if (content_type == 'flipsnack') {
                        temp_html += `<td> <span> ${data.download_link} </span> </td> `;
                    }

                    temp_html += `<td> <span> <button type="button" class="btn btn-success" onclick="content_edit('${region_id}','${data.content_id}','${data.content_type}','')" data-toggle="modal"`;

                    switch (content_type) {
                        case "youtube":
                            temp_html += ` data-target="#youtube_edit_modal" > Edit </button>  <button type="button" class="btn btn-danger" data-region-id="${region_id}" data-content-id="${data.content_id}" data-content-type="youtube" data-toggle="modal" data-target="#blog_modal_content_delete"  > Delete</button>   </span></td></tr>`;
                            break;
                        case "pdf":
                            temp_html += ` data-target="#pdf_edit_modal" > Edit </button>  <button type="button" class="btn btn-danger" data-region-id="${region_id}" data-content-id="${data.content_id}" data-content-type="pdf" data-toggle="modal" data-target="#blog_modal_content_delete"  > Delete</button>   </span></td></tr>`;
                            break;
                        case "flipsnack":
                            temp_html += ` data-target="#flipsnack_edit_modal" > Edit </button>  <button type="button" class="btn btn-danger" data-region-id="${region_id}" data-content-id="${data.content_id}" data-content-type="flipsnack" data-toggle="modal" data-target="#blog_modal_content_delete"  > Delete</button>   </span></td></tr>`;
                            break;
                    }

                    if (idx === result.length - 1) {
                        switch (content_type) {
                            case "youtube":
                                $(`#youtube_content_body`).append(temp_html);
                                break;
                            case "pdf":
                                $(`#pdf_content_body`).append(temp_html);
                                break;
                            case "flipsnack":
                                $(`#flipsnack_content_body`).append(temp_html);
                                break;
                        }
                    }
                });
            }
        },
        error: function (jqXHR, textStatus, error) {
            console.log(jqXHR);
            $('#blog_modal_content_delete').modal("hide");

        },
    });
};
/*End of  Blog popup content delete function */

/*  Modal insert form for pdf popup content  */
$("#pdf_modal_insert_form").on("submit", function (event) {
    event.preventDefault();
    const region_id = $("#input_region_id").val();
    const uid = $("#blog_uid").val();
    $(`#pdf_content_body`).empty();

    $.ajax({
        type: "POST",
        url: base_url + "/admin/blog/bloglistingcontent/store",
        data:
            $("#pdf_modal_insert_form").serialize() +
            `&region_id=${region_id}&uid=${uid}`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            $("#pdf_modal_insert_form").trigger("reset");
            $("#pdf_image_preview").attr(
                "src",
                base_url + `/assets/dashboard/images/image_not_found.jpg`
            );
            if (data.includes("success")) {
                const result = JSON.parse(data).data;

                $("#pdf_add_modal").modal("toggle");
                let image_height = (image_width = "125px");
                let temp_html = "";
                result.forEach(function (data, idx, result) {
                    image_src =
                        data.image != null
                            ? base_url + `/uploads/media/${data.image}`
                            : base_url +
                            `/assets/dashboard/images/image_not_found.jpg`;
                    temp_html += `<tr> <td> <img src="${image_src}" alt="image not found" height="${image_height}" width="${image_width}"/></td>  <td> <span> ${data.desc} </span> </td> <td> <span> ${data.link} </span> </td> <td> <span> <button type="button" class="btn btn-success" onclick="content_edit('${region_id}','${data.content_id}','${data.content_type}','')" data-toggle="modal" data-target="#pdf_edit_modal" > Edit </button>  <button type="button" class="btn btn-danger" data-region-id="${region_id}" data-content-id="${data.content_id}" data-content-type="pdf" data-toggle="modal" data-target="#blog_modal_content_delete"  > Delete</button>   </span></td></tr>`;
                    if (idx === result.length - 1) {
                        $(`#pdf_content_body`).append(temp_html);
                    }
                });
            }
        },
        error: function (jqXHR, textStatus, error) {
            $("#pdf_modal_insert_form").trigger("reset");
            console.log(jqXHR);
        },
    });
});
/*  End of Modal insert form for pdf popup content  */

/*  Modal insert form for flipsnack popup content  */
$("#flipsnack_modal_insert_form").on("submit", function (event) {
    event.preventDefault();
    const region_id = $("#input_region_id").val();
    const uid = $("#blog_uid").val();
    $(`#flipsnack_content_body`).empty();

    $.ajax({
        type: "POST",
        url: base_url + "/admin/blog/bloglistingcontent/store",
        data:
            $("#flipsnack_modal_insert_form").serialize() +
            `&region_id=${region_id}&uid=${uid}`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            $("#flipsnack_modal_insert_form").trigger("reset");
            $("#flipsnack_image_preview").attr(
                "src",
                base_url + `/assets/dashboard/images/image_not_found.jpg`
            );
            if (data.includes("success")) {
                const result = JSON.parse(data).data;
                $("#flipsnack_add_modal").modal("toggle");
                let image_height = (image_width = "125px");
                let temp_html = "";
                result.forEach(function (data, idx, result) {
                    image_src =
                        data.image != null
                            ? base_url + `/uploads/media/${data.image}`
                            : base_url +
                            `/assets/dashboard/images/image_not_found.jpg`;
                    temp_html += `<tr> <td> <img src="${image_src}" alt="image not found" height="${image_height}" width="${image_width}"/></td>  <td> <span> ${data.desc} </span> </td> <td> <span> ${data.link} </span> </td>  <td> <span> ${data.download_link} </span> </td> <td> <span> <button type="button" class="btn btn-success" onclick="content_edit('${region_id}','${data.content_id}','${data.content_type}','')" data-toggle="modal" data-target="#flipsnack_edit_modal" > Edit </button>  <button type="button" class="btn btn-danger" data-region-id="${region_id}" data-content-id="${data.content_id}" data-content-type="flipsnack" data-toggle="modal" data-target="#blog_modal_content_delete"  > Delete</button>   </span></td></tr>`;
                    if (idx === result.length - 1) {
                        $(`#flipsnack_content_body`).append(temp_html);
                    }

                    // $("#media_uid").val(data.media_uid);
                });
            }
        },
        error: function (jqXHR, textStatus, error) {
            $("#flipsnack_modal_insert_form").trigger("reset");

            console.log(jqXHR);
        },
    });
});
/*  End of Modal insert form for flipsnack popup content  */

/*  Modal update form for youtube popup content  */
$("#youtube_modal_update_form").on("submit", function (event) {
    event.preventDefault();
    const region_id = $("#input_region_id").val();
    const uid = $("#blog_uid").val();
    $(`#youtube_content_body`).empty();
    $.ajax({
        type: "POST",
        url: base_url + "/admin/blog/bloglistingcontent/update",
        data:
            $("#youtube_modal_update_form").serialize() +
            `&region_id=${region_id}&uid=${uid}`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            $("#youtube_modal_update_form").trigger("reset");
            if (data.includes("success")) {
                const result = JSON.parse(data).data;
                $("#youtube_edit_modal").modal("toggle");
                let temp_html = "";
                result.forEach(function (data, idx, result) {
                    temp_html += `<tr>   <td> <span> ${data.desc} </span> </td> <td> <span> ${data.link} </span> </td> <td> <span> <button type="button" class="btn btn-success" onclick="content_edit('${region_id}','${data.content_id}','${data.content_type}','')" data-toggle="modal" data-target="#youtube_edit_modal" > Edit </button>  <button type="button" class="btn btn-danger" data-region-id="${region_id}" data-content-id="${data.content_id}" data-content-type="youtube" data-toggle="modal" data-target="#blog_modal_content_delete"  > Delete</button>   </span></td></tr>`;
                    if (idx === result.length - 1) {
                        $(`#youtube_content_body`).append(temp_html);
                    }

                });
            }
        },
        error: function (jqXHR, textStatus, error) {
            $("#youtube_modal_update_form").trigger("reset");

            console.log(jqXHR);
        },
    });
});
/*  End of Modal update form for youtube popup content  */

/*  Modal update form for flipsnack popup content  */
$("#flipsnack_modal_update_form").on("submit", function (event) {
    event.preventDefault();
    const region_id = $("#input_region_id").val();
    const uid = $("#blog_uid").val();
    // const content_id = $("#blog_uid").val();

    $(`#flipsnack_content_body`).empty();
    $.ajax({
        type: "POST",
        url: base_url + "/admin/blog/bloglistingcontent/update",
        data:
            $("#flipsnack_modal_update_form").serialize() +
            `&region_id=${region_id}&uid=${uid}`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            $("#flipsnack_modal_update_form").trigger("reset");
            $("#flipsnack_image_edit_preview").attr(
                "src",
                base_url + `/assets/dashboard/images/image_not_found.jpg`
            );

            if (data.includes("success")) {
                // update the form with the region selected
                const result = JSON.parse(data).data;

                $("#flipsnack_edit_modal").modal("toggle");
                let temp_html = "";
                result.forEach(function (data, idx, result) {
                    image_src =
                        data.image != null
                            ? base_url + `/uploads/media/${data.image}`
                            : base_url +
                            `/assets/dashboard/images/image_not_found.jpg`;
                    temp_html += `<tr> <td> <img src=${image_src} height="50px" width="50px" alt="image not found" /></td>   <td> <span> ${data.desc} </span> </td> <td> <span> ${data.link} </span> </td> </td> <td> <span> ${data.download_link} </span> </td>  <td> <span> <button type="button" class="btn btn-success" onclick="content_edit('${region_id}','${data.content_id}','${data.content_type}','')" data-toggle="modal" data-target="#flipsnack_edit_modal" > Edit </button>  <button type="button" class="btn btn-danger" data-region-id="${region_id}" data-content-id="${data.content_id}" data-content-type="flipsnack" data-toggle="modal" data-target="#blog_modal_content_delete"  > Delete</button>   </span></td></tr>`;
                    if (idx === result.length - 1) {
                        $(`#flipsnack_content_body`).append(temp_html);
                    }

                    // $("#media_uid").val(data.media_uid);
                });
            }
        },
        error: function (jqXHR, textStatus, error) {
            $("#flipsnack_modal_update_form").trigger("reset");

            console.log(jqXHR);
        },
    });
});
/*  End of Modal update form for flipsnack popup content  */

/*  Modal update form for pdf popup content  */
$("#pdf_modal_update_form").on("submit", function (event) {
    event.preventDefault();
    const region_id = $("#input_region_id").val();
    const uid = $("#blog_uid").val();
    $(`#pdf_content_body`).empty();
    $.ajax({
        type: "POST",
        url: base_url + "/admin/blog/bloglistingcontent/update",
        data:
            $("#pdf_modal_update_form").serialize() +
            `&region_id=${region_id}&uid=${uid}`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            $("#pdf_modal_update_form").trigger("reset");
            $("#pdf_edit_image_preview").attr(
                "src",
                base_url + `/assets/dashboard/images/image_not_found.jpg`
            );

            if (data.includes("success")) {
                // update the form with the region selected
                const result = JSON.parse(data).data;
                $("#pdf_edit_modal").modal("toggle");
                let temp_html = "";
                result.forEach(function (data, idx, result) {

                    temp_html += `<tr><td> <img src=${image_src} height="50px" width="50px" alt="image not found" /></td>   <td> <span> ${data.desc} </span> </td> <td> <span> ${data.link} </span> </td> <td> <span> <button type="button" class="btn btn-success" onclick="content_edit('${region_id}','${data.content_id}','${data.content_type}','')" data-toggle="modal" data-target="#pdf_edit_modal" > Edit </button>  <button type="button" class="btn btn-danger" data-region-id="${region_id}" data-content-id="${data.content_id}" data-content-type="pdf" data-toggle="modal" data-target="#blog_modal_content_delete"  > Delete</button>   </span></td></tr>`;
                    if (idx === result.length - 1) {
                        $(`#pdf_content_body`).append(temp_html);
                    }

                });
            }
        },
        error: function (jqXHR, textStatus, error) {
            $("#pdf_modal_update_form").trigger("reset");
            console.log(jqXHR);
        },
    });
});
/*  End of Modal update form for pdf popup content  */
