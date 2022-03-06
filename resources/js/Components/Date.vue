<template>
    <l-input
        v-bind="inputBinding"
        type="text"
        :mask="mask"
        @input="onInput"
    />
</template>

<script>
import inputMixin from './inputMixin';

export default {
    mixins: [inputMixin],
    computed: {
        mask () {
            return this.options.mask ?? '##/##/####'
        }
    }
}
</script>
