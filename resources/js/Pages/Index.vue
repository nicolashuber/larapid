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
