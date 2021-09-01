<template>
    <textarea
        :name="name"
        :value="modelValue"
        :placeholder="placeholder"
        class="form-control"
        @input="onInput"
    />
</template>

<script>
import inputMixin from './inputMixin';

export default {
    mixins: [inputMixin]
}
</script>
