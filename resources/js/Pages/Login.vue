<template>
    <app>
        <h2 class="h4 mb-4">Login</h2>
        <form @submit.prevent="onSubmit">
            <l-field name="email" :error="errors.email">
                <l-input
                    v-model="form.email"
                    name="email"
                    :hasError="errors.email != undefined"
                    :placeholder="$t('auth.username')"
                />
            </l-field>
            <l-password
                v-model="form.password"
                name="password"
                class="mt-3"
                :placeholder="$t('auth.password')"
            />
            <l-btn type="submit" class="mt-3">
                {{ $t('btn.submit') }}
            </l-btn>
        </form>
    </app>
</template>

<script>
import App from '@/Layouts/Auth'

export default {
    components: {
        App
    },
    props: {
        errors: Object,
    },
    data () {
        return {
            form: {
                email: null,
                password: null
            }
        }
    },
    methods: {
        onSubmit () {
            this.$inertia.post('login', this.form)
        }
    }
}
</script>
