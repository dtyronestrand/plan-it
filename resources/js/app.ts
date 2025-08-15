import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import {onMounted} from 'vue';
import {themeChange} from 'theme-change';
import {QuillEditor} from "@vueup/vue-quill";
import '@vueup/vue-quill/dist/vue-quill.snow.css';
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue);
    
        app.component('QuillEditor', QuillEditor);
    
        app.mount(el);
    },
    progress: {
        color: '#4B5563',
// app.component('QuillEditor, QuillEditor') // Removed, now registered inside setup
}});

// This will set light / dark mode on page load...
export default {
    setup(){
        onMounted(() => {
            themeChange(false); // Initialize theme change without auto-detecting
        });
    }
}
