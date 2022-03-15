<template>
    <input
        ref="inputRef"
        v-bind="inputBinding"
        type="text"
        v-maska="mask"
        @input="onInput"
    />
</template>

<script>
import { useCurrencyInput } from 'vue-currency-input'
import inputMixin from './inputMixin';

export default {
    mixins: [inputMixin],
    setup () {
        const { inputRef } = useCurrencyInput({
            currency: 'BRL',
            locale: 'pt-BR',
            precision: 2,
            // exportValueAsInteger: true,
            // valueScaling: 'precision',
            autoDecimalDigits: true
        })

        return { inputRef }
    }
}
</script>
