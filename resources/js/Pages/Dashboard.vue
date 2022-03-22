<template>
    <app :menu="menu" :user="user">
        <h3>Welcome back!</h3>
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
        user: {
            type: Object,
            required: true
        }
    }
}
</script>
