// For fetching data based on languages
const submitDataForm = () => {
    let region_id = $("#region_id").find(":selected").val();
    $.ajax({
        url: base_url + "/admin/get-language-by-country?region_id=" + region_id,
        contentType: false,
        processData: false,
        type: "GET",
        success: function (data) {
            if (data.includes("success")) {
                // update the form with the region selected
                $("#input_region_id").val(region_id);
                $("#content_div").css("display", "block");
                $("#column_num_div").css("display", "block");

                const language_list = JSON.parse(data).language_list;
                var languageMenu = (contentMenus = popupMediaContent = tabTitles = ``);
                let tabCommonContent = ``;
                let langs = [];

                for (i = 0; i < language_list.length; i++) {
                    let default_lang = language_list[i].language.id == language_list[i].region.default_lang ? "required" : "";
                    let active_tab = language_list[i].language.id == language_list[i].region.default_lang ? "active" : "";

                    languageMenu += ` <li class="nav-item inline"> <a class="nav-link  ${active_tab}" href="" data-toggle="tab" data-target="#tab_details${i + 1}">   <span class="text-md"><span class="label light text-dark lang-label"><img src="${base_url}/assets/dashboard/images/flags/${language_list[i].language.icon}.svg" alt=""> <small>${language_list[i].language.title}</small></span></span>  </a> </li>`;

                    tabCommonContent += ` <div class="tab-pane  ${active_tab}" id="tab_details${i + 1}"> <div class="box-body" id="box-body_${language_list[i].language.code}">    <div class="common"> <div class="form-group row"> <div class="col-sm-2"> <label class=" form-control-label"> Page Name   </label>  </div>  <div class="col-sm-10"> <input placeholder="" class="form-control" ${default_lang} dir="${language_list[i].language.direction}" name="page_name_${language_list[i].language.code}" id="page_name_${language_list[i].language.code}" type="text" value="" oninput="generatePageSlug(this.value,'page_slug_${language_list[i].language.code}' )">  </div> </div> <div class="form-group row">  <div class="col-sm-2">  <label class=" form-control-label"> Page Slug </label>  </div>  <div class="col-sm-10">   <input placeholder="" class="form-control" ${default_lang} dir="${language_list[i].language.direction}" name="page_slug_${language_list[i].language.code}" id="page_slug_${language_list[i].language.code}" type="text"  disabled>  </div> </div> <div class="form-group row">  <div class="col-sm-2"> <label class=" form-control-label"> Meta Title  </label>   </div>     <div class="col-sm-10"> <input placeholder="" class="form-control" ${default_lang} dir="${language_list[i].language.direction}" name="meta_title_${language_list[i].language.code}" id="meta_title_${language_list[i].language.code}" type="text" value="" >   </div> </div> <div class="form-group row">    <div class="col-sm-2">   <label class=" form-control-label"> Meta Keywoard  </label>    </div>     <div class="col-sm-10">   <input placeholder="" class="form-control" ${default_lang} dir="${language_list[i].language.direction}" name="meta_keyword_${language_list[i].language.code}" id="meta_keyword_${language_list[i].language.code}" type="text" value="" > </div> </div> <div class="form-group row">  <div class="col-sm-2">   <label class=" form-control-label"> Meta Description  </label>  </div>   <div class="col-sm-10">   <input placeholder="" class="form-control" ${default_lang} dir="${language_list[i].language.direction}" name="meta_description_${language_list[i].language.code}" id="meta_description_${language_list[i].language.code}" type="text" value="" >  </div>  </div>  </div>   <hr>   </div> </div> </div> </div>  </div> </div> </div> `;

                    langs.push(language_list[i].language.code);

                    popupMediaContent += ` <div class="tab-pane   ${active_tab}" id="tab_${i + 1}"> <div class="box-body" id="media-box-body_${language_list[i].language.code}">    <div class="common">  <div class="form-group row"><div class="col-sm-2"> <label class="form-control-label"> Title      </label>  </div>  <div class="col-sm-10">  <input type="text" placeholder="" class="form-control" name="content_title_${language_list[i].language.code}"   id="content_title_${language_list[i].language.code}" type="text" value="" ${default_lang} >  </div>  </div> <div class="form-group row">  <div class="col-sm-2"> <label class="form-control-label">    Link   </label>  </div>  <div class="col-sm-10">  <input type="url" placeholder="" class="form-control" name="content_link_${language_list[i].language.code}"   id="content_link_${language_list[i].language.code}" type="text" value="" ${default_lang}>  </div>   </div> </div> </div>    </div>`;
                    contentMenus += ` <li class="nav-item inline"> <a class="nav-link  ${active_tab}" href="" data-toggle="tab" data-target="#tab_${i + 1}">   <span class="text-md"><span class="label light text-dark lang-label"><img src="${base_url}/assets/dashboard/images/flags/${language_list[i].language.icon}.svg" alt=""> <small>${language_list[i].language.title}</small></span></span>  </a> </li>`;

                    tabTitles += `   <div class="form-group row"> <div class="col-sm-2" > <label class="form-control-label section_title">Title </label> <span class="label light text-dark lang-label section_lang"><img src="${base_url}/assets/dashboard/images/flags/${language_list[i].language.icon}.svg" alt=""> <small>${language_list[i].language.title}</small></span>  </div> <div class="col-sm-10">  <input placeholder="" class="form-control" ${default_lang}   dir="${language_list[i].language.direction}" name="section_1_title_${language_list[i].language.code}" id="section_1_title_${language_list[i].language.code}" type="text" value="">  </div> </div>  `;
                }
                let tab_extras = ` <div id="parent_content_id" ><div  id="section_1" class="section" > <div class="box-body">    <div class="row" style="margin-bottom:10px"> <div class="col-sm-10"> <span> Section 1 </span> </div> <div class="col-sm-2"> <button type="button" class="btn btn-primary" onclick="add_new_section('parent_content_id','${region_id}')" > + Add Section </button> </div> </div>   ${tabTitles}  <div class="card shadow mb-4"> <div class="card-header py-2"> <div class="row">   <div class="col-md-8 col-sm-8 col-8 col-lg-8 col-xl-8 " style="display: flex;">     <div class="col-md-4 col-sm-2 col-xs-2"> <h6 class="m-0 mt-2 font-weight-bolder text-dark content-section-header">Section 1 Content</h6> </div>   </div>  <div class="col-md-4 col-sm-4 col-4 col-lg-4 col-xl-4">     <button type="button" style="float:right" class="btn btn-primary" data-toggle="modal" data-target="#media_add_modal" onclick="setSectionId('section_1')">  Add  </button> </div>  </div>  </div>  <div class="card-body"> <div class="table-responsive">   <div class="form-group col-md-12 col-lg-12 col-xl-12 col-sm-12 pr-3">  <table class="table table-bordered" id="" width="100%" cellspacing="0">  <thead>  <tr> <th >Image</th> <th >Title</th> <th >Link</th> <th >Action</th> </tr>  </thead> <tbody id="section_1_content_body">  </tbody> </table>   </div>    </div> </div> </div> `;

                end_content = `<div class="form-group row" style="margin-top: 20px;padding-bottom: 5px;"> <div class="col-sm-10"> </div> <div class="col-sm-2"> <button class="btn btn-primary" type="submit" name="draft" value="draft"> Draft </button> <button class="btn btn-success" type="submit" name="submit" value="submit"> Submit </button>  </div>`;

                $("#content_menus").append(contentMenus);
                $("#media_content").append(popupMediaContent);
            }
            if (data.includes("error")) {
                alert("error");
            }
        },
        error: function (data) {
            console.log(data);
        },
    });
};

