import jigsaw from "@tighten/jigsaw-vite-plugin";
import {defineConfig} from "vite";
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        vue(),
        jigsaw({
            input: ["source/_assets/js/main.js", "source/_assets/css/main.css"],
            refresh: true,
        }),
        tailwindcss()
    ],
});
