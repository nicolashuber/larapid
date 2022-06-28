export default {
    props: {
        options: {
            type: Object
        },
        name: {
            type: String,
            default: ''
        },
        mask: {
            type: [Array, String],
            default: ''
        },
        min: {
            type: Number,
            default: null
        },
        max: {
            type: Number,
            default: null
        },
        readOnly: {
            type: Boolean,
            default: false
        },
        required: {
            type: Boolean,
            default: false
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
                min: this.min,
                max: this.max,
                options: this.options,
                required: this.required,
                readonly: this.readOnly,
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
        },

        onFocus (e) {
            this.$emit('focus', e)
        },

        onBlur (e) {
            this.$emit('blur', e)
        }
    }
}
