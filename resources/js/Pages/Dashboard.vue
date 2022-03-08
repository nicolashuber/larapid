<template>
    <app :menu="menu">
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
        }
    }
}
</script>
