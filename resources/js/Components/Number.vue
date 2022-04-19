<template>
    <l-input
        v-bind="inputBinding"
        type="number"
        mask="#*"
        :min="options.min"
        :max="options.max"
        @input="onInput"
    />
</template>

<script>
import inputMixin from './inputMixin';

export default {
    mixins: [inputMixin]
}
</script>
