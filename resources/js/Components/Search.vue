<template>
    <form class="search" @submit.prevent="onSubmit">
        <div class="input-group">
            <input v-model="query" type="text" name="query" class="form-control" />
            <l-btn type="submit" variant="secondary">
                {{ $t('btn.search') }}
            </l-btn>
        </div>
    </form>
</template>

<script>
export default {
    data () {
        return {
            query: ''
        }
    },
    mounted () {
        const searchParms = new URLSearchParams(window.location.search)

        if (searchParms.get('query')) {
            this.query = searchParms.get('query')
        }
    },
    methods: {
        onSubmit () {
            this.$inertia.get(this.$page.url, {
                query: this.query
            })
        }
    }
}
</script>
