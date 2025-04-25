import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import path from 'path'
import vue from "@vitejs/plugin-vue";

export default defineConfig({
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            '~': path.resolve('resources/css'),
        },
    },
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
