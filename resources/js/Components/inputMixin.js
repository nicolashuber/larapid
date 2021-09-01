export default {
    props: {
        options: {
            type: [Object]
        },
        name: {
            type: String,
            required: true
        },
        modelValue: {
            type: [Number, String]
        },
        hasError: {
            type: Boolean,
            default: false
        },
        placeholder: {
            type: String
        }
    },
    computed: {
        inputBinding () {
            return {
                name: this.name,
                value: this.modelValue,
                class: this.inputClasses,
                options: this.options,
                placeholder: this.placeholder
            }
        },

        inputClasses () {
            return [
                'form-control',
                { 'is-invalid': this.hasError }
            ]
        }
    },
    methods: {
        onInput (e) {
            this.$emit('update:modelValue', e.target.value)
        }
    }
}
