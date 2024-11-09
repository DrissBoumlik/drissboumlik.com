import { defineConfig } from 'vite';
import { viteStaticCopy } from 'vite-plugin-static-copy'
import laravel from 'laravel-vite-plugin';
import purge from '@erbelion/vite-plugin-laravel-purgecss'

export default defineConfig({
    css: {
        devSourcemap: true
    },
    plugins: [
        viteStaticCopy({
            targets: [
                { src: 'resources/plugins/chartjs/*', dest: '../plugins/chartjs' },
                { src: 'resources/plugins/jquery/*', dest: '../plugins/jquery' },
                { src: 'resources/plugins/moment-js/*', dest: '../plugins/moment-js' },
                { src: 'resources/plugins/particles/*', dest: '../plugins/particles' },
                { src: 'resources/plugins/prismjs/*', dest: '../plugins/prismjs' },
                { src: 'resources/plugins/tinymce/*', dest: '../plugins/tinymce' },
            ]
        }),
        laravel({
            input: [

                // GLOBAL CSS
                'resources/sass/app.sass',
                'resources/sass/externals.sass',
                'resources/sass/admin/app.sass',
                'resources/template/sass/main.scss',

                // LAYOUT CSS
                'resources/sass/_imports/layout/_about.sass',

                // LOCAL/PAGE CSS
                'resources/sass/_imports/modules/_auth.sass',
                'resources/sass/_imports/pages/_about.sass',
                'resources/sass/_imports/pages/_home.sass',
                'resources/sass/_imports/pages/_contact.sass',
                'resources/sass/_imports/pages/_services.sass',
                'resources/sass/_imports/pages/_projects.sass',
                'resources/sass/_imports/pages/_404.sass',
                'resources/sass/_imports/pages/post/_post-import.sass',
                'resources/sass/_imports/pages/_privacy-policy.sass',
                'resources/sass/_imports/pages/resume/_resume-import.sass',
                'resources/sass/_imports/custom/_owl.carousel.sass',

                // GLOBAL JS
                'resources/js/app.js',

                // LOCAL/PAGE JS
                'resources/js/pages/code-animation.js',
                'resources/js/pages/carousel.js',
                'resources/js/pages/auth.js',
                'resources/js/pages/blog.js',
                // 'resources/js/pages/subscription.js',
                'resources/js/pages/tooltip.js',
                'resources/js/pages/contact.js',

                // GLOBAL ADMIN JS
                'resources/js/admin/app.js',
                'resources/template/assets/js/oneui.app.min.js',

                // LOCAL/PAGE JS
                'resources/js/admin/pages/chart.js',
                'resources/js/admin/pages/post.js',
                'resources/js/admin/pages/export-db.js',
                'resources/js/admin/pages/file-manager.js',
                'resources/js/admin/pages/menu.js',
                'resources/js/admin/pages/portfolio.js',
                'resources/js/admin/pages/user-interaction.js',
                'resources/js/admin/pages/blog.js',
            ],
            refresh: true,
        }),
        purge({
            paths: [
                'resources/views/**/*.blade.php',
                'config/data/**/*.php',
                'resources/js/**/*.js',
                'resources/template/assets/js/oneui.app.min.js',
                'resources/template/assets/js/plugins/datatables/jquery.dataTables.min.js',
                'resources/template/assets/js/plugins/datatables-bs5/js/dataTables.bootstrap5.min.js',
                'resources/template/assets/js/plugins/select2/js/select2.full.min.js',
                'node_modules/owl.carousel/dist/owl.carousel.min.js',
                'node_modules/lazysizes/lazysizes.min.js'
            ]
        })
    ],
});
