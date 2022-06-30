<template>
    <app :app="app">
        <l-page-header :title="$t('page.index')">
            <div class="d-flex justify-content-between">
                <l-search />
                <l-btn v-if="createRoute" :href="createRoute" variant="primary" class="ms-3">
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
        app: {
            type: Object,
            required: true
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
        }
    }
}
</script>
