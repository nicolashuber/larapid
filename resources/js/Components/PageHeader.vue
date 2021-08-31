<template>
    <div class="page-header">
        <h1 class="page-header-title">{{ title }}</h1>
        <div>
            <slot />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        }
    }
}
</script>
