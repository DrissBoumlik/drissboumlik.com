import { getCookie } from "@/shared/functions";
import { string_to_slug } from "@/admin/utilitiy";

function initPostEditor() {
    if (! document.getElementById('post-content')) return;
    let options = {
        selector: 'textarea#post-content',
        plugins: `searchreplace autolink visualblocks visualchars media charmap nonbreaking anchor insertdatetime
                lists advlist wordcount help emoticons autosave code link table codesample image preview pagebreak
                accordion`,
        toolbar: `code codesample emoticons link image pagebreak | undo redo restoredraft | bold italic underline
                | alignleft aligncenter alignright alignjustify lineheight indent outdent | bullist numlist
                | accordion visualblocks visualchars searchreplace`,
        pagebreak_separator: '<hr/>',
        height: 700,
        fixed_toolbar_container: '.tox-editor-header',
        codesample_languages: [
            { text: 'Bash', value: 'bash' },
            { text: 'Typscript', value: 'typscript' },
            { text: 'Markdown', value: 'markdown' },
            { text: 'Pug', value: 'pug' },
            { text: 'Sass', value: 'sass' },
            { text: 'Yaml', value: 'yaml' },
            { text: 'SQL', value: 'sql' },
            { text: 'Powershell', value: 'powershell' },
            { text: 'DOS', value: 'dos' },
            { text: 'Batch', value: 'batch' },
            { text: 'HTML/XML', value: 'markup' },
            { text: 'CSS', value: 'css' },
            { text: 'JavaScript', value: 'javascript' },
            { text: 'PHP', value: 'php' },
            { text: 'Ruby', value: 'ruby' },
            { text: 'Python', value: 'python' },
            { text: 'Java', value: 'java' },
            { text: 'C', value: 'c' },
            { text: 'C#', value: 'csharp' },
            { text: 'C++', value: 'cpp' }
        ],
    };
    let theme = getCookie('theme');
    if (theme === 'dark-mode') {
        options = {...options,  skin: 'oxide-dark', content_css: 'dark'};
    }
    let tinymceDOM = tinymce.get('post-content');
    if(tinymceDOM != null) {
        let _content = tinymceDOM.getContent();
        tinymceDOM.destroy();
        tinymceDOM.setContent(_content);
    }
    tinymce.init(options);
}

function initCommonFormInputEvents() {
    ['input', 'focusout'].forEach((eventName) => {
        document.addEventListener(eventName, function (event) {
            if (event.target.classList.contains('input-to-slugify')) {
                let postTitle = event.target.value;
                let postSlug = string_to_slug(postTitle);
                document.querySelectorAll('.input-slug').forEach(input => {
                    input.value = postSlug;
                });
            }
        });
    });
}

export { initPostEditor, initCommonFormInputEvents };
