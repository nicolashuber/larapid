<template>
    <app>
        <h3>Edit.vue</h3>
        <l-form
            :data="data"
            :route="route"
            :fields="fields"
            :errors="errors"
            @submit="onSubmit"
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
