import {initPostEditor} from "../shared/plugins-use";


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
    if (element.hasClass(classes.lightmode)) {
        element.addClass(classes.darkmode).removeClass(classes.lightmode);
        setCookie(cookieData.name, cookieData.darkmodeValue);
    } else {
        element.removeClass(classes.darkmode).addClass(classes.lightmode);
        setCookie(cookieData.name, cookieData.lightmodeValue);
    }
    initPostEditor();
}

function get_loader() {
    let loader = $('.spinner-global');
    if (loader.length) {
        loader.remove();
    }
    loader = `<div class="spinner-global spinner-border" role="status"
                                style="width: 3rem; height: 3rem; position: fixed; bottom: 1rem; right: 1rem;
                                border-color: var(--tc-grey-dark) transparent var(--tc-grey-dark) var(--tc-grey-dark);" >
                            <span class="visually-hidden">Loading...</span>
                        </div>`;
    $(document.body).append(loader)
}
function get_alert_box(params, removeLoader = true) {
    if (removeLoader) {
        let loader = $('.spinner-border');
        if (loader.length) {
            loader.remove();
        }
    }
    let alertElement = $('.alert.alert-dismissible');
    if (alertElement.length) {
        alertElement.remove();
    }
    let alert_element = `
        <div data-notify="container" class="col-11 col-sm-4 alert ${params.class} alert-dismissible animated fadeIn" role="alert" data-notify-position="bottom-right"
            style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1060; bottom: 20px; right: 20px; animation-iteration-count: 1;">
            <p class="mb-0">
                <span data-notify="icon">${params.icon}</span>
                <span data-notify="title"></span>
                <span data-notify="message">${params.message}</span>
            </p>
            <a class="p-2 m-1 text-dark" href="javascript:void(0)" aria-label="Close" data-notify="dismiss" style="position: absolute; right: 10px; top: 5px; z-index: 1035;">
                <i class="fa fa-times"></i>
            </a>
        </div>
    `;
    $(document.body).append(alert_element);
    $('.alert.alert-dismissible').on('click', function() { $(this).remove() });
}


export { toggleDarkMode, get_alert_box, getCookie, get_loader };
