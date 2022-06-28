<template>
    <div class="autocomplete">
        <l-input
            v-model="filter"
            ref="inputRef"
            :required="required"
            :has-error="hasError"
            @blur="onBlur"
            @focus="onFocus"
            @input="onInput"
        />
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
        maxResults: {
            type: Number,
            default: 4
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
        }
    },
    mounted () {
        if (this.isServerSearch) {
            this.filter = this.options.default
        } else if (this.modelValue) {
            this.filter = this.options.data[this.modelValue]
        }
    },
    computed: {
        arrayOptions () {
            const data = this.isServerSearch ? this.data : this.options.data

            if (Object.entries(data).length > 0) {
                return Object.entries(data).map((e) => ( { id: e[0], text: e[1] } ))
            }

            return {}
        },

        suggestions () {
            if (this.filter && this.arrayOptions.length > 0) {
                const query = this.filter.toLowerCase()

                return this.arrayOptions.filter(item => item.text && item.text.toLowerCase().includes(query) && item.text !== this.filter).splice(0, this.maxResults)
            }

            return []
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
            const { data } = await axios.get(`/cms/data/${this.options.entity}/search`, {
                params: {
                    query
                }
            })

            this.data = data
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
