import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/premium.css',
                'resources/css/custom-checkbox.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
});
