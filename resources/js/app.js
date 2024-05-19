import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// formkit
import { plugin as FormKitPlugin, defaultConfig } from '@formkit/vue'
import '@formkit/themes/genesis'
// end formkit installation

// pinia
import { createPinia } from 'pinia'
const pinia = createPinia()
// end pinia

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
// , { eager: true }
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue', {eager: true})),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(FormKitPlugin, defaultConfig)
            .use(pinia)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
