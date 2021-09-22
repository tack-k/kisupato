<template>
    <main-layout>
        <template #content>
            <form @submit.prevent="submitKeyword">
                <RoundSearch v-model="formKeyword.keyword" placeholder="全体検索"/>
            </form>
            <UserContactTitleRegisterModal v-if="canCreate"/>
            <div class="container mx-auto pt-4 py-16 ">
                <div class="container">
                    <table class="base-table">
                        <thead>
                        <tr class="base-th-tr-search">
                            <th colspan="5" class="p-1 table-cell">
                                <div class="flex items-center flex-col-reverse md:justify-between md:flex-row md:mr-6">
                                    <square-search v-model="tableKeyword" placeholder="テーブル内検索"/>
                                    <p class="text-center">ユーザーお問い合わせ項目一覧</p>
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
                                    <p class="mr-2">ユーザーお問い合わせ項目名</p>
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
                            <th class="base-th-th" >
                                <p class="text-center">編集</p>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(userContactTitle, index) in searchUserContactTitles" :key="index"
                            class="base-tb-tr">
                            <td class="base-tb-td" v-if="canDelete">
                                <checkbox :value="userContactTitle.id" v-model:checked="formDelete.checked"/>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ userContactTitle.name }}</p>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ formatDate(userContactTitle.updated_at) }}</p>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ formatDate(userContactTitle.created_at) }}</p>
                            </td>

                            <td class="base-tb-td">
                                <div class="flex justify-center">
                                    <Link :href="route('admin.userContactTitle.edit', {'id': userContactTitle.id})" as="button" methods="get"><Fa :icon="faEdit" class="admin-hover"/></Link>
                                </div>
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
import UserContactTitleRegisterModal from "@/Layouts/Admins/UserContactTitleRegisterModal";
import AdminAuthenticated from "@/Layouts/AdminAuthenticated";
import Pagination from "@/Components/Paginations/Pagination";
import {ref, reactive, computed, watch} from "vue";
import RoundSearch from "@/Components/Forms/RoundSearch";
import SquareSearch from "@/Components/Forms/SquareSearch";
import {useForm, Link} from "@inertiajs/inertia-vue3"
import FlashMessage from "@/Components/Messages/FlashMessage";
import Checkbox from "@/Components/Forms/Checkbox";
import Fa from "vue-fa";
import { faTrashAlt, faCaretSquareUp, faCaretSquareDown } from "@fortawesome/free-solid-svg-icons";
import { faEdit } from "@fortawesome/free-regular-svg-icons"
import MainLayout from "@/Layouts/Admins/MainLayout";
import moment from "moment";
import useTableAction from "@/Composables/useTableAction"


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
        UserContactTitleRegisterModal,
        Pagination,
        Fa,
        Link,
    },

    props: {
        sideBarLists: Object,
        userContactTitles: Object,
        keyword: String,
        canCreate: Boolean,
        canDelete: Boolean,
    },

    setup(props) {
        const sideBarLists = props.sideBarLists
        const keyword = props.keyword
        const NO_RESULTS = -1
        const NO_VALUE = 0
        let userContactTitles = props.userContactTitles['data']
        let paginations = props.userContactTitles['links']

        //テーブル内検索
        let tableKeyword = ref('')

        const searchUserContactTitles = computed(() => {
            let filteredUserContactTitles = reactive([])

            for (const i in userContactTitles) {
                let userContactTitle = userContactTitles[i]
                if (
                    userContactTitle.name.indexOf(tableKeyword.value) !== NO_RESULTS
                ) {
                    filteredUserContactTitles.push(userContactTitle)
                }
            }
            return filteredUserContactTitles
        })

        //テーブル内検索時にチェックボックス選択結果を検索結果と一致させる
        watch(searchUserContactTitles, (newval, oldval) => {
            const userContactTitleIds = newval.map(userContactTitle => userContactTitle.id)
            const deleteIds = formDelete.checked.map(deleteId => deleteId)
            const allValues = [...userContactTitleIds, ...deleteIds]
            const duplicatedValues = allValues.filter(allValue => userContactTitleIds.includes(allValue) && deleteIds.includes(allValue))

            formDelete.checked = [...new Set(duplicatedValues)];

        })


        //キーワード検索
        const formKeyword = useForm({
            keyword: '',
        })

        const submitKeyword = () => {
            formKeyword.get(route('admin.userContactTitle.index'), {
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

        //選択削除のデータ送信
        const submitDelete = () => {
            if(formDelete.checked.length === NO_VALUE ) {
                return confirm('削除するユーザーお問い合わせ項目名を選択してください')
            }
            getAfterDeletePageParam()
            formDelete.post(route('admin.userContactTitle.delete'),{
                onBefore: () => confirm('選択したユーザーお問い合わせ項目名を本当に削除しますか？')
            })
        }

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

        const sortNameUp = () => {
            if(sortStatus.nameUp) {
                sortDefault()
                sortStatus.nameUp = false
                return
            }

            searchUserContactTitles.value.sort((a, b) => {
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

            searchUserContactTitles.value.sort((a, b) => {
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

            searchUserContactTitles.value.sort((a, b) => {
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

            searchUserContactTitles.value.sort((a, b) => {
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

            searchUserContactTitles.value.sort((a, b) => {
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

            searchUserContactTitles.value.sort((a, b) => {
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

        const { allChecked, sortDefault ,getAfterDeletePageParam } = useTableAction(formDelete, searchUserContactTitles, paginations, userContactTitles)

        return {
            sideBarLists,
            paginations,
            tableKeyword,
            searchUserContactTitles,
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
            faEdit,

        }
    },



}
</script>

<style scoped>

</style>
