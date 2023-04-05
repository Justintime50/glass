import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/sass/app.scss",
                "resources/sass/themes/amethyst.scss",
                "resources/sass/themes/dark.scss",
                "resources/sass/themes/midnight.scss",
                "resources/js/app.js",
            ],
            refresh: true,
        }),
    ],
});
