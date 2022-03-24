<template>
    <input type="text" readonly class="form-control-plaintext text-muted" :value="value">
</template>

<script>
export default {
    props: ['value']
}
</script>
