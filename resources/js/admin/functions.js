// import 'bootstrap';
import { get_loader, toggleDarkMode } from "../shared/functions";
import { initPostEditor } from "../admin/pages/post";

function string_to_slug(str) {
    str = str.replace(/^\s+|\s+$/g, ''); // trim
    str = str.toLowerCase();

    // remove accents, swap ñ for n, etc
    var from = "åàáãäâèéëêìíïîòóöôùúüûñç·/_,:;";
    var to = "aaaaaaeeeeiiiioooouuuunc------";

    for (var i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    str = str
        .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
        .replace(/\s+/g, '-') // collapse whitespace and replace by -
        .replace(/-+/g, '-') // collapse dashes
        .replace(/^-+/g, '') // trim - from start of text
        .replace(/-+$/g, ''); // trim - from end of text

    return str;
}

function initDarkMode() {
    $(document).on('click', '.toggle-dark-mode-admin', function () {
        toggleDarkMode($('#page-container'),
            {darkmode: 'page-header-dark dark-mode sidebar-dark', lightmode: 'light-mode'},
            {name: 'theme', darkmodeValue: 'dark-mode', lightmodeValue: 'light-mode'});

        initPostEditor();
    });
}

function initAjaxEvents() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    $( document ).on( "ajaxSend", function(event, jqxhr, settings) {
        if (settings.url.startsWith('/api')) {
            get_loader();
        }
    });
    $( document ).on( "ajaxComplete", function(event, jqxhr, settings) {
        let loader = $('.spinner-global');
        if (loader.length) {
            loader.remove();
        }
    });
}

function shortenTextIfLongByLength(text, length, end = '...'){
    return text.length < length ? text : text.substring(0, length) + end;
}

function getDomClass(status) {
    let classes = {
        0: {'value' : 0, 'class' : 'bg-gray text-gray-dark', 'text' : 'Draft'},
        1: {'value' : 1, 'class' : 'bg-success-light text-success', 'text' : 'Published'},
    }
    return classes[status];
}


export { initDarkMode, initAjaxEvents, shortenTextIfLongByLength, getDomClass, string_to_slug };
