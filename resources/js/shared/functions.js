

function setCookie(name, value) {
    var d = new Date();
    d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
function toggleDarkMode(element, classes, cookieData) {
    if (element.classList.contains(classes.lightmode)) {
        element.classList.add(...classes.darkmode.split(' '));
        element.classList.remove(...classes.lightmode.split(' '));
        setCookie(cookieData.name, cookieData.darkmodeValue);
    } else {
        element.classList.remove(...classes.darkmode.split(' '));
        element.classList.add(...classes.lightmode.split(' '));
        setCookie(cookieData.name, cookieData.lightmodeValue);
    }
}

function remove_loader() {
    const loader = document.querySelector('.spinner-global');
    if (loader) {
        loader.remove();
    }
}

function get_loader() {
    remove_loader();

    const loader = `<div class="spinner-global spinner-border" role="status"
                                style="width: 3rem; height: 3rem; position: fixed; bottom: 1rem; right: 1rem;
                                border-color: var(--tc-grey-dark) transparent var(--tc-grey-dark) var(--tc-grey-dark);">
                            <span class="visually-hidden">Loading...</span>
                        </div>`;

    document.body.insertAdjacentHTML('beforeend', loader);
}
function get_alert_box(params, removeLoader = true) {
    if (removeLoader) {
        let loader = document.querySelector('.spinner-border');
        if (loader) {
            loader.remove();
        }
    }

    let alertElement = document.querySelector('.alert.alert-dismissible');
    if (alertElement) {
        alertElement.remove();
    }

    let alertElementHTML = `
        <div data-notify="container" class="col-11 col-sm-8 col-md-5 col-lg-4 alert ${params.class}
            alert-dismissible animated fadeIn" role="alert" data-notify-position="bottom-right"
            style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1060; bottom: 20px; right: 20px; animation-iteration-count: 1;">
            <p class="mb-0">
                <span data-notify="icon">${params.icon}</span>
                <span data-notify="title"></span>
                <span data-notify="message">${params.message}</span>
            </p>
            <a class="p-2 m-1 text-dark" href="javascript:void(0)" aria-label="Close" data-notify="dismiss"
                data-bs-dismiss="alert"
                style="position: absolute; right: 10px; top: 5px; z-index: 1035;">
                <i class="fa fa-times"></i>
            </a>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', alertElementHTML);

}

function initPostEditor() {
    if (! document.getElementById('post_body')) return;
    let options = {
        selector: 'textarea#post_body',
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
    let tinymceDOM = tinymce.get('post_body');
    if(tinymceDOM != null) {
        let _content = tinymceDOM.getContent();
        tinymceDOM.destroy();
        tinymceDOM.setContent(_content);
    }
    tinymce.init(options);
}

export { toggleDarkMode, get_alert_box, getCookie, get_loader, remove_loader, initPostEditor };
