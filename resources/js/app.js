require('bootstrap');
require('particles.js');
window.$ = require( 'jquery' );



$(function () {

    try {
        if($('#particles-js').length) {
            // setTimeout(() => {
            //     $('.loader-wrapper').addClass('disappear');
            // }, 500);
            particlesJS.load('particles-js', '/plugins/particles/particles.min.json');
        }
    } catch (error) {

    }
});
