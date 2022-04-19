<template>
    <l-panel>
        <form @submit.prevent="onSubmit" class="form">
            <div v-for="(field, index) of fields" :key="index">
                <l-field
                    horizontal
                    :name="field.name"
                    :help="field.help"
                    :label="field.label"
                    :error="errors[field.name]"
                >
                    <component
                        v-model="form[field.name]"
                        :is="`l-${field.component}`"
                        :name="field.name"
                        :readonly="field.readOnly"
                        :options="field.options"
                        :hasError="errors[field.name] != undefined"
                        :placeholder="field.placeholder"
                    />
                </l-field>
            </div>
            <div class="form-footer d-flex justify-content-between">
                <l-btn v-if="backRoute" type="submit" variant="outline-secondary" :href="backRoute">
                    {{ $t('btn.goback') }}
                </l-btn>

                <l-btn type="submit" variant="primary">
                    {{ $t('btn.save') }}
                </l-btn>
            </div>
        </form>
    </l-panel>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3'

export default {
    props: {
        data: {
            type: Object
        },
        route: {
            type: String,
            required: true
        },
        errors: {
            type: Object,
            required: true
        },
        fields: {
            type: Object,
            required: true
        },
        backRoute: {
            type: String,
            default: ''
        }
    },
    data () {
        let form = this.data || {}

        if (! this.data) {
            const columns = Object.keys(this.fields)

            for (const column of columns) {
                form[column] = null
            }
        }

        return {
            form: useForm(form)
        }
    },
    methods: {
        onSubmit () {
            const method = this.form.id ? 'put' : 'post'
            const searchParms = new URLSearchParams(window.location.search)
            const query = searchParms.toString()
            const route = query ? `${this.route}?${query}` : this.route

            this.form.submit(method, route)
            this.$emit('submited')
        }
    }
}
</script>
