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
            <div v-if="! loading && ! previewUrl" class="media-empty mt-auto">
                <div v-if="! isDragover">
                    <div class="fw-bold">{{ $t('media.dragndrop') }}</div>
                    <div class="fs-6 text-muted">{{ $t('media.empty') }} <a href="#" class="text-muted" @click.prevent="openBrowser">{{ $t('media.browser') }}</a></div>
                    <div v-if="error" class="fs-6 text-danger mt-3">{{ error }}</div>
                </div>
                <div v-else class="fs-5">{{ $t('media.drop') }}</div>
                <input
                    ref="inputFile"
                    type="file"
                    class="media-input"
                    :accept="options.mimes.map(item => `.${item}`).join(',')"
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
        add (e) {
            this.isDragover = false

            this.upload(e.dataTransfer.files[0])
        },

        remove () {
            this.previewUrl = null
            this.$emit('update:modelValue', null)
        },

        onInput (e) {
            this.isDragover = false

            this.upload(e.target.files[0])
        },

        openBrowser () {
            this.$refs.inputFile.click()
        },

        setError (error) {
            this.error = error
            this.isDragover = false

            return false
        },

        validateSize (size) {
            return size <= this.options.maxSize
        },

        validateType (name) {
            const exts = this.options.mimes.join('|')

            return name.match(new RegExp(`.(${exts})$`, 'gi'))
        },

        validate (file) {
            if (! (file instanceof File)) {
                return this.setError('Please enter a valid file')
            }

            if (! this.validateType(file.name)) {
                return this.setError(`Invalid file format (available ${this.options.mimes.join(', ')})`)
            }

            if (! this.validateSize(file.size)) {
                return this.setError(`File size is greater than ${this.getFileSize(this.options.maxSize)}`)
            }

            return true
        },

        getFileSize (value) {
            const kilo = (parseInt(value) / 10000)

            if (kilo > 1000) {
                return `${(kilo / 10).toFixed(2)} MB`
            }

            return `${kilo.toFixed(2)} kB`
        },

        async upload (file) {
            if (! this.validate(file)) {
                return
            }

            this.error = null
            this.loading = true

            const formData = new FormData()
            formData.append('file', file)
            formData.append('options', JSON.stringify(this.options))

            try {
                const { data } = await Axios.post(`/cms/media/${this.options.mediaGroup}`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })

                this.previewUrl = data.data.url
                this.$emit('update:modelValue', data.data.id)
            } catch (e) {
                if (e.response && e.response.status === 422) {
                    const data = e.response.data

                    this.setError(data.errors.file[0])
                }
            } finally {
                this.loading = false
            }
        }
    }
}
</script>
