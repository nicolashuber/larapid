<template>
    <l-input
        v-bind="inputBinding"
        type="text"
        @input="onInput"
    />
</template>

<script>
import inputMixin from './inputMixin';

export default {
    mixins: [inputMixin]
}
</script>
