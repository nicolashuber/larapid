<template>
    <l-select
        :name="name"
        :value="modelValue"
        :options="data"
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
