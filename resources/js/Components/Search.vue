<template>
    <form class="search" @submit.prevent="onSubmit">
        <div class="input-group">
            <input
                v-model="query"
                type="text"
                name="query"
                class="form-control"
                :placeholder="$t('btn.search')"
            />
            <l-btn type="submit" variant="secondary">
                <l-icon name="magnifying-glass" />
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
                page: 1,
                query: this.query,
            })
        }
    }
}
</script>

<style lang="scss">
    .search {
        input[type="text"] {
            max-width: 150px;
        }
    }
</style>