// Modal insert form for insert popup content
$("#media_modal_insert_form").on("submit", function (event) {
    event.preventDefault();
    const region_id = $("#input_region_id").val();
    const modal_section_id = $("#modal_section_id").val();
    const media_uid = $('#media_uid').val();
    const content_table_id = $('#content_table_id').val();
    $.ajax({
        type: "POST",
        url: base_url + "/admin/mediapage/medialisting/content-store",
        data: $("#media_modal_insert_form").serialize() +
            `&region_id=${region_id}&media_uid=${media_uid}&content_table_id=${content_table_id}`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            $(`#${modal_section_id}_content_body`).empty();

            $("#media_modal_insert_form").trigger("reset");
            $("#modal_image_preview").attr(
                "src",
                base_url + `/assets/dashboard/images/image_not_found.jpg`
            );

            if (data.includes("success")) {
                // update the form with the region selected
                const result = JSON.parse(data).data;
                if (result[0].media_uid != null) {
                    $("#media_uid").val(result[0].media_uid);
                    $("#media_uid_edit").val(result[0].media_uid);
                }

                $("#media_add_modal").modal("toggle");
                let temp_html = "";
                result.forEach(function (data, idx, result) {
                    image_src = base_url + `/assets/dashboard/images/image_not_found.jpg`;
                    if (data.image_details != null) {
                        image_src = data.image_details.file_name != null ?
                            base_url + `/uploads/media/${data.image_details.file_name}` :
                            base_url + `/assets/dashboard/images/image_not_found.jpg`;
                    }
                    temp_html += `<tr> <td> <img src="${image_src}" height="100" width="100" alt="Image not found"></td>  <td> <span> ${data.title} </span> </td> <td> <span> ${data.link} </span> </td> <td> <span> <button type="button" class="btn btn-success btn-sm" onclick="content_edit('${data.content_id}','${modal_section_id}')" data-toggle="modal" data-target="#media_edit_modal" > Edit </button>  <button type="button" class="btn btn-danger btn-sm"  data-region-id="${region_id}"  data-media-uid="${data.media_uid}" data-content-id="${data.content_id}" data-section-data-id="${modal_section_id}"
                    data-title=" ${data.title}"  data-toggle="modal"
                    data-target="#modal_content_delete"  > Delete</button>   </span></td></tr>`;
                    if (idx === result.length - 1) {
                        $(`#${modal_section_id}_content_body`).append(
                            temp_html
                        );
                    }

                    $("#media_uid").val(data.media_uid);
                });
            }
        },
        error: function (jqXHR, textStatus, error) {
            $("#media_modal_insert_form").trigger("reset");

            console.log(jqXHR);
        },
    });
});

