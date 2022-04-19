<template>
  <div class="d-flex">
    <div v-for="(option, index) in choices" :key="index" class="form-check me-3">
        <input v-model="currentValue" class="form-check-input" type="radio" :name="name" :id="getFieldId(index)" :value="option.value">
        <label class="form-check-label" :for="getFieldId(index)">
            {{ option.label }}
        </label>
    </div>
  </div>
</template>

<script>
import inputMixin from './inputMixin';

export default {
    mixins: [inputMixin],
    data () {
        return {
            choices: [
                { label: 'Yes', value: 1 },
                { label: 'No', value: 0 },
            ],
            currentValue: null
        }
    },
    mounted () {
        this.choices = this.options.choices
        this.currentValue = this.modelValue
    },
    watch: {
        modelValue (val) {
            this.currentValue = val
        },

        currentValue (val) {
            this.$emit('update:modelValue', val)
        }
    },
    methods: {
        getFieldId (index) {
            return `l-boolean_${this.name}-${index}`
        }
    }
}
</script>
