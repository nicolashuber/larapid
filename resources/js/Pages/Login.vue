<template>
    <app>
        <h2 class="h4 mb-4">Login</h2>
        <form @submit.prevent="onSubmit">
            <l-input
                v-model="form.email"
                placeholder="Email"
            />
            {{ errors.email }}
            <l-password
                v-model="form.password"
                class="mt-3"
                placeholder="Password"
            />
            <l-btn type="submit" class="mt-3">
                Submit
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
