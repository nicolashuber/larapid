<template>
    <textarea
        v-bind="inputBinding"
        rows="4"
        @input="onInput"
    />
</template>

<script>
import inputMixin from './inputMixin';

export default {
    mixins: [inputMixin]
}
</script>
