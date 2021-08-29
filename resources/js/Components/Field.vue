<template>
    <div>
        <label v-if="name" :for="name">{{ label }}</label>
        <slot />
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
        }
    }
}
</script>
