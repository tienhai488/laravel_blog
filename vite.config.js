import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/scss/app.scss',
                'resources/css/bootstrap4.min.css',
                'resources/js/app.js',
                'resources/js/bootstrap4.min.js'
            ],
            refresh: true,
        }),
    ],
});
