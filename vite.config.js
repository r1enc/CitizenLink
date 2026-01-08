import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: 'citizenlink.test', // Tambahkan ini biar Vite kenal domain kamu
        port: 5173,
        strictPort: true,
    },
});