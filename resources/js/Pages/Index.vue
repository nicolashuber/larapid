<template>
    <app :menu="menu" :user="user">
        <l-page-header title="Index">
            <div class="d-flex justify-content-between">
                <l-search class="me-3" />
                <l-btn :href="createRoute" variant="primary">
                    Create new
                </l-btn>
            </div>
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
        },
        user: {
            type: Object,
            required: true
        }
    }
}
</script>
