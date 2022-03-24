<template>
    <div class="autocomplete">
        <l-input v-model="filter" ref="inputRef" @blur="onBlur" @focus="onFocus" @input="onInput" />
        <ul v-if="focus && suggestions.length > 0" class="list-unstyled autocomplete-dropdown">
            <li v-for="option in suggestions" :key="option.id">
                <a href="#" class="autocomplete-option" @click.prevent="setOption(option)">
                    {{ option.text }}
                </a>
            </li>
        </ul>
        <ul v-if="focus && dirty && suggestions.length === 0" class="list-unstyled autocomplete-dropdown">
            <li class="autocomplete-option text-muted text-center">
                {{ $t('autocomplete.empty') }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        options: {
            type: Object
        },
        modelValue: {
            type: [Number, String]
        }
    },
    data () {
        return {
            focus: false,
            filter: '',
            dirty: false,
        }
    },
    mounted () {
        if (this.modelValue) {
            this.filter = this.options[this.modelValue]
        }
    },
    computed: {
        arrayOptions () {
            return Object.entries(this.options).map((e) => ( { id: e[0], text: e[1] } ))
        },

        suggestions () {
            const query = this.filter.toLowerCase()

            return this.arrayOptions.filter(item => item.text.toLowerCase().startsWith(query) && item.text !== this.filter).splice(0, 4)
        }
    },
    methods: {
        onBlur () {
            this.dirty = false
            setTimeout(() => this.focus = false, 200)
        },

        onFocus () {
            this.focus = true
            this.$refs.inputRef.$el.select()
        },

        onInput (e) {
            this.dirty = true
            this.filter = e.target.value
        },

        setOption ({ id, text }) {
            this.dirty = false
            this.filter = text

            this.$emit('change', id)
            this.$emit('update:modelValue', id)
        }
    }
}
</script>
