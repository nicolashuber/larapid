<template>
    <l-input
        type="url"
        :name="name"
        :value="modelValue"
        :placeholder="placeholder"
        @input="onInput"
    />
</template>

<script>
import inputMixin from './inputMixin';

export default {
    mixins: [inputMixin]
}
</script>
