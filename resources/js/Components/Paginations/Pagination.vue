<template>
    <div v-if="paginations.length > 3">
        <div class="flex flex-wrap justify-center mt-16">
            <template v-for="(pagination, index) in paginations" :key="index">
                <div v-if="pagination.url === null"  class="flex items-center mr-1 px-4 text-sm text-gray-400 border rounded" v-html="pagination.label" />
                <inertia-link v-else class="flex items-center mr-1 px-4 text-sm border rounded hover:bg-white focus:border-indigo-500 focus:text-indigo-500" :class="{ 'bg-blue-700 text-white': pagination.active }" :href="pagination.url" v-html="pagination.label" />
            </template>
        </div>
    </div>
</template>

<script>
import InertiaLink from "@/Components/NavLink"
import AdminAuthenticated from "@/Layouts/AdminAuthenticated";
import Header from "@/Layouts/Admins/Header";
import SideBar from "@/Layouts/Admins/SideBar";
import AdminRegisterModal from "@/Layouts/Admins/AdminRegisterModal";

export default {
    name: "Pagination",

    components: {
        InertiaLink,
    },
    props: {
        paginations: Object
    },

    setup(props) {
            let paginations = props.paginations

        return {
                paginations,
        }
    }
}
</script>

<style scoped>

</style>
