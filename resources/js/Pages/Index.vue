<template>
    <app :menu="menu">
        <l-page-header title="Index">
            <Link :href="createRoute" class="btn btn-secondary">Create new</Link>
        </l-page-header>
        <table class="table table-striped table-bordered bg-white">
            <thead>
                <tr>
                    <th v-for="(header, column) in headers" :key="column">
                        {{ header }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in data.data" :key="index">
                    <td v-for="(header, column) in headers" :key="column">
                        {{ item[column] }}
                    </td>
                    <td width="140px" class="text-center">
                        <Link :href="item.routes.edit" class="btn btn-sm btn-outline-info me-2">
                            Edit
                        </Link>
                        <Link :href="item.routes.detail" class="btn btn-sm btn-outline-primary">
                            Detail
                        </Link>
                    </td>
                </tr>
                <tr v-if="data.data.length == 0">
                    <td :colspan="Object.keys(headers).length" class="text-center">
                        No records.
                    </td>
                </tr>
            </tbody>
        </table>
    </app>
</template>

<script>
import App from '@/Layouts/App'
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        App,
        Link
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
        headers: {
            type: Object,
            required: true
        },
        createRoute: {
            type: String,
            required: true
        }
    }
}
</script>
