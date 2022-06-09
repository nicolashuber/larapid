<template>
    <input
        ref="inputRef"
        type="text"
        class="form-control"
        :class="{ 'is-invalid': hasError }"
        :readonly="readOnly"
        :placeholder="placeholder"
    />
</template>

<script>
import { useCurrencyInput } from 'vue-currency-input'

export default {
    props: {
        options: Object,
        readOnly: Boolean,
        hasError: Boolean,
        modelValue: Number,
        placeholder: String
    },
    setup (props) {
        const { inputRef } = useCurrencyInput({
            locale: props.options.locale || 'en-US',
            currency: props.options.currency || 'USD',
            currencyDisplay: 'symbol',
            hideCurrencySymbolOnFocus: true,
            hideGroupingSeparatorOnFocus: true,
            hideNegligibleDecimalDigitsOnFocus: true,
            autoDecimalDigits: false,
            autoSign: true,
            useGrouping: true,
            accountingSign: false
        })

        return { inputRef }
    }
}
</script>
