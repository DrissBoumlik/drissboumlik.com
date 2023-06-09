const mix = require('laravel-mix');
require('laravel-mix-purgecss');
path = require('path');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .js('resources/js/oneui/app.js', 'public/js/oneui')
    .js('resources/js/pages/datatables.js', 'public/js/pages')
    .js('resources/js/pages/slick.js', 'public/js/pages')
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/_template/main.scss', 'public/css')
    .sass('resources/sass/_template/oneui/themes/amethyst.scss', 'public/css')
    .sass('resources/sass/_template/oneui/themes/city.scss', 'public/css')
    .sass('resources/sass/_template/oneui/themes/flat.scss', 'public/css')
    .sass('resources/sass/_template/oneui/themes/modern.scss', 'public/css')
    .sass('resources/sass/_template/oneui/themes/smooth.scss', 'public/css')
    .sass('resources/sass/externals.sass', 'public/css')
    .sass('resources/sass/app.sass', 'public/css')
    .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
    .copy('resources/assets', 'public/assets')
    .copy('resources/plugins', 'public/plugins')
    .copy('resources/fonts', 'public/fonts')
    .purgeCss({
        extend: {
            content: [path.join(__dirname, 'database/data/**/*.json'),
                        path.join(__dirname, 'resources/js/**/*.js'),
                        path.join(__dirname, 'node_modules/owl.carousel/dist/owl.carousel.min.js'),
                        ],
        },
    })

    // .postCss('resources/css/app.css', 'public/css', [
    //     //
    // ])

    .sourceMaps(true, 'source-map')

    .autoload({ jquery: ['$', 'window.jQuery', 'jQuery'] })
    /* Tools */
    .browserSync('localhost:8000')
    .disableNotifications()
    /* Options */
    .options({
        processCssUrls: false
    });

if (mix.inProduction()) {
    mix.version();
}
