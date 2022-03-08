<template>
  <nav v-if="meta.last_page > 1" aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item" :class="{ disabled: meta.current_page === 1 }">
            <a class="page-link" href="#" @click.prevent="prev">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li class="page-item" :class="{ disabled: meta.current_page === meta.last_page }">
            <a class="page-link" href="#" @click.prevent="next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
    </nav>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'

export default {
    props: {
        meta: {
            type: Object,
            required: true
        }
    },
    methods: {
        goPage(page) {
            Inertia.visit(this.$page.url, {
                method: 'get',
                data: {
                    page
                }
            })
        },

        prev () {
            const page = this.meta.current_page - 1

            this.goPage(
                page > 0 ? page : 1
            )
        },

        next () {
            const page = this.meta.current_page + 1
            const last = this.meta.last_page

            this.goPage(
                page <= last ? page : last
            )
        }
    }
}
</script>
