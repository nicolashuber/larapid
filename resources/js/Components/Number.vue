<template>
    <l-input
        v-bind="inputBinding"
        type="number"
        @input="onInput"
    />
</template>

<script>
import inputMixin from './inputMixin';

export default {
    mixins: [inputMixin]
}
</script>
