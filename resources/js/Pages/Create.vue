<template>
    <app :menu="menu" :user="user">
        <l-page-header :title="$t('page.create')" />
        <l-form
            :route="route"
            :errors="errors"
            :fields="fields"
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
        route: {
            type: String,
            required: true
        },
        menu: {
            type: Object,
            default: []
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
        }
    }
}
</script>
