<template>
    <l-input
        v-bind="inputBinding"
        type="text"
        :mask="inputMask"
        @input="onInput"
    />
</template>

<script>
import inputMixin from './inputMixin';

export default {
    mixins: [inputMixin],
    computed: {
        inputMask () {
            return this.options.mask || null
        }
    }
}
</script>
