// import 'bootstrap';
import { toggleDarkMode } from "../shared/functions";
import { initSelect2 } from "../shared/plugins-use";

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

    });
}

function initEvents() {
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    $('.btn-export').on('click', function() {
        let tablesNames = null;
        if (!$('#export-all-tables').prop('checked')) {
            tablesNames = '';
            document.querySelectorAll('#tables .table-item').forEach(function (e) {
                if (e.checked) {
                    tablesNames += e.closest('tr').querySelector('.table-name').innerText + ' ';
                }
            });
            tablesNames = tablesNames.trim();
        }
        let dontCreateTables = $('#do-not-create-tables').prop('checked');
        let queryString = `
            ${tablesNames ? 'tables=' + tablesNames : ''}
            &
            ${dontCreateTables ? 'dontCreateTables=1' : ''}
        `;
        console.log(queryString.trim());
        window.open('/admin/export-db?' + queryString);
    });

    One.helpersOnLoad('js-flatpickr');


    $(document).on('focusout', '.input-to-slugify', function () {
        let postTitle = $(this).val();
        let postSlug = string_to_slug(postTitle)
        // let postSlug = slugify(postTitle, {
        //     // replacement: '-',  // replace spaces with replacement character, defaults to `-`
        //     // remove: undefined, // remove characters that match regex, defaults to `undefined`
        //     lower: true,      // convert to lower case, defaults to `false`
        //     strict: true,     // strip special characters except replacement, defaults to `false`
        //     // locale: 'vi',      // language code of the locale to use
        //     trim: true         // trim leading and trailing replacement chars, defaults to `true`
        // });
        $('.input-slug').val(postSlug);
    });

    let imageElement = document.getElementById('image')
    if (imageElement) {
        imageElement.onchange = (event) => {
            if (event.target.files.length > 0) {
                let src = URL.createObjectURL(event.target.files[0]);
                let preview = document.getElementById("image-preview");
                preview.src = src;

                // initImageCropper();
            }
        };
    }

    let show_password_btn = $('.show-password');
    if (show_password_btn.length) {
        show_password_btn.on('click', function() {
            let input_password = $(this).siblings('input');
            let type = input_password.attr('type') === 'text' ? 'password' : 'text';
            input_password.attr('type', type);
        });
    }

}

function shortenTextIfLongByLength(text, length, end = '...'){
    return text.length < length ? text : text.substring(0, length) + end;
}

function getDomClass(status) {
    let classes = [
        {'value' : 0, 'class' : 'bg-gray text-gray-dark', 'text' : 'Draft'},
        {'value' : 1, 'class' : 'bg-warning-light text-warning', 'text' : 'Pending'},
        {'value' : 2, 'class' : 'bg-success-light text-success', 'text' : 'Published'},
    ]
    return classes[status];
}

export { initDarkMode, initEvents, shortenTextIfLongByLength, getDomClass };
