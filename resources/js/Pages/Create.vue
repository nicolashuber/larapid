<template>
    <app :menu="menu" :user="user">
        <h3>Create</h3>
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
            type: Array,
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
