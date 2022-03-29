<template>
    <div>
        <QuillEditor
            theme="snow"
            content-type="html"
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
        modelValue: {
            type: [Number, String]
        },
        placeholder: {
            type: String
        }
    },
    data () {
        return {
            options: {
                //
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
