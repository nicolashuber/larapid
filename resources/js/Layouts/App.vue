<template>
    <div class="app">
        <aside class="aside">
            <header class="aside-header">
                Larapid
            </header>
            <nav class="nav">
                <ul class="nav-list">
                    <li v-for="(item, index) in menu" :key="index" class="nav-item">
                        <Link :href="item.route">{{ item.label }}</Link>
                    </li>
                </ul>
            </nav>
        </aside>
        <main class="main">
            <header class="header"></header>
            <div class="content">
                <slot />
            </div>
        </main>
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
            type: Array,
            default: []
        }
    }
}
</script>
