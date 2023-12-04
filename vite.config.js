import { defineConfig } from 'vite';
import { viteStaticCopy } from 'vite-plugin-static-copy'
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        viteStaticCopy({
            targets: [
                { src: 'resources/plugins/chartjs/*', dest: 'public/plugins/chartjs' },
                { src: 'resources/plugins/jquery/*', dest: 'public/plugins/jquery' },
                { src: 'resources/plugins/moment-js/*', dest: 'public/plugins/moment-js' },
                { src: 'resources/plugins/particles/*', dest: 'public/plugins/particles' },
                { src: 'resources/plugins/prismjs/*', dest: 'public/plugins/prismjs' },
            ]
        }),
        laravel({
            input: [
                'resources/sass/app.sass',
                'resources/sass/externals.sass',
                'resources/template/sass/main.scss',
                'resources/js/admin/app.js',
                'resources/js/app.js',
                'resources/js/pages/code-animation.js',
                'resources/js/pages/contact.js',
                'resources/plugins/prismjs/prism-tomorrow-night.css',
                'resources/plugins/prismjs/prism-tomorrow-night.js',
                'resources/plugins/particles/particles.js',
                'node_modules/owl.carousel/dist/owl.carousel.min.js',
                'resources/plugins/tinymce/tinymce.min.js',
                'resources/template/assets/js/oneui.app.min.js',
            ],
            refresh: true,
        }),
    ],
});
