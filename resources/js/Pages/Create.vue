<template>
    <app :app="app">
        <l-page-header :title="$t('page.create')" />
        <l-form
            :route="route"
            :errors="errors"
            :fields="fields"
            :back-route="backRoute"
        />
    </app>
</template>

<script>
import App from '@/Layouts/App'

export default {
    components: {
        App
    },
    props: {
        app: {
            type: Object,
            required: true
        },
        route: {
            type: String,
            required: true
        },
        errors: {
            type: Object,
            required: true
        },
        fields: {
            type: Object,
            required: true
        },
        backRoute: {
            type: String,
            default: ''
        }
    }
}
</script>
