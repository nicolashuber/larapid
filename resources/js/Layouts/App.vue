<template>
    <div class="app">
        <aside class="aside" :class="{ active: showMenu }">
            <header class="aside-header">
                {{ app.title }}
            </header>
            <nav class="nav">
                <ul class="nav-list">
                    <li v-for="(item, index) in app.menu" :key="index" class="nav-item">
                        <ul v-if="item.subMenu" class="nav-sublist">
                            <li class="nav-group">{{ index }}</li>
                            <li v-for="(subItem, index) in item.subMenu" :key="index" class="nav-item">
                                <Link :href="subItem.route" :class="{ active: subItem.active }">{{ subItem.label }}</Link>
                            </li>
                        </ul>
                        <Link v-else :href="item.route" :class="{ active: item.active }">{{ item.label }}</Link>
                    </li>
                </ul>
            </nav>
        </aside>
        <main class="main">
            <header class="header text-muted">
                <a href="#" class="d-md-none" :class="{ 'me-auto': ! showMenu, 'me-5': showMenu }" @click.prevent="showMenu = ! showMenu">
                    <l-icon :name="showMenu ? 'close' : 'bars'" />
                </a>
                <template v-if="app.user">
                    {{ app.user.name }} <small class="ms-1">(<a href="#" @click.prevent="logout">{{ $t('auth.logout') }}</a>)</small>
                </template>
            </header>
            <div class="content">
                <slot />
            </div>
        </main>
        <l-notifications />
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link
    },
    props: {
        app: {
            type: Object,
            required: true
        }
    },
    data () {
        return {
            showMenu: false
        }
    },
    mounted () {
        this.showToast(this.app.flash)
    },
    watch: {
        'app.flash' (toast) {
            this.showToast(toast)
        }
    },
    methods: {
        logout () {
            this.$inertia.post('/cms/logout')
        },

        showToast (toast) {
            if (toast && toast.type && toast.message) {
                this.$store.dispatch('addToast', toast)
            }
        }
    }
}
</script>

<style lang="scss">
    .app {
        overflow-x: hidden;
    }
</style>
