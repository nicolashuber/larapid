<template>
    <app :menu="menu">
        <l-page-header title="Detail"></l-page-header>
        <l-panel>
            <l-field v-for="(label, column) of columns" horizontal :key="column" :label="label">
                <l-plain-text :value="data[column]" />
            </l-field>
        </l-panel>

        <l-panel v-for="(relation, index) in relations" :key="index" :title="relation.title">
            <template #header>
                <l-btn size="sm" variant="secondary" :href="relation.routes.create">
                    Create new
                </l-btn>
            </template>
            <l-data-table :data="relation.data" :headers="relation.columns" />
        </l-panel>
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
        },
        relations: {
            type: Object
        }
    }
}
</script>
