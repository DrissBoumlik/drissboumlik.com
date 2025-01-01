// import 'bootstrap';
import { toggleDarkMode } from "@/shared/functions";
import { get_loader, remove_loader } from "@/admin/tools";
import { initPostEditor } from "@/admin/pages/blog/helpers";

function initDarkMode() {
    document.querySelectorAll('.toggle-dark-mode-admin')
        .forEach(function(darkModeBtn) {
            darkModeBtn.addEventListener('click', function (event) {
                toggleDarkMode(
                    document.getElementById('page-container'),
                    { darkmode: 'page-header-dark dark-mode sidebar-dark', lightmode: 'light-mode' },
                    { name: 'theme', darkmodeValue: 'dark-mode', lightmodeValue: 'light-mode' }
                );

                initPostEditor();
            });
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
        remove_loader();
    });
}





export { initDarkMode, initAjaxEvents };
