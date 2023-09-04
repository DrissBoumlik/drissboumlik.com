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
    // .js('resources/template/js/oneui/app.js', 'public/template/js/oneui')
    // .js('resources/template/js/pages/datatables.js', 'public/template/js/pages')
    // .js('resources/template/js/pages/slick.js', 'public/template/js/pages')
    .js('resources/js/app.js', 'public/js')
    .sass('resources/template/sass/main.scss', 'public/template/css')
    // .sass('resources/template/sass/oneui/themes/amethyst.scss', 'public/template/css/themes')
    // .sass('resources/template/sass/oneui/themes/city.scss', 'public/template/css/themes')
    // .sass('resources/template/sass/oneui/themes/flat.scss', 'public/template/css/themes')
    // .sass('resources/template/sass/oneui/themes/modern.scss', 'public/template/css/themes')
    // .sass('resources/template/sass/oneui/themes/smooth.scss', 'public/template/css/themes')

    .sass('resources/sass/externals.sass', 'public/css')
    .sass('resources/sass/app.sass', 'public/css')
    //// .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
    // .copy('resources/plugins', 'public/plugins')
    // .copy('resources/template/assets/fonts', 'public/template/assets/fonts')
    // .copy('resources/template/assets/fonts', 'public/template/fonts')
    // .copy('resources/template/assets/js', 'public/template/assets/js')
    // .copy('resources/template/assets/media', 'public/template/assets/media')
    // .copy('resources/template/assets/css', 'public/template/assets/css')
    
    .copyDirectory('vendor/tinymce/tinymce', 'public/js/tinymce')
    
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
