
let b=[];
const add_new_section = (
    section_id,
    language_code,
    direction_write,
    default_lang,
    parent_div_id
) => {
    // const base_url = $('#base_url').val();

    let div_id = section_id.substr(8, section_id.length - 11);
    let next_div_element = getCookie(section_id);
    let next_element = "";
    if (next_div_element == undefined) {
        next_element = Number(section_id.substr(8, section_id.length - 11)) + 1;
        next_div_element =
            section_id.substr(0, 8) +
            next_element +
            section_id.substr(section_id.length - 3, 3);
        setCookie(section_id, next_div_element, 0.3);
    } else if (next_div_element != undefined && next_div_element != div_id) {
        next_div_element = getCookie(section_id);
        next_element =
            Number(next_div_element.substr(8, next_div_element.length - 11)) +
            1;


        let next_div =
            next_div_element.substr(0, 8) +
            next_element +
            next_div_element.substr(section_id.length - 3, 3);
        setCookie(section_id, next_div, 0.3);
    }

    if (next_div_element != undefined && next_div_element > div_id) {}

    let image_id = document.getElementById(
        `section_${next_element}_image_${language_code}`
    );
    $(`#${parent_div_id}`).append(
        `<div  id="section_${next_element}_${language_code}" > <hr>  <div class="row" style="margin-bottom:10px"> <div class="col-md-10"> <span> Section ${next_element} </span> </div> <div class="col-md-2"> <button type="button" class="btn btn-danger btn-sm" data-section-id="section_${next_element}_${language_code}"       data-toggle="modal" data-target="#modal_section_delete" >  Delete Section </button> </div>  </div>  <div class="form-group row"> <div class="col-md-2" > <label class=" form-control-label">Title (H2) </label>  </div>  <div class="col-md-10">  <input placeholder="" class="form-control" ${default_lang}   dir="${direction_write}" name="section_${next_element}_title_${language_code}" id="section_${next_element}_title_${language_code}" type="text" value="">  </div> </div> <div ><div class="form-group row"> <div class="col-md-2" > <label class=" form-control-label">Image <br> <b>(580px x 420px) </b> </label>   </div> <div class="col-md-10">  <div class="row" style="margin-left:0px"> <div style="width:80%;float:left">     <input type="text"  id="section_${next_element}_image_${language_code}" name="section_${next_element}_image_${language_code}" class="form-control" readonly style="margin-bottom:15px">     <div class="btn btn-success mt-2 btn-sm btn-round" id="banner" class="lib" data-target="#showsModal" data-toggle="modal" onclick="setModalClickBtnId(document.getElementById('section_${next_element}_image_${language_code}'))" >Select or upload Image     </div> </div> <div style="width: 18%;float:right">  <img src="${base_url}/assets/dashboard/images/image_not_found.jpg" id="section_${next_element}_image_${language_code}_preview" height="100px" width="auto" /> </div> </div>  </div> </div> <div class="form-group row"> <div class="col-md-2" > <label class=" form-control-label">  Body </label>   </div>  <div class="col-md-10"> <input id="project-html${next_element}_${language_code}" name="section_${next_element}_body_${language_code}"  type="hidden"/>
            <input id="project-data${next_element}_${language_code}" type="hidden" name="data_details${next_element}_${language_code}" value='{"pages": [{"component": "<div>Insert your  content here</div>"}]}'/>   </div> </div> <div id="gjs${next_element}_${language_code}"></div> </div> </div>  `
    );

    // var b = [];

         b["inlineStorage"+next_element+"_" + language_code] = (editor) => {
            const projectDataEl = document.getElementById('project-data'+next_element+'_'+language_code);
            const projectHtmlEl = document.getElementById('project-html'+next_element+'_'+language_code);

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
            container : '#gjs'+next_element+'_'+language_code,
            plugins: ['grapesjs-preset-webpage','grapesjs-plugin-forms','grapesjs-custom-code','gjs-blocks-basic','grapesjs-tabs',b["inlineStorage"+next_element+"_" + language_code]],
            storageManager: { type: 'inline' },
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

};
