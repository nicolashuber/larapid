<template>
    <div>
        <QuillEditor
            theme="snow"
            content-type="html"
            :options="options"
            :placeholder="placeholder"
            :content="modelValue"
            @update:content="onEditorChange"
        />
    </div>
</template>

<script>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';

export default {
    components: {
        QuillEditor
    },
    props: {
        options: {
            type: Object,
            default () {
                return {}
            }
        },
        modelValue: {
            type: [Number, String]
        },
        placeholder: {
            type: String
        }
    },
    computed: {
        toolbar () {
            if (this.options.simpleToolbar) {
                return ['bold', 'italic', 'underline', 'strike']
            }

            return true
        },

        options () {
            return {
                modules: {
                    toolbar: this.toolbar
                }
            }
        }
    },
    methods: {
        onEditorChange (html) {
            this.$emit('update:modelValue', html)
        }
    }
}
</script>


<style lang="scss">
    .ql-container {
        height: 130px;
    }
</style>
