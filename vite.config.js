import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import statamic from '@statamic/cms/vite-plugin';
import tailwindcss from '@tailwindcss/vite';
// import path from 'path';

export default defineConfig({
    // resolve: {
    //     alias: {
    //         '@statmic': path.resolve(__dirname, './vendor/statamic/cms/resources/js'),
    //     },
    // },
    plugins: [
        laravel({
            input: [
                'resources/js/addon.js',
                'resources/css/addon.css'
            ],
            publicDirectory: 'resources/dist',
        }),
        statamic(),
        tailwindcss(),
    ],
});