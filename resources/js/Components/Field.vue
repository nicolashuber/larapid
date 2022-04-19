<template>
    <div class="mb-3" :class="{ 'row': horizontal }">
        <label v-if="label" :for="name" :class="labelClasses">
            {{ label }}
        </label>
        <div :class="{ 'col-sm-10': horizontal }">
            <slot />
            <div v-if="error" class="invalid-feedback">
                {{ error }}
            </div>
            <div v-if="help" class="form-text">
                {{ help }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        name: {
            type: String
        },
        label: {
            type: String
        },
        help: {
            type: String
        },
        error: {
            type: String
        },
        horizontal: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        labelClasses () {
            return {
                'col-sm-2': this.horizontal,
                'form-label': ! this.horizontal,
                'col-form-label': this.horizontal
            }
        }
    }
}
</script>
