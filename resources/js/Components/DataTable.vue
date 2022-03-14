<template>
    <div class="data-table">
        <table class="table table-striped table-bordered bg-white mb-0">
            <thead>
                <tr>
                    <th v-for="(header, column) in headers" :key="column">
                        {{ header }}
                    </th>
                    <th class="text-end">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in data.data" :key="index">
                    <td v-for="(header, column) in headers" :key="column" v-html="item[column]" />
                    <td v-if="item.larapid.routes" class="text-center" :width="getActionWidth(item.larapid.routes)">
                        <l-btn v-if="item.larapid.routes.edit" :href="item.larapid.routes.edit" size="sm" variant="outline-info" class="me-2">
                            Edit {{ item.larapid.routes.length }}
                        </l-btn>
                        <l-btn v-if="item.larapid.routes.detail" :href="item.larapid.routes.detail" size="sm" variant="outline-primary" class="me-2">
                            Detail
                        </l-btn>
                        <l-btn v-if="item.larapid.routes.destroy" size="sm" variant="outline-danger" @click="onDestroy(item.routes.destroy)">
                            Delete
                        </l-btn>
                    </td>
                </tr>
                <tr v-if="data.data.length == 0">
                    <td :colspan="Object.keys(headers).length + 1" class="text-center">
                        No records.
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-if="data.meta" class="mt-4 d-flex justify-content-center">
            <l-pagination :meta="data.meta" />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        data: {
            type: Object,
            required: true
        },
        headers: {
            type: Object,
            required: true
        }
    },
    methods: {
        getActionWidth (routes) {
            return `${70 * Object.keys(routes).length}px`
        },

        onDestroy (route) {
            if (window.confirm('Do you really want to delete this item?')) {
                this.$inertia.delete(route)
            }
        }
    }
}
</script>

<style lang="scss">
    .data-table {
        font-size: .875rem
    }
</style>
