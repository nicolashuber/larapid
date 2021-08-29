import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import components from '@/Components'

for (const name in components) {
    console.log(`l-${name}`);
}

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        const app = createApp({
            render: () => h(App, props)
        })

        for (const name in components) {
            app.component(`l-${name}`, components[name])
        }

        app.use(plugin).mount(el)
    }
})
