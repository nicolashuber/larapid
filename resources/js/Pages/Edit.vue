<template>
    <app :menu="menu" :user="user" :flash="flash">
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
        data: {
            type: Object,
            required: true
        },
        menu: {
            type: Object,
            default: []
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
        user: {
            type: Object,
            required: true
        },
        flash: {
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
