import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/app.js",
                "resources/sass/app.scss",
                "resources/sass/themes/amethyst.scss",
                "resources/sass/themes/dark.scss",
                "resources/sass/themes/golf.scss",
                "resources/sass/themes/midnight.scss",
            ],
            refresh: true,
        }),
    ],
});
