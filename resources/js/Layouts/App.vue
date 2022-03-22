<template>
    <div class="app">
        <aside class="aside">
            <header class="aside-header">
                Larapid
            </header>
            <nav class="nav">
                <ul class="nav-list">
                    <li v-for="(item, index) in menu" :key="index" class="nav-item">
                        <ul v-if="item.subMenu" class="nav-sublist">
                            <li class="nav-group">{{ index }}</li>
                            <li v-for="(subItem, index) in item.subMenu" :key="index" class="nav-item">
                                <Link :href="subItem.route">{{ subItem.label }}</Link>
                            </li>
                        </ul>
                        <Link v-else :href="item.route">{{ item.label }}</Link>
                    </li>
                </ul>
            </nav>
        </aside>
        <main class="main">
            <header class="header text-muted">
                {{ user.name }} <small class="ms-1">(<a href="#" @click.prevent="logout">{{ $t('auth.logout') }}</a>)</small>
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
        menu: {
            type: Object,
            default: []
        },
        user: {
            type: Object,
            required: true
        }
    },
    methods: {
        logout () {
            this.$inertia.post('logout')
        }
    }
}
</script>