// New Section add form for adding a new section
const add_new_section = (parent_div_id, region_id) => {
    var total = $(".section").length;
    $(".section").each(function (index, elem) {
        if (index === total - 1) {
            last_div = elem.id;
        }
    });

    next_element = Number(last_div.substr(8, last_div.length - 8)) + 1;
    next_div = last_div.substr(0, 8) + next_element;
    let tabTitles = "";

    $.ajax({
        url: base_url + "/admin/get-language-by-country?region_id=" + region_id,
        contentType: false,
        processData: false,
        type: "GET",
        success: function (data) {
            if (data.includes("success")) {
                // update the form with the region selected
                $("#input_region_id").val(region_id);
                $("#content_div").css("display", "block");
                const language_list = JSON.parse(data).language_list;
                for (i = 0; i < language_list.length; i++) {
                    let default_lang =
                        language_list[i].language.id ==
                        language_list[i].region.default_lang ?
                        "required" :
                        "";

                    tabTitles += `   <div class="form-group row"> <div class="col-sm-2" > <label class="form-control-label">Title (H2) </label> <span class="label light text-dark lang-label"><img src="${base_url}/assets/dashboard/images/flags/${language_list[i].language.icon}.svg" alt=""> <small>${language_list[i].language.title}</small></span>  </div> <div class="col-sm-10">  <input placeholder="" class="form-control" ${default_lang}   dir="${language_list[i].language.direction}" name="${next_div}_title_${language_list[i].language.code}" id="${next_div}_title_${language_list[i].language.code}" type="text" value="">  </div> </div>  `;
                }
                $(`#${parent_div_id}`).append(
                    `<div  id="${next_div}" class="section" > <hr> <div class="box-body">    <div class="row" style="margin-bottom:10px"> <div class="col-sm-10"> <span> Section ${total + 1} </span> </div> <div class="col-sm-2"> <button type="button" class="btn btn-danger btn-sm"  data-section-id="${next_div}" data-toggle="modal"
                    data-target="#modal_section_delete" >  Delete Section </button> </div> </div>   ${tabTitles}  <div class="card shadow mb-4"> <div class="card-header py-2"> <div class="row">   <div class="col-md-8 col-sm-8 col-8 col-lg-8 col-xl-8 " style="display: flex;">     <div class="col-md-4 col-sm-2 col-xs-2"> <h6 class="m-0 mt-2 font-weight-bolder text-dark content-section-header">Section ${total + 1} Content</h6> </div>   </div>  <div class="col-md-4 col-sm-4 col-4 col-lg-4 col-xl-4">     <button type="button" style="float:right" class="btn btn-primary" data-toggle="modal" data-target="#media_add_modal" onclick="setSectionId('section_${next_element}')">  Add  </button> </div>  </div>  </div>  <div class="card-body"> <div class="table-responsive">   <div class="form-group col-md-12 col-lg-12 col-xl-12 col-sm-12 pr-3">  <table class="table table-bordered" id="" width="100%" cellspacing="0">  <thead>  <tr> <th >Image</th> <th >Title</th> <th >Link</th> <th >Action</th> </tr>  </thead> <tbody id="section_${next_element}_content_body">  </tbody> </table>   </div>    </div> </div> </div> `
                );
            }
        },
    });
};

