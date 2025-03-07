import type { DefineComponent } from 'vue'
import * as ElementPlusIconsVue from '@element-plus/icons-vue'
import { createInertiaApp } from '@inertiajs/vue3'
import ElementPlus from 'element-plus'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'

import { createApp, h } from 'vue'
import { ZiggyVue } from '../../vendor/tightenco/ziggy'
import 'element-plus/dist/index.css'
import '../css/app.css'
import 'element-plus/theme-chalk/dark/css-vars.css'
import '../css/css-vars.css'

import './bootstrap'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
  title: title => `${title} - ${appName}`,
  resolve: name =>
    resolvePageComponent(
      `./Pages/${name}.vue`,
      import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
    ),
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(ElementPlus)

    for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
      app.component(key, component)
    }

    app.mount(el)
  },
  progress: {
    color: '#4B5563',
  },
})
