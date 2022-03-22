<template>
    <div class="data-table">
        <table ref="table" class="table table-striped table-bordered bg-white mb-0">
            <thead>
                <tr>
                    <th v-for="(header, column) in headers" :key="column">
                        <div class="d-inline-flex align-items-center" @click="onSortBy(header)">
                            {{ header.label }}
                            <l-icon
                                v-if="sortable && header.sortable"
                                class="ms-2"
                                :name="sortBy.column === header.column ? (sortBy.order === 'asc' ? 'sort-up' : 'sort-down') : 'sort'"
                            />
                        </div>
                    </th>
                    <th class="text-end">
                        {{ $t('datatable.actions') }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in data.data" :key="index">
                    <td v-for="(header, column) in headers" :key="column" v-html="item[column]" />
                    <td v-if="item.larapid.routes" class="text-center" :width="getActionWidth(item.larapid.routes)">
                        <l-btn v-if="item.larapid.routes.edit" :href="item.larapid.routes.edit" size="sm" variant="outline-info" class="me-2">
                            {{ $t('btn.edit') }}
                        </l-btn>
                        <l-btn v-if="item.larapid.routes.detail" :href="item.larapid.routes.detail" size="sm" variant="outline-primary" class="me-2">
                            {{ $t('btn.detail') }}
                        </l-btn>
                        <l-btn v-if="item.larapid.routes.destroy" size="sm" variant="outline-danger" @click="onDestroy(item.larapid.routes.destroy)">
                            {{ $t('btn.destroy') }}
                        </l-btn>
                    </td>
                </tr>
                <tr v-if="data.data.length == 0">
                    <td :colspan="Object.keys(headers).length + 1" class="text-center">
                        {{ $t('datatable.empty') }}
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-if="data.meta" class="mt-4 d-flex justify-content-between">
            <div class="text-nowrap d-flex align-items-center justify-content-start">
                <div class="me-2">
                    {{ $t('datatable.perPage') }}
                </div>
                <l-select v-model="perPage" :options="perPageOptions" @input="refresh" />
                <l-btn size="sm" variant="outline-primary" class="ms-3" @click="exportCSV">
                    {{ $t('btn.export-csv') }}
                </l-btn>
            </div>
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
        },
        sortable: {
            type: Boolean,
            default: true
        }
    },
    data () {
        return {
            perPage: 25,
            sortBy: {
                field: '',
                order: 'ASC'
            },
            perPageOptions: {
                '10': 10,
                '25': 25,
                '50': 50,
                '100': 100
            }
        }
    },
    computed: {
        sortByValue () {
            if (this.sortBy.column) {
                return `${this.sortBy.order}:${this.sortBy.column}`.toLowerCase()
            }

            return null
        }
    },
    mounted () {
        const searchParms = new URLSearchParams(window.location.search)

        if (searchParms.get('sort')) {
            const sort = searchParms.get('sort').split(':')

            if (sort.length > 1) {
                this.sortBy = {
                    column: sort[1],
                    order: sort[0],
                }
            }
        }

        if (searchParms.get('perPage')) {
            this.perPage = searchParms.get('perPage')
        }
    },
    methods: {
        getActionWidth (routes) {
            return `${72 * Object.keys(routes).length}px`
        },

        onSortBy ({ column, sortable }) {
            if (! sortable) {
                return
            }

            this.sortBy.column = column
            this.sortBy.order = this.sortBy.order === 'asc' ? 'desc' : 'asc'

            this.refresh()
        },

        refresh () {
            this.$inertia.get(this.$page.url, {
                sort: this.sortByValue,
                perPage: this.perPage
            })
        },

        exportCSV () {
            const rows = []
            const table = this.$refs.table
            const maxRows = table.querySelectorAll('thead th').length - 1

            for (const tr of table.querySelectorAll('tbody tr')) {
                const columns = []
                const td = tr.querySelectorAll('td')

                for (let i = 0; i < maxRows; i++) {
                    columns.push(td[i].innerText)
                }

                rows.push(columns.join(';'))
            }

            const encodedUri = encodeURI(`data:text/csv;charset=utf-8,${rows.join('\n')}`)
            const link = document.createElement('a')

            link.setAttribute('href', encodedUri)
            link.setAttribute('download', 'export.csv')
            document.body.appendChild(link)
            link.click()
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
        font-size: .875rem;

        .table {
            vertical-align: middle;
        }
    }
</style>
