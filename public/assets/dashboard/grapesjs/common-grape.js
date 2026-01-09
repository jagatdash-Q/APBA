function grapejsInitialize(data, html, graph_js) {
    // Do something with the parameters
    var b = {};
    b["inlineStorage"] = (editor) => {
        const projectDataEl = document.getElementById(data);
        const projectHtmlEl = document.getElementById(html);
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
        container: '#' + graph_js,
        plugins: ['grapesjs-preset-webpage', 'grapesjs-plugin-forms', 'grapesjs-custom-code',
            'gjs-blocks-basic', 'grapesjs-tabs', b["inlineStorage"],'customTable'
        ],
        storageManager: {
            type: 'inline'
        },
        pluginsOpts: {
            'grapesjs-preset-webpage': {
                // options
            }
        },
        canvas: {
            styles: [base_url + 'assets/dashboard/grapesjs/css/font.css']
        },
    });
    const prop = editor.StyleManager.getProperty('typography', 'font-family');
    prop.addOption({
        value: `Montserrat, sans-serif`,
        name: 'Montserrat'
    });
    prop.set('default', `Montserrat, sans-serif`);
    editor.RichTextEditor.add('hyperlink', {
        icon: '&#128279;',
        attributes: {
            title: 'Hyperlink'
        },
        result: rte => {
            var component = editor.getSelected();
            if (component.is('link')) {
                component.replaceWith(`${component.get('content')}`);
            } else {
                var range = rte.selection().getRangeAt(0);
                var container = range.commonAncestorContainer;
                if (container.nodeType == 3)
                    container = container.parentNode;
                if (container.nodeName === "A") {
                    var sel = rte.selection();
                    sel.removeAllRanges();
                    range = document.createRange();
                    range.selectNodeContents(container);
                    sel.addRange(range);
                    rte.exec('unlink');
                } else {
                    var url = window.prompt('Enter the URL to link to:');
                    if (url)
                        rte.insertHTML(
                            `<a class="link" href="${url}">${rte.selection()}</a>`);
                }
            }
        }
    });
    editor.RichTextEditor.add('indent', {
        icon: '&#8594;',
        attributes: {
            title: 'Indent'
        },
        result: rte => rte.exec('indent')
    });
    editor.RichTextEditor.add('outdent', {
        icon: '&#8592;',
        attributes: {
            title: 'Outdent'
        },
        result: rte => rte.exec('outdent')
    });
    editor.RichTextEditor.add('orderedList', {
        icon: '1.',
        attributes: {
            title: 'Ordered List'
        },
        result: rte => rte.exec('insertOrderedList')
    });
    editor.RichTextEditor.add('unorderedList', {
        icon: '&#8226;',
        attributes: {
            title: 'Unordered List'
        },
        result: rte => rte.exec('insertUnorderedList')
    });
}