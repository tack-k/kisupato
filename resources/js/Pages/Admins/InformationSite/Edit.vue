<template>
    <Create :informationSite="informationSite"/>
</template>

<script>
import Create from '@/Pages/Admins/InformationSite/Create'
import { toRefs } from 'vue'

export default {
    name: "Edit",
    components: { Create },
    props: {
        informationSite: Object
    },
    setup(props) {
        const { informationSite } = toRefs(props)

        return {
            informationSite,
        }
    }
}
</script>

<style scoped>

</style>
