<template>
    <main-layout>
        <template #content>
            <form @submit.prevent="submitKeyword(keywordUrl)">
                <RoundSearch v-model="formKeyword.keyword" placeholder="全体検索"/>
            </form>
            <admin-register-modal v-if="canCreate" :authorities="authorities" :departments="departments"></admin-register-modal>
            <div class="container mx-auto pt-4 py-16 ">
                <div class="container">
                    <table class="base-table">
                        <thead>
                        <tr class="base-th-tr-search">
                            <th colspan="5" class="p-1 table-cell">
                                <div class="flex items-center flex-col-reverse md:justify-between md:flex-row md:mr-6">
                                    <square-search v-model="tableKeyword" placeholder="テーブル内検索"/>
                                    <p class="text-center">職員一覧</p>
                                </div>
                            </th>
                        </tr>
                        <tr class="base-th-tr">
                            <th v-if="canDelete" class="base-th-th">
                                <form @submit.prevent="submitDelete(deleteUrl, I_SELECT_ADMIN, I_DELETE_ADMIN)">
                                    <div class="flex items-center">
                                        <checkbox v-model="allChecked" :checked="allChecked"/>
                                        <button type="submit" :class="{ 'opacity-25': formDelete.processing }" :disabled="formDelete.processing">
                                            <Fa :icon="faTrashAlt" class="ml-3 admin-hover" size="lg"/>
                                        </button>
                                    </div>
                                </form>
                            </th>
                            <th class="base-th-th">
                                <div class="flex items-center">
                                    <p class="mr-2">職員番号</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortStaffUp" :class="{ 'admin-text-active': sortStatus.staffUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortStaffDown" :class="{ 'admin-text-active': sortStatus.staffDown }"/>
                                </div>
                            </th>
                            <th class="base-th-th">
                                <div class="flex items-center">
                                    <p class="mr-2">氏名</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortKanaNameUp" :class="{ 'admin-text-active': sortStatus.nameUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortKanaNameDown" :class="{ 'admin-text-active': sortStatus.nameDown }"/>
                                </div>
                            </th>
                            <th class="base-th-th">
                                <div class="flex items-center">
                                    <p class="mr-2">部署</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortDepartmentUp" :class="{ 'admin-text-active': sortStatus.departmentUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortDepartmentDown" :class="{ 'admin-text-active': sortStatus.departmentDown }"/>
                                </div>
                            </th>
                            <th class="base-th-th">
                                <div class="flex items-center">
                                    <p class="mr-2">権限</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortAuthorityUp" :class="{ 'admin-text-active': sortStatus.authorityUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortAuthorityDown" :class="{ 'admin-text-active': sortStatus.authorityDown }"/>
                                </div>
                            </th>
                            <th class="base-th-th">
                                <p class="text-center">編集</p>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(searchedTableContent, index) in searchedTableContents" :key="index"
                            class="base-tb-tr">
                            <td v-if="canDelete" class="base-tb-td">
                                <checkbox :value="searchedTableContent.id" v-model:checked="formDelete.checked"/>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ searchedTableContent.staff_number }}</p>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ searchedTableContent.last_name }}{{ searchedTableContent.first_name }}</p>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ searchedTableContent.department_name }}</p>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ searchedTableContent.authority_name }}</p>
                            </td>
                            <td class="base-tb-td">
                                <div class="flex justify-center">
                                    <Link :href="route('admin.edit', searchedTableContent.id)" as="button" methods="get">
                                        <Fa :icon="faEdit" class="admin-hover"/>
                                    </Link>
                                </div>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>

                <Pagination :paginations="links"/>

            </div>
        </template>
    </main-layout>
</template>


