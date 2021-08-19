<template>
    <Header/>
    <div class="flex">
        <sideBar :sideBarLists="sideBarLists"/>
        <div class="container p-40 bg-blue-50">
            <div class="flex relative w-80 items-center mb-3 ml-auto">
                <span class="text-center absolute left-4"><i class="fas fa-search"></i></span>
                <input type="text" class="rounded-full border-gray-200 focus:ring-blue-200 focus:ring w-full pl-10"/>
            </div>
            <admin-register-modal :authorities="authorities" :departments="departments"></admin-register-modal>
        </div>
    </div>
</template>


<script>
import SideBar from "@/Layouts/Admins/SideBar";
import Header from "@/Layouts/Admins/Header";
import AdminRegisterModal from "@/Layouts/Admins/AdminRegisterModal";
import AdminAuthenticated from "@/Layouts/AdminAuthenticated";

export default {
    name: "Index",

    components: {
        AdminAuthenticated,
        Header,
        SideBar,
        AdminRegisterModal,
    },

    props: {
        sideBarLists: Object,
        authorities: Object,
        departments: Object,
    },

    setup(props) {
        const sideBarLists = props.sideBarLists
        const authorities = props.authorities
        const departments = props.departments

        return {
            sideBarLists
        }
    },


}
</script>

<style scoped lang="scss">

</style>
