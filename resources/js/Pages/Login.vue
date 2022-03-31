<template>
    <app>
        <h2 class="h4 mb-4">Login</h2>
        <form @submit.prevent="onSubmit">
            <l-field name="email" :error="errors.email">
                <l-input
                    v-model="form.email"
                    :hasError="errors.email != undefined"
                    :placeholder="$t('auth.username')"
                />
            </l-field>
            <l-password
                v-model="form.password"
                class="mt-3"
                :placeholder="$t('auth.password')"
            />
            <l-btn type="submit" class="mt-3">
                {{ $t('btn.submit') }}
            </l-btn>
            <div v-if="poweredBy.url" class="text-center mt-4 powered-by">
                <div class="text-muted mb-1">Powered by</div>
                <img :src="poweredBy.url" class="powered-by-img" alt="poweredBy.name">
            </div>
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
        poweredBy: Object
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

<style lang="scss">
    .powered-by {
        font-size: .675rem;

        &-img {
            height: 40px;
            object-fit: contain;
        }
    }
</style>
