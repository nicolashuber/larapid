<template>
  <div class="icon">
    <FontAwesomeIcon :icon="name" />
  </div>
</template>

<script>
import { library } from '@fortawesome/fontawesome-svg-core'
import { faBars, faClose, faSort, faSortUp, faSortDown, faMagnifyingGlass } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faBars, faClose, faSort, faSortUp, faSortDown, faMagnifyingGlass)

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
