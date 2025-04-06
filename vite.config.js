import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/lib/custom-slick.css',
                'resources/css/form/autocomplete.css',
                'resources/css/lib/switch.css',
                'resources/css/lib/micromodal.css',
                'resources/js/app.js',
                'resources/js/pages/main.js',
                'resources/js/bootstrap.js',
                'resources/js/pages/activity-edit.js',
                'resources/js/pages/artwork.js',
                'resources/js/pages/artwork-edit.js',
                'resources/js/pages/artwork-sort.js',
                'resources/js/pages/login.js',
                'resources/js/pages/my.js',
                'resources/js/pages/my-artwork.js',
                'resources/js/pages/my-edit.js',
                'resources/js/pages/reference-folder.js',
                'resources/js/pages/references.js',
                'resources/js/pages/resume-edit.js',
                'resources/js/pages/signup.js',
                'resources/js/pages/single-chat.js',
                'resources/js/pages/user-chats.js',
                'resources/js/pages/reset-password.js',
                'resources/js/lib/close_action.js',
                'resources/js/lib/core.js',
                'resources/js/lib/delete_image_in_form.js',
                'resources/js/lib/elements.js',
                'resources/js/lib/form.js',
                'resources/js/lib/form_element_multiselect.js',
                'resources/js/lib/header.js',
                'resources/js/lib/modal.js',
                'resources/js/lib/references.js',
                'resources/js/lib/switcher.js',
                'resources/js/api/api_action.js',
                'resources/js/api/request.js',
            ],
            refresh: true,
        }),

    ],
    server: {
        hmr: {
            host: 'localhost'
        }
    },
    define: {
        // By default, Vite doesn't include shims for NodeJS/
        // necessary for segment analytics lib to work
        _global: ({}),
    },
    esbuild: {
        supported: {
            'top-level-await': true
        },
    }
});
