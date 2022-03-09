<template>
    <l-select
        :name="name"
        :modelValue="modelValue"
        :options="options"
        :hasError="hasError"
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
