<template>
    <input
        v-bind="inputBinding"
        :type="type"
        v-maska="mask"
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