// Delete section delete from ui and delete from database
const delete_section_content = (div_id, section_id) => {
    const media_uid = $('#media_uid').val();
    const content_table_id = $('#content_table_id').val();

    $.ajax({
        type: "POST",
        url: base_url + "/admin/mediapage/medialisting/section-delete",
        data: `media_uid=${media_uid}&section_id=${section_id}&content_table_id=${content_table_id}`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            $("#modal_image_preview").attr("src", base_url + `/assets/dashboard/images/image_not_found.jpg`);
            $("#modal_section_delete").modal("toggle");
            if (data.includes("success")) $(`#${div_id}`).remove();
        },
        error: function (jqXHR, textStatus, error) {
            console.log(jqXHR);
        },
    });
}

// For fetching popup edit content
const content_data_edit = (content_id, section_id) => {
    let region_id = $("#input_region_id").val();
    $("#edit_content_menus").empty();
    $("#media_content_edit").empty();
    $("#modal_section_id_edit").val(section_id);
    $("#modal_image_edit_preview").attr("src", "/assets/dashboard/images/image_not_found.jpg");

    $.ajax({
        url: base_url + "/admin/get-language-by-country?region_id=" + region_id,
        contentType: false,
        processData: false,
        type: "GET",
        success: function (data) {
            if (data.includes("success")) {
                // update the form with the region selected
                $("#input_region_id").val(region_id);
                $("#content_div_edit").css("display", "block");
                const language_list = JSON.parse(data).language_list;
                let languageMenu = popupMediaContent = '';
                let langs = [];

                for (i = 0; i < language_list.length; i++) {
                    let default_lang = language_list[i].language.id == language_list[i].region.default_lang ? "required" : "";
                    let active_tab = language_list[i].language.id == language_list[i].region.default_lang ? "active" : "";

                    languageMenu += ` <li class="nav-item inline"> <a class="nav-link  ${active_tab}" href="" data-toggle="tab" data-target="#tab_edit${i + 1}">   <span class="text-md"><span class="label light text-dark lang-label"><img src="${base_url}/assets/dashboard/images/flags/${language_list[i].language.icon}.svg" alt=""> <small>${language_list[i].language.title}</small></span></span>  </a> </li>`;

                    popupMediaContent += ` <div class="tab-pane   ${active_tab}" id="tab_edit${i + 1}"> <div class="box-body" id="media-box-body_edit_${language_list[i].language.code}">    <div class="common">  <div class="form-group row"><div class="col-sm-2"> <label class="form-control-label"> Title      </label>  </div>  <div class="col-sm-10">  <input type="text" placeholder="" class="form-control" name="content_title_edit_${language_list[i].language.code}"   id="content_title_edit_${language_list[i].language.code}" type="text" value="" ${default_lang} >  </div>  </div> <div class="form-group row">  <div class="col-sm-2"> <label class="form-control-label">    Link   </label>  </div>  <div class="col-sm-10">  <input type="url" placeholder="" class="form-control" name="content_link_edit_${language_list[i].language.code}"   id="content_link_edit_${language_list[i].language.code}" type="text" value="" ${default_lang}>  </div>   </div> </div> </div>    </div>`;
                    contentMenus += ` <li class="nav-item inline"> <a class="nav-link  ${active_tab}" href="" data-toggle="tab" data-target="#tab_${i + 1}">   <span class="text-md"><span class="label light text-dark lang-label"><img src="${base_url}/assets/dashboard/images/flags/${language_list[i].language.icon}.svg" alt=""> <small>${language_list[i].language.title}</small></span></span>  </a> </li>`;
                    langs.push(language_list[i].language.code);

                    if (i == language_list.length - 1) {
                        $("#edit_content_menus").append(languageMenu);
                        $("#media_content_edit").append(popupMediaContent);
                    }
                }

                $.ajax({
                    url: base_url + "/admin/mediapage/medialisting/get-data-per-content-id?content_id=" + content_id,
                    contentType: false,
                    processData: false,
                    type: "GET",
                    success: function (response) {
                        if (response.includes("success")) {
                            let data = JSON.parse(response);
                            const media_content = data.data;

                            
                            image_src = base_url + `/assets/dashboard/images/image_not_found.jpg`;
                            if (media_content[0].image_details != null) {
                                $(`#modal_image_edit`).val(media_content[0].image_details.file_name);
                                image_src = media_content[0].image_details.file_name != null ?
                                    base_url + `/uploads/media/${media_content[0].image_details.file_name}` :
                                    base_url + `/assets/dashboard/images/image_not_found.jpg`;
                            }

                            // if (media_content[0].image_details.file_name != null) {
                            $(`#modal_image_edit_preview`).attr('src', image_src)
                            // }

                            $('exampleModalLabel').html('Edit Content');
                            for (i = 0; i < language_list.length; i++) {
                                for (j = 0; j < media_content.length; j++) {

                                    if (language_list[i].lang_id != media_content[j].lang_id) {
                                        continue;
                                    }
                                    $(`#content_title_edit_${language_list[i].language.code}`).val(media_content[j].title);
                                    if (media_content[0].media_manager != null) {
                                        $(`#content_link_edit_${language_list[i].language.code}`).val(media_content[j].media_manager.media_url);

                                    } else {
                                        $(`#content_link_edit_${language_list[i].language.code}`).val(media_content[j].link);

                                    }
                                    $('#content_id_edit').val(media_content[0].content_id)


                                    if (media_content[i].media_uid != null) {
                                        $("#media_uid_edit").val(
                                            media_content[i].media_uid
                                        );
                                    }
                                }
                            }
                        } else {
                            console.log("No data found using content id");
                        }
                    },
                    error: function (data) {

                    }
                });

            }
        },
    });
};

