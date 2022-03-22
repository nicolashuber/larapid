<template>
    <div v-if="items" class="notifications">
        <div v-for="(item, index) in items" :key="index" class="toast d-block align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ item.message }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close" @click="remove(item)"></button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    computed: {
        items () {
            return this.$store.state.toasts
        }
    },
    methods: {
        remove (item) {
            this.$store.dispatch('removeToast', item)
        }
    }
}
</script>
