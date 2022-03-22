<template>
    <app :menu="menu" :user="user">
        <h3>{{ $t('page.dashboard') }}</h3>
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
            type: Object,
            default: []
        },
        user: {
            type: Object,
            required: true
        }
    }
}
</script>
