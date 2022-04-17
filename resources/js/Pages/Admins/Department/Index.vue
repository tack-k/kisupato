<template>
    <main-layout>
        <template #content>
            <form @submit.prevent="submitKeyword(keywordUrl)">
                <RoundSearch v-model="formKeyword.keyword" placeholder="全体検索"/>
            </form>
            <DepartmentRegisterModal v-if="canCreate"/>
            <div class="container mx-auto pt-4 py-16 ">
                <div class="container">
                    <table class="base-table">
                        <thead>
                        <tr class="base-th-tr-search">
                            <th colspan="5" class="p-1 table-cell">
                                <div class="flex items-center flex-col-reverse md:justify-between md:flex-row md:mr-6">
                                    <square-search v-model.lazy="tableKeyword" placeholder="テーブル内検索"/>
                                    <p class="text-center">部署一覧</p>
                                </div>
                            </th>
                        </tr>
                        <tr class="base-th-tr">
                            <th class="base-th-th" v-if="canDelete">
                                <form @submit.prevent="submitDelete(deleteUrl, I_SELECT_DEPARTMENT, I_DELETE_DEPARTMENT)">
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
                                    <p class="mr-2">部署名</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortNameUp" :class="{ 'admin-text-active': sortStatus.nameUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortNameDown" :class="{ 'admin-text-active': sortStatus.nameDown }"/>
                                </div>
                            </th>
                            <th class="base-th-th">
                                <div class="flex items-center">
                                    <p class="mr-2">更新年月日</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortUpdatedAtUp" :class="{ 'admin-text-active': sortStatus.updatedAtUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortUpdatedAtDown" :class="{ 'admin-text-active': sortStatus.updatedAtDown }"/>
                                </div>
                            </th>
                            <th class="base-th-th">
                                <div class="flex items-center">
                                    <p class="mr-2">登録年月日</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortCreatedAtUp" :class="{ 'admin-text-active': sortStatus.createdAtUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortCreatedAtDown" :class="{ 'admin-text-active': sortStatus.createdAtDown }"/>
                                </div>
                            </th>
                            <th class="base-th-th">
                                <p class="text-center">編集</p>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(department, index) in searchedTableContents" :key="index"
                            class="base-tb-tr">
                            <td class="base-tb-td" v-if="canDelete">
                                <checkbox :value="department.id" v-model:checked="formDelete.checked"/>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ department.name }}</p>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ formatDate(department.updated_at) }}</p>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ formatDate(department.created_at) }}</p>
                            </td>

                            <td class="base-tb-td">
                                <div class="flex justify-center">
                                    <Link :href="route('admin.department.edit', {'id': department.id})" as="button" methods="get">
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
import DepartmentRegisterModal from "@/Layouts/Admins/DepartmentRegisterModal";
import AdminAuthenticated from "@/Layouts/AdminAuthenticated";
import Pagination from "@/Components/Paginations/Pagination";
import { ref, reactive, computed, watch, toRefs } from "vue";
import RoundSearch from "@/Components/Forms/RoundSearch";
import SquareSearch from "@/Components/Forms/SquareSearch";
import { Link } from "@inertiajs/inertia-vue3"
import FlashMessage from "@/Components/Messages/FlashMessage";
import Checkbox from "@/Components/Forms/Checkbox";
import Fa from "vue-fa";
import { faTrashAlt, faCaretSquareUp, faCaretSquareDown } from "@fortawesome/free-solid-svg-icons";
import { faEdit } from "@fortawesome/free-regular-svg-icons"
import MainLayout from "@/Layouts/Admins/MainLayout";
import useTableAction from "@/Composables/useTableAction"
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
        DepartmentRegisterModal,
        Pagination,
        Fa,
        Link,
    },

    props: {
        departments: Object,
        keyword: String,
        canCreate: Boolean,
        canDelete: Boolean,
    },

    setup(props) {
        const keyword = props.keyword
        const NO_RESULTS = -1
        const { data, links } = toRefs(props.departments)
        const { I_SELECT_DEPARTMENT, I_DELETE_DEPARTMENT } = messageConst

        //テーブル内検索
        let tableKeyword = ref('')

        const searchedTableContents = computed(() => {
            let filteredTableContents = reactive([])

            for (const i in data.value) {
                let searchedTableContent = data.value[i]
                if (
                    searchedTableContent.name.indexOf(tableKeyword.value) !== NO_RESULTS
                ) {
                    filteredTableContents.push(searchedTableContent)
                }
            }
            return filteredTableContents
        })

        //ソートステータスを定義
        let sortStatus = reactive({
            nameUp: false,
            nameDown: false,
            createdAtUp: false,
            createdAtDown: false,
            updatedAtUp: false,
            updatedAtDown: false,
        })

        //ソート状態のリセット
        const resetSortStatus = () => {
            sortStatus.nameUp = false
            sortStatus.nameDown = false
            sortStatus.createdAtUp = false
            sortStatus.createdAtDown = false
            sortStatus.updatedAtUp = false
            sortStatus.updatedAtDown = false
        }


        //送信先
        const keywordUrl = route('admin.department.index')
        const deleteUrl = route('admin.department.delete')

        //日付のフォーマット
        const { formatDate } = useCommonAction()

        const {
            allChecked,
            submitDelete,
            formDelete,
            formKeyword,
            submitKeyword,
            sortNameUp,
            sortNameDown,
            sortCreatedAtUp,
            sortCreatedAtDown,
            sortUpdatedAtUp,
            sortUpdatedAtDown,
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
            sortNameUp,
            sortNameDown,
            sortCreatedAtUp,
            sortCreatedAtDown,
            sortUpdatedAtUp,
            sortUpdatedAtDown,
            formatDate,
            faEdit,
            searchedTableContents,
            deleteUrl,
            keywordUrl,
            I_DELETE_DEPARTMENT,
            I_SELECT_DEPARTMENT,
            resetSortStatus,
        }
    },


}
</script>

<style scoped>

</style>
