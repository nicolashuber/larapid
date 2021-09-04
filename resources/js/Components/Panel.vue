<template>
    <div class="panel">
        <div v-if="$slots.header || title" class="d-flex align-items-center justify-content-between mb-3">
            <h3 v-if="title" class="panel-title">{{ title }}</h3>
            <slot name="header" />
        </div>
        <div class="panel-content">
            <slot />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: String
    }
}
</script>
