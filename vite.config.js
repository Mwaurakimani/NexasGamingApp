import { defineConfig } from 'vite'
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
                'resources/js/Pages/**',      // auto refresh inertia pages
                'resources/js/Layouts/**',
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
            '@components': path.resolve(__dirname, 'resources/js/Components'),
            '@modules': path.resolve(__dirname, 'resources/js/modules'),
        },
    },
    css: {
        preprocessorOptions: {
            scss: {
                additionalData: `@use "@scss/variables.scss" as *;`, // Global SCSS variables
            },
        },
    },
    server: {
        host: '192.168.100.4',
        port: 3000,
        strictPort: true,
        watch: {
            usePolling: true,
            interval: 1000, // Recommended for WSL/Windows FS latency
            ignored: ['**/node_modules/**'], // Reduces file system noise
        },
        open: false, // disable auto-open browser
    },
})
