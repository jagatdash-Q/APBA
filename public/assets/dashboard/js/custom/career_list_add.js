const submitForm = () => {
    // e.preventDefault();
    let region_id = $('#region_id').find(":selected").val();
    $("#nav_menus").empty();
    $('#tab-content').empty();
    const base_url = $('#base_url').val();


    $.ajax({
        url: `${base_url}/admin/get-language-by-country?region_id=${region_id}`,
        contentType: false,
        processData: false,
        type: 'GET',
        success: function (data) {
            if (data.includes('success')) {
                // update the form with the region selected
                $('#input_region_id').val(region_id);
                $('#content_div').css("display", 'block');
                const language_list = JSON.parse(data).language_list;
                const permissions_id = JSON.parse(data).permissions_id;
                var fieldHTML = ``;
                let tab_content = ``;
                let langs = [];

                for (i = 0; i < language_list.length; i++) {
                    let default_lang = language_list[i].language.id == language_list[i].region
                        .default_lang ? 'required' : '';
                    let active_tab = language_list[i].language.id == language_list[i].region
                        .default_lang ? 'active' : '';

                    fieldHTML +=
                        ` <li class="nav-item inline">
            <a class="nav-link  ${active_tab}" href="" data-toggle="tab" data-target="#tab_details${i+1}">   <span class="text-md"><span class="label light text-dark lang-label"><img src="${base_url}/assets/dashboard/images/flags/${language_list[i].language.icon}.svg" alt=""> <small>${language_list[i].language.title}</small></span></span>  </a> </li>`;

                    tab_content += ` <div class="tab-pane  ${active_tab}" id="tab_details${i+1}">
                    
                    <fieldset class="fieldset-design">
                                <legend class="fieldset-legend">Page Info :</legend>
                                <div class="form-group row">
                                    <div class="col-md-2"> <label class=" form-control-label"> Page Name
                                        </label>

                                    </div>

                                    <div class="col-sm-10">
                                        <input placeholder="" class="form-control"
                                           ${default_lang} dir="${language_list[i].language.direction}"
                                            name="page_name_${language_list[i].language.code}"
                                            id="page_name_${language_list[i].language.code}" type="text"
                                            oninput="generatePageSlug(this.value,'page_slug_${language_list[i].language.code}','career_listing',${region_id},'draft_btn','submit_btn' )">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Page Slug </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input placeholder="" class="form-control"
                                           ${default_lang} dir="${language_list[i].language.direction}"
                                            name="page_slug_${language_list[i].language.code}"
                                            id="page_slug_${language_list[i].language.code}" type="text" disabled>

                                            <span id="page_slug_${ language_list[i].language.code }_error" > </span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Meta Title </label>
                                    </div>
                                    <div class="col-sm-10"> <input placeholder="" class="form-control"
                                           ${default_lang} dir="${language_list[i].language.direction}"
                                            name="meta_title_${language_list[i].language.code}"
                                            id="meta_title_${language_list[i].language.code}" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2">
                                        <label class=" form-control-label"> Meta Keyword </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input placeholder="" class="form-control"
                                           ${default_lang} dir="${language_list[i].language.direction}"
                                            name="meta_keywoard_${language_list[i].language.code}"
                                            id="meta_keywoard_${language_list[i].language.code}" type="text">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-2"> <label class=" form-control-label"> Meta
                                            Description
                                        </label>
                                    </div>
                                    <div class="col-sm-10">
                                        <input placeholder="" class="form-control"
                                           ${default_lang} dir="${language_list[i].language.direction}"
                                            name="meta_description_${language_list[i].language.code}"
                                            id="meta_description_${language_list[i].language.code}" type="text">
                                    </div>
                                </div>
                            </fieldset> <fieldset class="fieldset-design">
                            <legend class="fieldset-legend">Page Title :</legend>  <div class="box-body"> <div class="form-group row"> <label class="col-sm-2 form-control-label">Title (H3)</label>  <div class="col-sm-10">  <input placeholder="" class="form-control" ${default_lang}   dir="${language_list[i].language.direction}" name="title_${language_list[i].language.code}" id="title_${language_list[i].language.code}" type="text" value="">  </div> </div><div class="form-group row"> <label class="col-sm-2 form-control-label">
                            Excerpt </label><div class="col-sm-10"><textarea placeholder="" class="form-control ckEditor"  name="excerpt_desc_${language_list[i].language.code}" id="excerpt_desc_${language_list[i].language.code}" rows="4"></textarea> </div></div></div> </fieldset>  <fieldset class="fieldset-design">
                            <legend class="fieldset-legend">Career Content :</legend>  <div id="section_1_${language_list[i].language.code}"><div class="form-group row"> <div class="col-sm-10 ">  <input id="project-html1_${language_list[i].language.code}" name="section_1_job_desc_body_${language_list[i].language.code}"  type="hidden"/>
                            <input id="project-data1_${language_list[i].language.code}" type="hidden" name="data_details1_${language_list[i].language.code}" value='{"pages": [{"component": "<div>Insert your ${language_list[i].language.title} content here</div>"}]}'/>    </div> </div><div id="gjs1_${language_list[i].language.code}"></div> </div> </fieldset>`;


                    langs.push(language_list[i].language.code);

                    tab_content +=
                        `  </div> </div>  </div>`;
                }

                tab_content +=
                    ` <div class="form-group row end-content" style="margin-top: 20px;padding-bottom: 5px; "
               >
                <div class="col-md-8">
                </div>
                <div class="col-md-4">
                <button type="submit" class="btn btn-primary" formaction="${base_url+'/admin/draft-preview'}" id="preview_btn" ><i class="material-icons">  &#xe31b;</i> Preview</button>

                    <button class="btn btn-primary " type="submit" name="submit" value="0" id="draft_btn">
                        Draft </button>`;
                if (permissions_id == 3)
                    tab_content +=
                    ` <button class="btn btn-success" type="submit" name="submit" value="2" id="submit_btn"> Submit
                        </button> `;

                if (permissions_id != 3)
                    tab_content +=
                    `       
                        <button class="btn btn-success" type="submit" name="submit" value="1" id="submit_btn"> Publish
                        </button>
                    
                </div>
            </div>`;

                $('#nav_menus').append(fieldHTML);
                $('#tab-content').append(tab_content);

                // console.log(language_ids);
                var b = {};

                langs.forEach((item, index) => {
                    b["inlineStorage1" + "_" + item] = (editor) => {
                        const projectDataEl = document.getElementById('project-data1_' + item);
                        const projectHtmlEl = document.getElementById('project-html1_' + item);

                        editor.Storage.add('inline', {
                            load() {
                                return JSON.parse(projectDataEl.value || '{}');
                            },
                            store(data) {
                                const component = editor.Pages.getSelected().getMainComponent();
                                projectDataEl.value = JSON.stringify(data);
                                projectHtmlEl.value = `<style>${editor.getCss({ component })}</style>${editor.getHtml({ component })}`;
                            }
                        });
                    };


                    var editor = grapesjs.init({
                        container: '#gjs1_' + item,
                        plugins: ['grapesjs-preset-webpage', 'grapesjs-plugin-forms', 'grapesjs-custom-code', 'gjs-blocks-basic', 'grapesjs-tabs', b["inlineStorage1_" + item]],
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
                });
                $('.ckEditor').each(function () {
                    CKEDITOR.replace($(this).prop('id'));
                    });
            }
            if (data.includes('error')) {
                alert("error");
            }
        },
        error: function (data) {
            console.log(data);
        }

    });
}
