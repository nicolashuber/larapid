<template>
    <component :is="tag" v-bind="binding">
        <slot />
    </component>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link
    },
    props: {
        type: {
            type: String,
            default: 'button'
        },
        href: {
            type: String
        },
        size: {
            type: String,
        },
        variant: {
            type: String,
            default: 'primary'
        }
    },
    computed: {
        tag () {
            return this.href ? 'Link' : 'button'
        },

        classes () {
            return [
                'btn',
                `btn-${this.variant}`,
                this.size ? `btn-${this.size}` : ''
            ]
        },

        binding () {
            return {
                type: this.type,
                href: this.href,
                class: this.classes
            }
        }
    }
}
</script>
