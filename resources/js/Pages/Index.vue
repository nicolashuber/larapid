<template>
    <app>
        <h3>Index.vue</h3>
        <Link :href="createRoute">Create new</Link>
        <table>
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
            type: Array,
            required: true
        },
        headers: {
            type: Array,
            required: true
        },
        createRoute: {
            type: String,
            required: true
        }
    }
}
</script>
