import './bootstrap';
import '../css//app.css';

import { createApp, h } from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/vue3'
import Layout from './Layouts/Layout.vue';
import PrimeVue from 'primevue/config';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Aura from '@primevue/themes/aura';
import ConfirmationService from 'primevue/confirmationservice';
import ToastService from 'primevue/toastservice';

createInertiaApp({
  title: (title) => `DVD ${title}`,
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    let page = pages[`./Pages/${name}.vue`]
    page.default.layout = page.default.layout || Layout
    return page
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(PrimeVue, {
        theme: {
            preset: Aura
        }
      })
      .use(ConfirmationService)
      .use(ToastService)
      .component('Head', Head)
      .component('Link', Link)
      .mount(el)
  },
  progress: {
    color: 'red',
    includeCSS: true,
    showSpinner: true,
  },
})