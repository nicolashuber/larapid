<template>
    <div class="mb-3">
        <label v-if="name" :for="name" class="form-label">
            {{ label }}
        </label>
        <slot />
        <div v-if="error" class="invalid-feedback">
            {{ error }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String
        },
        label: {
            type: String
        },
        help: {
            type: String
        },
        error: {
            type: String
        }
    }
}
</script>
