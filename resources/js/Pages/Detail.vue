<template>
    <app :menu="menu">
        <l-page-header title="Detail"></l-page-header>
        <div class="detail">
            <l-field v-for="(label, column) of columns" horizontal :key="column" :label="label">
                <l-plain-text :value="data[column]" />
            </l-field>
        </div>
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
        data: {
            type: Object,
            required: true
        },
        columns: {
            type: Object,
            required: true
        }
    }
}
</script>
