<template>
    <Header/>
    <div class="flex">
        <sideBar :sideBarLists="sideBarLists"/>
        <div class="container p-4 lg:p-40">

            <FlashMessage />

            <form @submit.prevent="submitKeyword">
                <RoundSearch v-model="form.keyword" placeholder="全体検索"/>
            </form>
            <admin-register-modal :authorities="authorities" :departments="departments"></admin-register-modal>

            <div class="container mx-auto pt-4 py-16 ">
                <div class="container">
                    <div style="overflow-x:auto;">
                        <table class="w-full shadow-lg rounded admin-bg-white table">
                            <thead>
                            <tr class="text-left border-b border-grey uppercase table-row">
                                <th colspan="4" class="p-1 table-cell">
                                    <square-search v-model="tableKeyword" placeholder="テーブル内検索"/>
                                </th>
                                <th class="table-cell">
                                    <p class="text-center">職員一覧</p>
                                </th>
                            </tr>
                            <tr class="text-left border-b border-grey uppercase text-gray-50 bg-blue-800 table-row">
                                <th class="px-2 py-6 table-cell"></th>
                                <th class="table-cell">職員番号</th>
                                <th class="table-cell">氏名</th>
                                <th class="table-cell">部署</th>
                                <th class="table-cell">権限</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(admin, index) in searchAdmins" :key="index"
                                class="accordion border-b border-grey-light admin-hover-white table-row">
                                <td class="px-3 py-4 table-cell">
                                    <input type="checkbox"
                                           class="border-1 ml-1 w-5 h-5 flex flex-shrink-0">
                                </td>
                                <td class="table-cell">
                                    <p class="">{{ admin.staff_number }}</p>
                                </td>
                                <td class="table-cell">
                                    <p class="">{{ admin.last_name }}{{ admin.first_name }}</p>
                                </td>
                                <td class="table-cell">
                                    <p class="">{{ admin.department_name }}</p>
                                </td>
                                <td class="table-cell">
                                    <p class="">{{ admin.authority_name }}</p>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                    <Pagination :paginations="paginations"/>

                </div>
            </div>

        </div>
    </div>
</template>


<script>
import SideBar from "@/Layouts/Admins/SideBar";
import Header from "@/Layouts/Admins/Header";
import AdminRegisterModal from "@/Layouts/Admins/AdminRegisterModal";
import AdminAuthenticated from "@/Layouts/AdminAuthenticated";
import Pagination from "@/Components/Paginations/Pagination";
import {ref, reactive, computed} from "vue";
import RoundSearch from "@/Components/Forms/RoundSearch";
import SquareSearch from "@/Components/Forms/SquareSearch";
import {useForm} from "@inertiajs/inertia-vue3"
import FlashMessage from "@/Components/Messages/FlashMessage";

export default {
    name: "Index",

    components: {
        FlashMessage,
        SquareSearch,
        RoundSearch,
        AdminAuthenticated,
        Header,
        SideBar,
        AdminRegisterModal,
        Pagination,
    },

    props: {
        sideBarLists: Object,
        authorities: Object,
        departments: Object,
        admins: Object,
    },

    setup(props) {
        const sideBarLists = props.sideBarLists
        const authorities = props.authorities
        const departments = props.departments
        const NORESULTS = -1
        let admins = props.admins['data']
        let paginations = props.admins['links']


        //テーブル内検索
        let tableKeyword = ref('')
        const searchAdmins = computed(() => {
            let filteredAdmins = reactive([])

            for (const i in admins) {
                let admin = admins[i]

                if (
                    admin.last_name.indexOf(tableKeyword.value) !== NORESULTS ||
                    admin.first_name.indexOf(tableKeyword.value) !== NORESULTS ||
                    admin.staff_number.indexOf(tableKeyword.value) !== NORESULTS ||
                    admin.department_name.indexOf(tableKeyword.value) !== NORESULTS ||
                    admin.authority_name.indexOf(tableKeyword.value) !== NORESULTS
                ) {
                    filteredAdmins.push(admin)
                }
            }
            return filteredAdmins
        })

        const form = useForm({
            keyword: '',
        })

        const submitKeyword = () => {
            form.get(route('admin.index'), {
                onSuccess: () => {
                    form.reset()
                }
            })
        }

        return {
            sideBarLists,
            paginations,
            tableKeyword,
            searchAdmins,
            form,
            submitKeyword,
        }
    },


}
</script>

<style scoped lang="scss">

</style>
