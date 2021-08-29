<template>
    <input
        :type="type"
        :name="name"
        :value="modelValue"
        :placeholder="placeholder"
        @input="onInput"
    />
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            default: 'text'
        },
        name: {
            type: String,
            required: true
        },
        modelValue: {
            type: [Number, String]
        },
        placeholder: {
            type: String
        }
    },
    methods: {
        onInput (e) {
            this.$emit('update:modelValue', e.target.value)
        }
    }
}
</script>
