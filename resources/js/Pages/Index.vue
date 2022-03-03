<template>
    <app :menu="menu">
        <l-page-header title="Index">
            <l-btn :href="createRoute" variant="secondary">
                Create new
            </l-btn>
        </l-page-header>
        <l-data-table :data="data" :headers="headers" />
    </app>
</template>

<script>
import App from '@/Layouts/App'

export default {
    components: {
        App
    },
    props: {
        menu: {
            type: Array,
            default: []
        },
        data: {
            type: Object,
            required: true
        },
        headers: {
            type: Object,
            required: true
        },
        createRoute: {
            type: String,
            required: true
        }
    }
}
</script>
