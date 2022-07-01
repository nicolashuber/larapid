<template>
    <div class="autocomplete">
        <l-input
            v-model="filter"
            ref="inputRef"
            :required="required"
            :has-error="hasError"
            :placeholder="placeholder"
            @blur="onBlur"
            @focus="onFocus"
            @input="onInput"
        />
        <ul v-show="focus && suggestions.length > 0" class="list-unstyled autocomplete-dropdown">
            <li v-for="option in suggestions" :key="option.id" class="autocomplete-option">
                <a href="#" class="text-decoration-none" @click.prevent="setOption(option)">
                    {{ option.text }}
                </a>
            </li>
        </ul>
        <ul v-if="focus && dirty && suggestions.length === 0" class="list-unstyled autocomplete-dropdown">
            <li class="autocomplete-option text-muted text-center">
                {{ loading ? $t('autocomplete.loading') : $t('autocomplete.empty') }}
            </li>
        </ul>
    </div>
</template>

<script>
import axios from 'axios'
import { debounce } from 'lodash'

export default {
    props: {
        options: {
            type: Object
        },
        modelValue: {
            type: [Number, String]
        },
        entity: {
            type: String,
        },
        isAjax: {
            type: Boolean,
            default: false
        },
        required: {
            type: Boolean,
            default: false
        },
        hasError: {
            type: Boolean,
            default: false
        },
    },
    data () {
        return {
            data: [],
            focus: false,
            filter: '',
            dirty: false,
            loading: false,
        }
    },
    beforeMount () {
        if (this.isServerSearch) {
            this.filter = this.options.default
        } else if (this.modelValue) {
            this.filter = this.options.data[this.modelValue]
        }
    },
    computed: {
        placeholder () {
            if (this.options.isAjax) {
                return this.$t('autocomplete.placeholder')
            }

            return this.$t('autocomplete.select')
        },

        arrayOptions () {
            const data = this.isServerSearch ? this.data : this.options.data

            return Object.entries(data).map((e) => ( { id: e[0], text: e[1] } ))
        },

        suggestions () {
            const options = [...this.arrayOptions]

            if (! this.filter || this.isServerSearch) {
                return options
            }

            const query = this.filter.toLowerCase()

            return options.filter(item => item.text && item.text.toLowerCase().includes(query) && item.text !== this.filter) || []
        },

        isServerSearch () {
            return this.options.entity && this.options.isAjax
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

            if (this.isServerSearch) {
                this.search(this.filter)
            }
        },

        search: debounce(async function (query) {
            this.loading = true

            try {
                const { data } = await axios.get(`/cms/data/${this.options.entity}/search`, {
                    params: { query }
                })

                this.data = data
            } finally {
                this.loading = false
            }
        }, 200),

        setOption ({ id, text }) {
            this.dirty = false
            this.filter = text

            this.$emit('change', id)
            this.$emit('update:modelValue', id)
        }
    }
}
</script>