// For modal form submit
$("#media_modal_update_form").on("submit", function (event) {
    event.preventDefault();

    const region_id = $("#input_region_id").val();
    const modal_section_id = $("#modal_section_id_edit").val();
    $(`#${modal_section_id}_content_body`).empty();
    $("#modal_image_edit_preview").attr("src", "/assets/dashboard/images/image_not_found.jpg");
    const content_table_id = $('#content_table_id').val();

    $.ajax({
        type: "POST",
        url: base_url + "/admin/mediapage/medialisting/content-update",
        data: $("#media_modal_update_form").serialize() +
            `&region_id=${region_id}&content_table_id=${content_table_id}`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            $("#media_modal_update_form").trigger("reset");
            $("#modal_image_preview").attr(
                "src",
                base_url + `/assets/dashboard/images/image_not_found.jpg`
            );

            if (data.includes("success")) {
                // update the form with the region selected
                const result = JSON.parse(data).data;
                if (result[0].media_uid != null) {
                    $("#media_uid").val(result[0].media_uid);
                    $("#media_uid_edit").val(result[0].media_uid);
                }

                $("#media_edit_modal").modal("toggle");
                let temp_html = "";
                result.forEach(function (data, idx, result) {
                    image_src = base_url + `/assets/dashboard/images/image_not_found.jpg`;
                    if (data.image_details != null)
                        image_src = base_url + `/uploads/media/${data.image_details.file_name}`;

                    let temp_link = data.link;
                    if (data.media_manager != null) {
                        temp_link = data.media_manager.media_url
                    }
                    temp_html += `<tr> <td> <img src="${image_src}" height="100" width="100" alt="Image not found"></td>  <td> <span> ${data.title} </span> </td> <td> <span> ${temp_link} </span> </td> <td> <span> <button type="button" class="btn btn-success btn-sm" onclick="content_data_edit('${data.content_id}','${modal_section_id}')" data-toggle="modal" data-target="#media_edit_modal" > Edit </button>  <button type="button" class="btn btn-danger btn-sm" data-region-id="${region_id}"  data-media-uid="${data.media_uid}" data-content-id="${data.content_id}" data-section-data-id="${modal_section_id}"
                    data-title=" ${data.title}" data-toggle="modal"
                    data-target="#modal_content_delete" > Delete</button>   </span></td></tr>`;
                    if (idx === result.length - 1) {

                        $(`#${modal_section_id}_content_body`).append(
                            temp_html
                        );
                    }
                });
            }
        },
        error: function (jqXHR, textStatus, error) {
            $("#media_modal_update_form").trigger("reset");

            console.log(jqXHR);
        },
    });
});

