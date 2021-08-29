<template>
    <form @submit.prevent="onSubmit">
        {{ errors }}

        <div v-for="(field, index) of fields" :key="index">
            <l-field :name="field.name" :label="field.label">
                <l-text
                    v-model="form[field.name]"
                    :name="field.name"
                    :placeholder="field.placeholder"
                />
            </l-field>
        </div>
        <button type="submit">Submit</button>
    </form>
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

            this.form.submit(method, this.route, {})
            this.$emit('submited')
        }
    }
}
</script>
