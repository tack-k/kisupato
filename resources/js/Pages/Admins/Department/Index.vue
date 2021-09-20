<template>
    <main-layout>
        <template #content>
            <form @submit.prevent="submitKeyword">
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
                                    <square-search v-model="tableKeyword" placeholder="テーブル内検索"/>
                                    <p class="text-center">部署一覧</p>
                                </div>
                            </th>
                        </tr>
                        <tr class="base-th-tr">
                            <th class="base-th-th" v-if="canDelete">
                                <form @submit.prevent="submitDelete(formDelete.checked)">
                                    <div class="flex items-center">
                                        <checkbox v-model="allChecked" :checked="allChecked" />
                                        <button type="submit" :class="{ 'opacity-25': formDelete.processing }" :disabled="formDelete.processing">
                                            <Fa :icon="faTrashAlt" class="ml-3 admin-hover" size="lg" />
                                        </button>
                                    </div>
                                </form>
                            </th>
                            <th class="base-th-th" >
                                <div class="flex items-center">
                                    <p class="mr-2">部署名</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortNameUp" :class="{ 'admin-text-active': sortStatus.nameUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortNameDown" :class="{ 'admin-text-active': sortStatus.nameDown }"/>
                                </div>
                            </th>
                            <th class="base-th-th" >
                                <div class="flex items-center">
                                    <p class="mr-2">更新年月日</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortUpdatedAtUp" :class="{ 'admin-text-active': sortStatus.updatedAtUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortUpdatedAtDown" :class="{ 'admin-text-active': sortStatus.updatedAtDown }"/>
                                </div>
                            </th>
                            <th class="base-th-th" >
                                <div class="flex items-center">
                                    <p class="mr-2">登録年月日</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortCreatedAtUp" :class="{ 'admin-text-active': sortStatus.createdAtUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortCreatedAtDown" :class="{ 'admin-text-active': sortStatus.createdAtDown }"/>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(department, index) in searchDepartments" :key="index"
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
                        </tr>

                        </tbody>
                    </table>
                </div>

                <Pagination :paginations="paginations"/>

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
import {ref, reactive, computed, watch} from "vue";
import RoundSearch from "@/Components/Forms/RoundSearch";
import SquareSearch from "@/Components/Forms/SquareSearch";
import {useForm} from "@inertiajs/inertia-vue3"
import FlashMessage from "@/Components/Messages/FlashMessage";
import Checkbox from "@/Components/Forms/Checkbox";
import Fa from "vue-fa";
import { faTrashAlt, faCaretSquareUp, faCaretSquareDown } from "@fortawesome/free-solid-svg-icons";
import MainLayout from "@/Layouts/Admins/MainLayout";
import moment from "moment";

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
    },

    props: {
        departments: Object,
        keyword: String,
        canCreate: Boolean,
        canDelete: Boolean,
    },

    setup(props) {
        const sideBarLists = props.sideBarLists
        const keyword = props.keyword
        const NO_RESULTS = -1
        const NO_VALUE = 0
        const NEXT = '次 &raquo'
        let departments = props.departments['data']
        let paginations = props.departments['links']

        //テーブル内検索
        let tableKeyword = ref('')

        const searchDepartments = computed(() => {
            let filteredDepartments = reactive([])

            for (const i in departments) {
                let department = departments[i]
                if (
                    department.name.indexOf(tableKeyword.value) !== NO_RESULTS
                ) {
                    filteredDepartments.push(department)
                }
            }
            return filteredDepartments
        })

        //テーブル内検索時にチェックボックス選択結果を検索結果と一致させる
        watch(searchDepartments, (newval, oldval) => {
            const departmentIds = newval.map(department => department.id)
            const deleteIds = formDelete.checked.map(deleteId => deleteId)
            const allValues = [...departmentIds, ...deleteIds]
            const duplicatedValues = allValues.filter(allValue => departmentIds.includes(allValue) && deleteIds.includes(allValue))

            formDelete.checked = [...new Set(duplicatedValues)];

        })


        //キーワード検索
        const formKeyword = useForm({
            keyword: '',
        })

        const submitKeyword = () => {
            formKeyword.get(route('admin.department.index'), {
                onSuccess: () => {
                    formKeyword.reset()
                }
            })
        }


        //選択削除
        const formDelete = useForm({
            checked: [],
            page: null,
            keyword: keyword
        })

        //選択削除後の画面遷移先の設定
        const getAfterDeletePageParam = () => {
            paginations.forEach((index) => {
                if(index.active) {
                    formDelete.page = index.label
                }
                //最終ページを全削除した場合、最後の前のページに遷移
                if(index.url === null && index.label === NEXT && formDelete.checked.length === departments.length) {
                    formDelete.page -= 1
                }
            })
        }

        //選択削除のデータ送信
        const submitDelete = () => {
            if(formDelete.checked.length === NO_VALUE ) {
                return confirm('削除する部署を選択してください')
            }
            getAfterDeletePageParam()
            formDelete.post(route('admin.department.delete'),{
                onBefore: () => confirm('選択した部署を本当に削除しますか？')
            })
        }

        //全選択
        const allChecked = computed({
            get: () => {
                return formDelete.checked.length === searchDepartments.value.length && searchDepartments.value.length !== 0
            },
            set: (val) => {
                if (val) {
                    formDelete.checked = searchDepartments.value.map((department) => department.id);
                } else {
                    formDelete.checked = [];
                }
            }
        });

        //ソート
        let sortStatus = reactive({
            nameUp: false,
            nameDown: false,
            createdAtUp: false,
            createdAtDown: false,
            updatedAtUp: false,
            updatedAtDown: false,
        })

        const resetSortStatus = () => {
            sortStatus.nameUp = false
            sortStatus.nameDown = false
            sortStatus.createdAtUp = false
            sortStatus.createdAtDown = false
            sortStatus.updatedAtUp = false
            sortStatus.updatedAtDown = false
        }

        // データ取得時の作成日順にソート
        const sortDefault = () => {
            searchDepartments.value.sort((a, b) => {
                if(a.created_at < b.created_at) {
                    return 1
                } else if (a.created_at > b.created_at){
                    return -1
                } else {
                    return 0
                }
            })
        }

        const sortNameUp = () => {
            if(sortStatus.nameUp) {
                sortDefault()
                sortStatus.nameUp = false
                return
            }

            searchDepartments.value.sort((a, b) => {
                if(a.name > b.name) {
                    return 1
                } else if (a.name < b.name){
                    return -1
                } else {
                    return 0
                }
            })

            resetSortStatus()
            sortStatus.nameUp = true
        }

        const sortNameDown = () => {
            if(sortStatus.nameDown) {
                sortDefault()
                sortStatus.nameDown = false
                return
            }

            searchDepartments.value.sort((a, b) => {
                if(a.name < b.name) {
                    return 1
                } else if (a.name > b.name){
                    return -1
                } else {
                    return 0
                }
            })
            resetSortStatus()
            sortStatus.nameDown = true
        }

        const sortCreatedAtUp = () => {
            if(sortStatus.createdAtUp) {
                sortDefault()
                sortStatus.createdAtUp = false
                return
            }

            searchDepartments.value.sort((a, b) => {
                if(a.created_at > b.created_at) {
                    return 1
                } else if (a.created_at < b.created_at){
                    return -1
                } else {
                    return 0
                }
            })

            resetSortStatus()
            sortStatus.createdAtUp = true
        }

        const sortCreatedAtDown = () => {
            if(sortStatus.createdAtDown) {
                sortDefault()
                sortStatus.createdAtDown = false
                return
            }

            searchDepartments.value.sort((a, b) => {
                if(a.created_at < b.created_at) {
                    return 1
                } else if (a.created_at > b.created_at){
                    return -1
                } else {
                    return 0
                }
            })
            resetSortStatus()
            sortStatus.createdAtDown = true
        }

        const sortUpdatedAtUp = () => {
            if(sortStatus.updatedAtUp) {
                sortDefault()
                sortStatus.updatedAtUp = false
                return
            }

            searchDepartments.value.sort((a, b) => {
                if(a.updated_at > b.updated_at) {
                    return 1
                } else if (a.updated_at < b.updated_at){
                    return -1
                } else {
                    return 0
                }
            })

            resetSortStatus()
            sortStatus.updatedAtUp = true
        }

        const sortUpdatedAtDown = () => {
            if(sortStatus.updatedAtDown) {
                sortDefault()
                sortStatus.updatedAtDown = false
                return
            }

            searchDepartments.value.sort((a, b) => {
                if(a.updated_at < b.updated_at) {
                    return 1
                } else if (a.updated_at > b.updated_at){
                    return -1
                } else {
                    return 0
                }
            })
            resetSortStatus()
            sortStatus.updatedAtDown = true
        }

        //日付のフォーマット
        const formatDate = (date) => {
            return moment(date).format('YYYY年MM月DD日')
        }


        return {
            sideBarLists,
            paginations,
            tableKeyword,
            searchDepartments,
            formKeyword,
            submitKeyword,
            faTrashAlt,
            formDelete,
            submitDelete,
            getAfterDeletePageParam,
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

        }
    },



}
</script>

<style scoped>

</style>
