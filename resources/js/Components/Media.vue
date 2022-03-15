<template>
    <div class="media">
        <div
            draggable
            class="media-dragable d-flex align-items-center justify-content-center text-center"
            :class="{ 'is-dragover': isDragover }"
            @drop.prevent="add"
            @dragover.prevent="onDragover"
            @dragleave.prevent="isDragover = false"
        >
            <l-loading v-if="loading" />
            <div v-if="! loading && ! previewUrl" class="media-empty">
                <div v-if="! isDragover">
                    <div class="fw-bold">Drag & Drop</div>
                    <div class="fs-6 text-muted">your files here, or <a href="#" class="text-muted" @click.prevent="openBrowser">browser</a></div>
                </div>
                <div v-else class="fs-5">Drop!</div>
                <input
                    ref="inputFile"
                    type="file"
                    class="media-input"
                    :accept="options.accept.map(item => `.${item}`).join(',')"
                    @input="onInput"
                >
            </div>
            <div v-if="previewUrl" class="media-preview">
                <img alt="Preview" class="media-img" :src="previewUrl" :class="{ 'is-svg': isSvg }" />
                <button type="button" class="btn-close" aria-label="Close" @click.prevent="remove" />
            </div>
        </div>
    </div>
</template>

<script>
import Axios from 'axios'

export default {
    props: {
        options: {
            type: Object,
            required: true
        },
        modelValue: {
            type: Object
        },
    },
    data () {
        return {
            loading: false,
            isDragover: false,
            previewUrl: null
        }
    },
    mounted () {
        if (this.options.previewUrl) {
            this.previewUrl = this.options.previewUrl
        }
    },
    computed: {
        isSvg () {
            return this.previewUrl  && this.previewUrl.endsWith('.svg')
        }
    },
    methods: {
        onDragover (e) {
            console.log(e)
        },

        add (e) {
            this.loading = true
            this.isDragover = false

            this.upload(e.dataTransfer.files[0])
        },

        remove () {
            this.previewUrl = null
        },

        onInput (e) {
            this.loading = true
            this.isDragover = false

            this.upload(e.target.files[0])
        },

        openBrowser () {
            this.$refs.inputFile.click()
        },

        validateSize (size) {
            return size <= this.options.maxSize
        },

        validateType (name) {
            const exts = this.options.accept.join('|')

            return name.match(new RegExp(`.(${exts})$`, 'gi'))
        },

        validate (file) {
            if (! (file instanceof File)) {
                return this.setError('Please enter a valid file')
            }

            if (! this.validateSize(file.size)) {
                return this.setError(`File size is greater than ${this.options.maxSize} MB`)
            }

            if (! this.validateType(file.name)) {
                return this.setError(`Invalid file format (available ${this.options.accept.join(', ')})`)
            }
        },

        async upload (file) {
            const formData = new FormData()
            formData.append('file', file)

            const { data } = await Axios.post(`/cms/media/${this.options.mediaGroup}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })

            this.loading = false
            this.previewUrl = data.data.url
            this.$emit('update:modelValue', data.data.id)
        }
    }
}
</script>
