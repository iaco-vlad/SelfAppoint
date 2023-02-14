import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import sass from 'sass';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '@': require('path').resolve(__dirname, 'resources/js'),
            '~': require('path').resolve(__dirname, 'resources/sass'),
        },
    },
    build: {
        outDir: 'public',
        assetsDir: '',
        manifest: true,
        rollupOptions: {
            input: {
                app: './resources/js/app.js',
                bootstrap: './resources/js/bootstrap.js'
            }
        }
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
