export default {
    props: {
        data: {},
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
