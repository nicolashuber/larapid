<template>
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">{{ metric.title }}</h6>
            <div v-if="metric.range" class="card-subtitle mb-2 text-muted">
                {{ $t('metric.latest') }} {{ metric.range }} {{ $t('metric.range.days') }}
            </div>
            <div class="display-1 text-center" :class="{ 'text-success': metric.range && metric.value > 0 }">
                {{ metric.value }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        metric: {
            type: Object,
            required: true
        }
    }
}
</script>
