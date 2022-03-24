<template>
    <div class="d-md-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 my-0">{{ title }}</h1>
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
