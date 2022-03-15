<template>
    <div class="media">
        <div
            draggable
            class="media-dragable d-flex align-items-center justify-content-center text-center"
            :class="{ 'is-dragover': isDragover }"
            @drop.prevent="add"
            @dragover.prevent="isDragover = true"
            @dragleave.prevent="isDragover = false"
        >
            <l-loading v-if="loading" />
            <div v-if="! loading && ! previewUrl" class="media-empty">
                <div v-if="! isDragover">
                    <div class="fw-bold">Drag & Drop</div>
                    <div class="fs-6 text-muted">your files here, or <a href="#" class="text-muted" @click.prevent="openBrowser">browser</a></div>
                </div>
                <div v-else class="fs-5">Drop!</div>
                <input ref="inputFile" type="file" class="media-input" @input="onInput">
            </div>
            <div v-if="previewUrl" class="media-preview">
                <img class="media-img" :src="previewUrl" alt="Preview" />
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
    methods: {
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
