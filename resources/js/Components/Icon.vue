<template>
  <div class="icon">
    <FontAwesomeIcon :icon="name" />
  </div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faSort, faSortUp, faSortDown } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faSort, faSortUp, faSortDown)

export default {
    components: {
        FontAwesomeIcon
    },
    props: {
        name: {
            type: String,
            required: true
        }
    }
}
</script>
