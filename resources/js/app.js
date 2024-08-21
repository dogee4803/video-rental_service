import './bootstrap';
import '../css//app.css';

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import Layout from './Layouts/Layout.vue';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]
    page.default.layout = page.default.layout || Layout
    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(PrimeVue, {
        theme: {
            preset: Aura
        }
      })
      .mount(el)
  },
  progress: {
    color: 'red',
    includeCSS: true,
    showSpinner: true,
  },
})