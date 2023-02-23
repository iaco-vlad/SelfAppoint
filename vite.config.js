import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import sass from 'sass';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': require('path').resolve(__dirname, 'resources/js'),
            '~': require('path').resolve(__dirname, 'resources/sass'),
        },
    },
    css: {
        css: {
            preprocessorOptions: {
                scss: {
                    implementation: sass,
                },
            },
        },
    },
});
