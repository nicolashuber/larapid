<template>
    <div class="app">
        <div class="auth">
            <slot />
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'

export default {
    components: {
        Link
    }
}
</script>