// Set section ID 
const setSectionId = (section_id) => {
    $("#modal_section_id").val(section_id);
    $("#modal_section_id_edit").val(section_id);
    $("#media_modal_insert_form").trigger("reset");
    $("#modal_image").val("");
    $("#modal_image_preview").attr("src", base_url + `/assets/dashboard/images/image_not_found.jpg`);
};

// Content edit form for data fetching
const content_edit = (content_id, section_id) => {
    let region_id = $("#input_region_id").val();
    $("#edit_content_menus").empty();
    $("#media_content_edit").empty();
    $.ajax({
        url: base_url + "/admin/get-language-by-country?region_id=" + region_id,
        contentType: false,
        processData: false,
        type: "GET",
        success: function (data) {
            if (data.includes("success")) {
                // update the form with the region selected
                $("#input_region_id").val(region_id);
                $("#content_div_edit").css("display", "block");
                const language_list = JSON.parse(data).language_list;
                let languageMenu = popupMediaContent = '';
                let langs = [];


                for (i = 0; i < language_list.length; i++) {
                    let default_lang =
                        language_list[i].language.id ==
                        language_list[i].region.default_lang ?
                        "required" :
                        "";
                    let active_tab =
                        language_list[i].language.id ==
                        language_list[i].region.default_lang ?
                        "active" :
                        "";

                    languageMenu += ` <li class="nav-item inline"> <a class="nav-link  ${active_tab}" href="" data-toggle="tab" data-target="#tab_edit${i + 1
                        }">   <span class="text-md"><span class="label light text-dark lang-label"><img src="${base_url}/assets/dashboard/images/flags/${language_list[i].language.icon
                        }.svg" alt=""> <small>${language_list[i].language.title
                        }</small></span></span>  </a> </li>`;

                    popupMediaContent += ` <div class="tab-pane   ${active_tab}" id="tab_edit${i + 1
                        }"> <div class="box-body" id="media-box-body_edit_${language_list[i].language.code
                        }">    <div class="common">  <div class="form-group row"><div class="col-sm-2"> <label class="form-control-label"> Title      </label>  </div>  <div class="col-sm-10">  <input type="text" placeholder="" class="form-control" name="content_title_edit_${language_list[i].language.code
                        }"   id="content_title_edit_${language_list[i].language.code
                        }" type="text" value="" ${default_lang} >  </div>  </div> <div class="form-group row">  <div class="col-sm-2"> <label class="form-control-label">    Link   </label>  </div>  <div class="col-sm-10">  <input type="url" placeholder="" class="form-control" name="content_link_edit_${language_list[i].language.code
                        }"   id="content_link_edit_${language_list[i].language.code
                        }" type="text" value="" ${default_lang}>  </div>   </div> </div> </div>    </div>`;
                    contentMenus += ` <li class="nav-item inline"> <a class="nav-link  ${active_tab}" href="" data-toggle="tab" data-target="#tab_${i + 1
                        }">   <span class="text-md"><span class="label light text-dark lang-label"><img src="${base_url}/assets/dashboard/images/flags/${language_list[i].language.icon
                        }.svg" alt=""> <small>${language_list[i].language.title
                        }</small></span></span>  </a> </li>`;
                    langs.push(language_list[i].language.code);

                    if (i == language_list.length - 1) {
                        $("#edit_content_menus").append(languageMenu);
                        $("#media_content_edit").append(popupMediaContent);
                    }
                }

                $.ajax({
                    url: base_url + "/admin/mediapage/medialisting/get-data-per-content-id?content_id=" + content_id,
                    contentType: false,
                    processData: false,
                    type: "GET",
                    success: function (response) {
                        if (response.includes("success")) {
                            let data = JSON.parse(response);
                            const media_content = data.data;

                            $(`#modal_image_edit`).val(media_content[0].image_details.file_name);
                            $(`#modal_image_edit_preview`).attr('src', base_url + '/uploads/media/' + media_content[0].image_details.file_name != null ? media_content[0].image_details.file_name : '')
                            $('exampleModalLabel').html('Edit Content');

                            for (i = 0; i < language_list.length; i++) {
                                for (j = 0; j < media_content.length; j++) {
                                    if (language_list[i].lang_id != media_content[j].lang_id) continue;

                                    $(`#content_title_edit_${language_list[i].language.code}`).val(media_content[j].title);
                                    $(`#content_link_edit_${language_list[i].language.code}`).val(media_content[j].link);
                                    $('#content_id_edit').val(media_content[0].content_id)
                                }
                            }
                            $('#media_uid_edit').val(media_content[0].media_uid)

                        } else {
                            console.log("Content not found");
                        }
                    },
                    error: function (data) {

                    }
                });

            }
        },
    });
};

