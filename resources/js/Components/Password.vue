<template>
    <l-input
        v-bind="inputBinding"
        type="password"
        value=""
        @input="onInput"
    />
</template>

<script>
import inputMixin from './inputMixin';

export default {
    mixins: [inputMixin]
}
</script>
