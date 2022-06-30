<template>
    <app :app="app">
        <l-page-header :title="$t('page.edit')" />
        <l-form
            :data="data"
            :route="route"
            :fields="fields"
            :errors="errors"
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
        data: {
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
