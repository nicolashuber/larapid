<template>
    <app :menu="menu" :user="user" :flash="flash">
        <l-page-header :title="$t('page.index')">
            <div class="d-flex justify-content-between mb-3">
                <l-search class="me-3" />
                <l-btn :href="createRoute" variant="primary">
                    {{ $t('btn.create') }}
                </l-btn>
            </div>
        </l-page-header>
        <l-data-table :data="data" :headers="headers" />
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
        data: {
            type: Object,
            required: true
        },
        headers: {
            type: Object,
            required: true
        },
        createRoute: {
            type: String,
            required: true
        },
        user: {
            type: Object,
            required: true
        },
        flash: {
            type: Object,
            required: true
        }
    }
}
</script>
