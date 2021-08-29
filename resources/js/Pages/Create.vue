<template>
    <app>
        <h3>Create.vue</h3>
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
        errors: {
            type: Object,
            required: true
        },
        fields: {
            type: Object,
            required: true
        }
    }
}
</script>
