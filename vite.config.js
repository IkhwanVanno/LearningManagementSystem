import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/welcome.css",
                "resources/css/auth.css",
                "resources/js/welcome.js",
                "resources/css/layout.css",
                "resources/css/sidebar.css",
                "resources/css/main.css",
            ],
            refresh: true,
        }),
    ],
});
