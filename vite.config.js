import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import fs from 'fs';
import { homedir } from 'os';
import { resolve } from 'path';

const host = 'jarsiplus-v2.test';

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
        }),
    ],
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    server: {
        host,
        port: 5173,
        https: {
            key: fs.readFileSync(resolve(homedir(), `.config/valet/Certificates/${host}.key`)),
            cert: fs.readFileSync(resolve(homedir(), `.config/valet/Certificates/${host}.crt`)),
        },
        hmr: {
            host,
        },
    },
});
