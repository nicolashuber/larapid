<template>
    <app :menu="menu" :user="user">
        <h3>Edit</h3>
        <l-form
            :data="data"
            :route="route"
            :fields="fields"
            :errors="errors"
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
            type: Array,
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
        }
    }
}
</script>
