<template>
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
                <td v-for="(header, column) in headers" :key="column">
                    {{ item[column] }}
                </td>
                <td width="140px" class="text-center">
                    <div class="d-inline-block me-2">
                        <l-btn v-if="item.routes" :href="item.routes.edit" size="sm" variant="outline-info">
                            Edit
                        </l-btn>
                    </div>
                    <l-btn v-if="item.routes" :href="item.routes.detail" size="sm" variant="outline-primary">
                        Detail
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
    }
}
</script>