<script>
import SideBar from "@/Layouts/Admins/SideBar";
import Header from "@/Layouts/Admins/Header";
import AdminRegisterModal from "@/Layouts/Admins/AdminRegisterModal";
import AdminAuthenticated from "@/Layouts/AdminAuthenticated";
import Pagination from "@/Components/Paginations/Pagination";
import { ref, reactive, computed, toRefs } from "vue";
import RoundSearch from "@/Components/Forms/RoundSearch";
import SquareSearch from "@/Components/Forms/SquareSearch";
import { Link } from "@inertiajs/inertia-vue3"
import FlashMessage from "@/Components/Messages/FlashMessage";
import Checkbox from "@/Components/Forms/Checkbox";
import Fa from "vue-fa";
import { faTrashAlt, faCaretSquareUp, faCaretSquareDown } from "@fortawesome/free-solid-svg-icons";
import MainLayout from "@/Layouts/Admins/MainLayout";
import useTableAction from "@/Composables/useTableAction"
import { faEdit } from "@fortawesome/free-regular-svg-icons";
import useCommonAction from '@/Composables/useCommonAction'
import { messageConst } from '@/Consts/messageConst'

export default {
    name: "Index",

    components: {
        MainLayout,
        Checkbox,
        FlashMessage,
        SquareSearch,
        RoundSearch,
        AdminAuthenticated,
        Header,
        SideBar,
        AdminRegisterModal,
        Pagination,
        Fa,
        Link,
    },

    props: {
        sideBarLists: Object,
        authorities: Object,
        departments: Object,
        admins: Object,
        keyword: String,
        canCreate: Boolean,
        canDelete: Boolean,
    },

    setup(props) {
        const keyword = props.keyword
        const NO_RESULTS = -1
        const { data, links } = toRefs(props.admins)
        const { I_SELECT_ADMIN, I_DELETE_ADMIN } = messageConst


        //テーブル内検索
        let tableKeyword = ref('')

        const searchedTableContents = computed(() => {
            let filteredTableContents = reactive([])

            for (const i in data.value) {
                let searchedTableContent = data.value[i]
                if (
                    searchedTableContent.last_name.indexOf(tableKeyword.value) !== NO_RESULTS ||
                    searchedTableContent.first_name.indexOf(tableKeyword.value) !== NO_RESULTS ||
                    searchedTableContent.staff_number.indexOf(tableKeyword.value) !== NO_RESULTS ||
                    searchedTableContent.department_name.indexOf(tableKeyword.value) !== NO_RESULTS ||
                    searchedTableContent.authority_name.indexOf(tableKeyword.value) !== NO_RESULTS
                ) {
                    filteredTableContents.push(searchedTableContent)
                }
            }
            return filteredTableContents
        })

        //ソート
        let sortStatus = reactive({
            staffUp: false,
            staffDown: false,
            nameUp: false,
            nameDown: false,
            departmentUp: false,
            departmentDown: false,
            authorityUp: false,
            authorityDown: false,
        })

        const resetSortStatus = () => {
            sortStatus.staffUp = false
            sortStatus.staffDown = false
            sortStatus.nameUp = false
            sortStatus.nameDown = false
            sortStatus.departmentUp = false
            sortStatus.departmentDown = false
            sortStatus.authorityUp = false
            sortStatus.authorityDown = false
        }

        //送信先
        const keywordUrl = route('admin.index')
        const deleteUrl = route('admin.delete')

        const {
            allChecked,
            submitDelete,
            formDelete,
            formKeyword,
            submitKeyword,
            sortStaffUp,
            sortStaffDown,
            sortDepartmentUp,
            sortDepartmentDown,
            sortAuthorityUp,
            sortAuthorityDown,
            sortKanaNameUp,
            sortKanaNameDown,
        } = useTableAction(keyword, searchedTableContents, links, data, sortStatus, resetSortStatus)

        return {
            links,
            tableKeyword,
            formKeyword,
            submitKeyword,
            faTrashAlt,
            formDelete,
            submitDelete,
            allChecked,
            faCaretSquareUp,
            faCaretSquareDown,
            sortStatus,
            sortKanaNameUp,
            sortKanaNameDown,
            sortStaffUp,
            sortStaffDown,
            sortDepartmentUp,
            sortDepartmentDown,
            sortAuthorityUp,
            sortAuthorityDown,
            faEdit,
            deleteUrl,
            keywordUrl,
            I_DELETE_ADMIN,
            I_SELECT_ADMIN,
            searchedTableContents,
        }
    },


}
</script>

<style scoped lang="scss">

</style>
