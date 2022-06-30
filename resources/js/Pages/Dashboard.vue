<template>
    <app :app="app">
        <h3>{{ $t('page.dashboard') }}</h3>

        <div class="mt-4">
            <div v-if="metrics.lenght > 0" class="row">
                <div v-for="(metric, index) in metrics" :key="index" class="col-md-4 mb-3">
                    <l-metric :metric="metric" />
                </div>
            </div>
        </div>

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
        metrics: {
            type: Array,
            default: []
        }
    }
}
</script>
