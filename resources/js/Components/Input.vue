<template>
    <input
        :type="type"
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
    mixins: [inputMixin],
    props: {
        type: {
            type: String,
            default: 'text'
        }
    }
}
</script>
