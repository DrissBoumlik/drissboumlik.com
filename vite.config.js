import { defineConfig } from 'vite';
import { viteStaticCopy } from 'vite-plugin-static-copy'
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        viteStaticCopy({
            targets: [
                { src: 'resources/plugins/chartjs/*', dest: '../plugins/chartjs' },
                { src: 'resources/plugins/jquery/*', dest: '../plugins/jquery' },
                { src: 'resources/plugins/moment-js/*', dest: '../plugins/moment-js' },
                { src: 'resources/plugins/particles/*', dest: '../plugins/particles' },
                { src: 'resources/plugins/prismjs/*', dest: '../plugins/prismjs' },
                { src: 'resources/plugins/tinymce/*', dest: '../plugins/tinymce' },
                { src: 'resources/assets/fontawesome/webfonts/*', dest: 'webfonts' },
            ]
        }),
        laravel({
            input: [
                'resources/sass/app.sass',
                'resources/sass/externals.sass',
                'resources/sass/admin/app.sass',
                'resources/template/sass/main.scss',
                'resources/js/admin/app.js',
                'resources/js/app.js',
                'resources/js/pages/code-animation.js',
                'resources/js/pages/contact.js',
                'resources/template/assets/js/oneui.app.min.js',
            ],
            refresh: true,
        }),
    ],
});
