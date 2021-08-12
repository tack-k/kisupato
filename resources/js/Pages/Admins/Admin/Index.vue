<template>
    <side-bar :sideBarLists="sideBarLists"/>
</template>


<script>
import SideBar from "@/Layouts/Admins/SideBar";

export default {
    name: "Index",

    components: {
        SideBar,
    },

    data() {
        return {

        }
    },

    props: {
        sideBarLists: Object,
    },
}
</script>

<style scoped>

</style>
