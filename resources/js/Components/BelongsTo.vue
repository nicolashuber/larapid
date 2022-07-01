<template>
    <div>
        <l-autocomplete
            :options="options"
            :modelValue="modelValue"
            :hasError="hasError"
            @change="onChange"
        />
    </div>
</template>

<script>
import inputMixin from './inputMixin';

export default {
    mixins: [inputMixin],
    methods: {
        onChange (e) {
            if (! (e instanceof Event)) {
                this.$emit('update:modelValue', e)
            }
        }
    }
}
</script>
