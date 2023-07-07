import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import checker from 'vite-plugin-checker'

export default defineConfig({
    plugins: [
        checker({
            stylelint: {
                lintCommand: 'stylelint ./resources/scss/**/*.scss',
            },
            eslint: {
                lintCommand: 'eslint ./resources/ts/**/*.ts --ext .ts',
            },
        }),
        laravel({
            input: ['resources/scss/admin.scss', 'resources/ts/admin.ts'],
            refresh: true,
        }),
    ],
});
