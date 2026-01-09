const submitForm = () => {
    // e.preventDefault();
    let region_id = $("#region_id").find(":selected").val();
    $("#nav_menus").empty();
    $("#tab-content").empty();
    $("#end-content").empty();

    const base_url = $("#base_url").val();

    $.ajax({
        url: `${base_url}/admin/get-language-by-country?region_id=${region_id}&type=blog`,
        contentType: false,
        processData: false,
        type: "GET",
        success: function (data) {
            if (data.includes("success")) {
                // update the form with the region selected
                $("#input_region_id").val(region_id);
                $("#content_div").css("display", "block");
                const language_list = JSON.parse(data).language_list;
                const permissions_id = JSON.parse(data).permissions_id;
                const blog_Category_array = JSON.parse(data).blog_category_array;
                var fieldHTML = ``;
                let tab_content = ``;
                let langs = [];
                let direction = (code = "");

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
                    direction = language_list[i].language.direction;
                    code = language_list[i].language.code;
                    icon = language_list[i].language.icon;
                    title = language_list[i].language.title;
                    let lang_id = language_list[i].language.id;

                    fieldHTML += ` <li class="nav-item inline">  <a class="nav-link  ${active_tab}" href="" data-toggle="tab" data-target="#tab_details${i + 1
                        }">   <span class="text-md"><span class="label light text-dark lang-label"><img src="${base_url}/assets/dashboard/images/flags/${language_list[i].language.icon
                        }.svg" alt=""> <small>${language_list[i].language.title
                        }</small></span></span>  </a> </li>`;

                    tab_content += `  <div class="tab-pane ${active_tab} " id="tab_details${i + 1
                        }"> <div class="box-body" id="box-body_${code}">    <div class="common">  <fieldset class="fieldset-design"> <legend class="fieldset-legend">Page Info :</legend>       <div class="form-group row">  <div class="col-md-2"> <label class=" form-control-label"> Page Name  </label>         </div>    <div class="col-sm-10">  <input placeholder="" class="form-control"      ${default_lang} dir="${direction}"      name="page_name_${code}" id="page_name_${code}"      type="text"      oninput="generatePageSlug(this.value,'page_slug_${code}','blog',${region_id},'draft_btn','submit_btn' )">  </div>        </div>        <div class="form-group row">  <div class="col-sm-2">  <label class=" form-control-label"> Page Slug </label>  </div>  <div class="col-sm-10">  <input placeholder="" class="form-control"      ${default_lang} dir="${direction}"      name="page_slug_${code}" id="page_slug_${code}"      type="text" disabled> <span id="page_slug_${ language_list[i].language.code }_error" ></span>   </div>        </div>        <div class="form-group row">  <div class="col-sm-2">  <label class=" form-control-label"> Meta Title </label>  </div>  <div class="col-sm-10"> <input placeholder="" class="form-control"      ${default_lang} dir="${direction}"      name="meta_title_${code}" id="meta_title_${code}"      type="text">  </div>        </div>        <div class="form-group row">  <div class="col-sm-2">  <label class=" form-control-label"> Meta Keyword </label>  </div>  <div class="col-sm-10">  <input placeholder="" class="form-control"      ${default_lang} dir="${direction}"      name="meta_keywoard_${code}"      id="meta_keywoard_${code}" type="text">  </div> </div> <div class="form-group row">     <div class="col-sm-2"> <label class=" form-control-label"> Meta      Description  </label>     </div>     <div class="col-sm-10">  <input placeholder="" class="form-control"      ${default_lang} dir="${direction}"      name="meta_description_${code}"      id="meta_description_${code}" type="text">     </div> </div> </fieldset>`;

                    tab_content += `

                    <div class="form-group row blog-category">
                        <div class="col-sm-2"> <label class=" form-control-label">
                                Blog Categories
                            </label>
                        </div>
                        <div class="col-sm-10">
                            <select multiple class="form-control blog_category "
                                id="blog_category_${code}"
                                name="blog_category_${code}[]"> `;


                    if (blog_Category_array.length > 0) {
                        blog_Category_array.forEach(element => {

                            if ((element.blog_category_content).length > 0) {
                                element.blog_category_content.forEach(blog_content => {
                                    if (blog_content.lang_id == lang_id && blog_content.title != null) {
                                        tab_content += ` <option value="${blog_content.lang_id}">
                                                ${blog_content.title}
                                            </option> `;
                                    }
                                });
                            }
                        });
                    }

                    tab_content += ` </select>
                      </div> </div>`;

                    tab_content += `<div class="card p-2 m-3">  <div class="card-header">  <h5>Content Section</h5>  </div>  <div class="container-fluid  " style="margin-top:15px">  <div class="card-body"> <div class="form-group row"> <div class="col-md-2"> <label class=" form-control-label"> Title    </label> </div> <div class="col-md-10">    <input placeholder="" class="form-control" ${default_lang} dir="${direction}" name="title_${code}" id="title_${code}" type="text"></div>      </div> <div class="form-group row"><div class="col-md-2"> <label class=" form-control-label"> Body    </label> </div> <div class="col-md-2">    <label class="switch"> <input type="checkbox" name="blog_button_toggle_${code}"  id="blog_button_toggle_${code}"  onchange="changeText('blog_button_toggle_${code}','blog_button_toggle_text_${code}')">
                     <span class="slider round"></span>    </label>    <label for="text" class="switch_inner_text" id="blog_button_toggle_text_${code}">Hide</label></div>      </div>      <div> <input id="project-html_${code}" name="body_${code}" type="hidden" /> <input id="project-data_${code}" type="hidden"
                     name="data_details_${code}" /> </div> <div id="gjs_${code}"></div>      <div class="form-group row" style=""><div class="col-12">    <label class="form-control-label"> Thumbnail Image: (230 x 140)    </label></div> <div class="row" style="margin-left:0px">    <div class="col-12"> <div style="width:80%;float:left">     <input type="text" id="thumbnail_image_${code}"  name="thumbnail_${code}" class="form-control" value=""  readonly style="margin-bottom:15px" value="">     <div class="btn btn-success mt-2 btn-sm btn-round"  id="banner" class="lib"  data-target="#showsModal" data-toggle="modal"  onclick="setModalClickBtnId(document.getElementById('thumbnail_image_${code}'));">  Select or upload Image     </div> </div> <div style="width: 18%;float:right">     <img src="${base_url}/assets/dashboard/images/image_not_found.jpg"  id="thumbnail_image_${code}_preview" height="100px"  width="auto" /> </div>  </div> </div>     </div>  </div>  </div>  </div>`;

                    tab_content +=
                        ` </div>   </div> </div> `;
                    langs.push(language_list[i].language.code);
                }

                let end_content = `<div class="form-group row mb-2"> <div class="col-md-7"> </div> <div class="col-md-5">  <button class="btn btn-primary" type="submit" name="draft" value="0" id="draft_btn"> Draft </button>  <button class="btn btn-success" type="submit" name="submit" value="${permissions_id == 3 ? '2' : '1'}" id="submit_btn"> ${permissions_id == 3 ? 'Submit' : 'Publish'} </button> </div>`;

              

                $("#nav_menus").append(fieldHTML);
                $("#tab-content").append(tab_content);
                $("#end-content").append(end_content);

                langs.forEach((item, index) => {
                    $(`#blog_category_${item}`).multiselect({
                        // CSS class of the multiselect button
                        buttonClass: 'custom-select',
                    });
                    $(`#blog_category_${item}`).multiselect({
                        buttonClass: 'custom-select',
                    });
                });


                let b = [];
                for (i = 0; i < language_list.length; i++) {
                    // for (j = 1; j < 5; j++) {
                    b["inlineStorage" + "_" + language_list[i].language.code] = (editor) => {
                        const projectDataEl = document.getElementById('project-data' + '_' + language_list[
                            i].language.code);
                        const projectHtmlEl = document.getElementById('project-html' + '_' + language_list[
                            i].language.code);

                        editor.Storage.add('inline', {
                            load() {
                                return JSON.parse(projectDataEl.value || '{}');
                            },
                            store(data) {
                                const component = editor.Pages.getSelected().getMainComponent();
                                projectDataEl.value = JSON.stringify(data);
                                projectHtmlEl.value =
                                    `<style>${editor.getCss({ component })}</style>${editor.getHtml({ component })}`;
                            }
                        });
                    };


                    var editor = grapesjs.init({
                        container: '#gjs' + '_' + language_list[i].language.code,
                        plugins: ['grapesjs-preset-webpage', 'grapesjs-plugin-forms', 'grapesjs-custom-code', 'gjs-blocks-basic', 'grapesjs-tabs', b["inlineStorage" + "_" +
                            language_list[i].language.code]],
                        storageManager: {
                            type: 'inline'
                        },
                        pluginsOpts: {
                            'grapesjs-preset-webpage': {
                                // options
                            }
                        },
                      canvas:{
                       styles:[`${base_url}/assets/dashboard/grapesjs/css/font.css`]
                      },
                    });
                    const prop = editor.StyleManager.getProperty('typography', 'font-family');
                                            prop.addOption({value: `avenir, avenir`, name: 'Avenir'});
                    editor.RichTextEditor.add('hyperlink',
                                            {
                                                icon: '&#128279;',
                                                attributes: {title: 'Hyperlink'},
                                                result: rte =>
                                                {
                                                    var component = editor.getSelected();
                                                    
                                                    if(component.is('link'))
                                                    {
                                                        component.replaceWith(`${component.get('content')}`);
                                                    }
                                                    else
                                                    {
                                                        var range = rte.selection().getRangeAt(0);
                                                        
                                                        var container = range.commonAncestorContainer;
                                                        if (container.nodeType == 3)
                                                            container = container.parentNode;
                                                        
                                                        if(container.nodeName === "A")
                                                        {
                                                            var sel = rte.selection();
                                                            sel.removeAllRanges();
                                                            range = document.createRange();
                                                            range.selectNodeContents(container);
                                                            sel.addRange(range);
                                                            rte.exec('unlink');
                                                        }
                                                        else
                                                        {
                                                            var url = window.prompt('Enter the URL to link to:');
                                                            if (url)
                                                                rte.insertHTML(`<a class="link" href="${url}">${rte.selection()}</a>`);
                                                        }
                                                    }
                                                }
                                            });
                                            editor.RichTextEditor.add('indent',
                                            {
                                            icon: '&#8594;',
                                            attributes: {title: 'Indent'},
                                            result: rte => rte.exec('indent')
                                            });

                                            editor.RichTextEditor.add('outdent',
                                            {
                                            icon: '&#8592;',
                                            attributes: {title: 'Outdent'},
                                            result: rte => rte.exec('outdent')
                                            });

                                            editor.RichTextEditor.add('orderedList',
                                            {
                                            icon: '1.',
                                            attributes: {title: 'Ordered List'},
                                            result: rte => rte.exec('insertOrderedList')
                                            });

                                            editor.RichTextEditor.add('unorderedList',
                                            { 
                                            icon: '&#8226;',
                                            attributes: {title: 'Unordered List'},
                                            result: rte => rte.exec('insertUnorderedList')
                                            });
                }
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

const add_new_section = (section_id, language_code, direction_write) => {
    var ele = document.querySelectorAll(`#${section_id} textarea`);
    let last_element = ele[ele.length - 1].name;
    let next_element =
        last_element.substr(0, 24) +
        (Number(last_element.substr(24, last_element.length - 27)) + 1) +
        last_element.substr(last_element.length - 3, last_element.length);

    let div_content_ids =
        Number(last_element.substr(24, last_element.length - 27)) + 1;
    let section_no = section_id.substr(8, 1);
    let section_prefix = section_id.substr(0, 10);

    $(`#${section_id}`).append(
        `<div class="form-group row" id="${next_element}_div"> <label class="col-sm-2 form-control-label">Section - ${section_no} Desc - ${div_content_ids}  </label>  <div class="col-sm-8 ">  <textarea class="form-control"  dir="${direction_write}" name="${next_element}" id="${next_element}"> </textarea>  </div>  <div class="col-sm-2"> <button class="btn btn-danger" onclick="delete_section('${next_element}_div')" >  Delete </button> </div> </div> `
    );
};
