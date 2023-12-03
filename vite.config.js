import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/sass/app.sass',
                'resources/sass/externals.sass',
                'resources/template/sass/main.scss',
                'resources/template/sass/oneui/themes/amethyst.scss',
                'resources/template/sass/oneui/themes/city.scss',
                'resources/template/sass/oneui/themes/flat.scss',
                'resources/template/sass/oneui/themes/modern.scss',
                'resources/template/sass/oneui/themes/smooth.scss',
                'resources/js/admin/app.js',
                'resources/js/app.js',
                'resources/js/pages/code-animation.js',
                'resources/js/pages/contact.js',
                'resources/template/js/oneui/app.js',
                'resources/template/js/pages/datatables.js',
                'resources/template/js/pages/slick.js',
            ],
            refresh: true,
        }),
    ],
});
