<template>
    <app :app="app">
        <l-page-header :title="$t('page.attach')">
            <l-btn v-if="backRoute" type="submit" variant="outline-secondary" :href="backRoute">
                {{ $t('btn.goback') }}
            </l-btn>
        </l-page-header>
        <l-panel>
            <form @submit.prevent="onSubmit" class="form">
                <l-field :label="$t('attach.label')" :error="errors.entity_id">
                    <l-autocomplete
                        v-model="form.entity_id"
                        required
                        name="entity_id"
                        :options="options"
                        :has-error="errors.entity_id != undefined"
                        :max-results="10"
                    />
                </l-field>
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
    </app>
</template>

<script>
import App from '@/Layouts/App'

export default {
    components: {
        App
    },
    props: {
        app: {
            type: Object,
            required: true
        },
        field: {
            type: Object,
            required: true
        },
        errors: {
            type: Object,
            required: true
        },
        route: {
            type: String,
            default: ''
        },
        backRoute: {
            type: String,
            default: ''
        }
    },
    data () {
        return {
            form: {
                id: null
            },
            options: {}
        }
    },
    beforeMount () {
        this.options = {
            isAjax: true,
            entity: this.field.entity
        }
    },
    methods: {
        onSubmit () {
            this.$inertia.post(this.route, {
                ...this.form,
                field: this.field.name,
                entity: this.field.entity
            })
        }
    }
}
</script>
