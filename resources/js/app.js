import { createApp, h } from 'vue'
import { createStore } from 'vuex'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import Maska from 'maska'

import { makeId } from './utils'
import components from '@/Components'

InertiaProgress.init({
    color: '#0d6efd'
})

const store = createStore({
    state () {
        return {
            toasts: []
        }
    },
    mutations: {
        ADD_TOAST (state, item) {
            state.toasts.push(item)
        },

        REMOVE_TOAST (state, { id }) {
            const index = state.toasts.findIndex(item => item.id = id)

            if (index > -1) {
                state.toasts.splice(index)
            }
        }
    },
    actions: {
        addToast ({ commit, dispatch }, { type, message }) {
            const item = { id: makeId(), type, message }

            commit('ADD_TOAST', item)
            setTimeout(() => {
                dispatch('removeToast', item)
            }, 1500)
        },

        removeToast ({ commit }, item) {
            commit('REMOVE_TOAST', item)
        }
    }
})

createInertiaApp({
    resolve: name => require(`./Pages/${name}`),
    setup({ el, App, props, plugin }) {
        const app = createApp({
            render: () => h(App, props)
        })

        for (const name in components) {
            app.component(`l-${name}`, components[name])
        }

        app.use(store)
        app.use(Maska)
        app.use(plugin).mount(el)
    }
})
