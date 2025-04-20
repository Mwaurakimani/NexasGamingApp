import {defineConfig} from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: [
                'routes/**',
                'app/Http/Controllers/**',
                'resources/views/**',
            ],
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
            '@': path.resolve(__dirname, 'resources/js'),
            '@scss': path.resolve(__dirname, 'resources/scss'),
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@use "@scss/variables.scss" as *;`, // auto-import global vars if needed
            },
        },
    },
    server: {
        host: '192.168.100.4',
        strictPort: true,
        port: 3000,
        watch: {
            usePolling: true,
        },
    },
})
