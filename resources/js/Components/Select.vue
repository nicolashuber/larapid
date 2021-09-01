<template>
    <select
        :name="name"
        :value="modelValue"
        :placeholder="placeholder"
        class="form-control"
        @input="onInput"
    >
        <option v-if="placeholder" value="">{{ placeholder }}</option>
        <option v-for="(option, value) in options" :key="value" :value="value">
            {{ option }}
        </option>
    </select>
</template>

<script>
import inputMixin from './inputMixin';

export default {
    mixins: [inputMixin],
    props: {
        options: {
            type: Object,
            required: true
        }
    }
}
</script>
