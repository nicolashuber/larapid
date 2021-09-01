<template>
    <input
        v-bind="inputBinding"
        @input="onInput"
    />
</template>

<script>
import inputMixin from './inputMixin';

export default {
    mixins: [inputMixin],
    props: {
        type: {
            type: String,
            default: 'text'
        }
    }
}
</script>