// Content delete form for deleting popup content
const content_delete = (region_id, media_uid, content_id, section_id) => {
    $(`#${section_id}_content_body`).empty();
    const content_table_id = $('#content_table_id').val();
    $.ajax({
        type: "POST",
        url: base_url + "/admin/mediapage/medialisting/content-delete",
        data: `&region_id=${region_id}&media_uid=${media_uid}&content_id=${content_id}&section_id=${section_id}&content_table_id=${content_table_id}`,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (data) {
            $("#modal_image_preview").attr(
                "src",
                base_url + `/assets/dashboard/images/image_not_found.jpg`
            );

            if (data.includes("success")) {

                const result = JSON.parse(data).data;
                $("#modal_content_delete").modal("toggle");

                let temp_html = "";
                result.forEach(function (data, idx, result) {
                    image_src =
                        data.image_details.file_name != null ?
                        base_url + `/uploads/media/${data.image_details.file_name}` :
                        base_url +
                        `/assets/dashboard/images/image_not_found.jpg`;
                    temp_html += `<tr> <td> <img src="${image_src}" height="100" width="100" alt="Image not found"></td>  <td> <span> ${data.title} </span> </td> <td> <span> ${data.link} </span> </td> <td> <span> <button type="button" class="btn btn-success btn-sm" onclick="content_edit('${data.content_id}','${section_id}')" data-toggle="modal" data-target="#media_edit_modal" > Edit </button>  <button type="button" class="btn btn-danger btn-sm"  data-region-id="${region_id}"  data-media-uid="${data.media_uid}" data-content-id="${data.content_id}" data-section-data-id="${section_id}"
                    data-title=" ${data.title}" data-toggle="modal"
                    data-target="#modal_content_delete" > Delete</button>   </span></td></tr>`;
                    if (idx === result.length - 1) {
                        $(`#${section_id}_content_body`).append(
                            temp_html
                        );
                    }
                });
            }

            $("#modal_content_delete").modal("hide");

        },
        error: function (jqXHR, textStatus, error) {
            console.log(jqXHR);
            $("#modal_content_delete").modal("hide");

        },
    });
};
