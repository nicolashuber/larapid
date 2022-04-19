<template>
    <div class="plain-text text-muted" v-html="value" />
</template>

<script>
export default {
    props: ['value']
}
</script>

<style lang="scss">
    .plain-text {
        @extend .form-control-plaintext !optional;
    }
</style>
