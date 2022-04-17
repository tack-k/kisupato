<template>
    <main-layout>
        <template #content>
            <form @submit.prevent="submitKeyword(keywordUrl)">
                <RoundSearch v-model="formKeyword.keyword" placeholder="全体検索"/>
            </form>
            <div class="text-right">
                <Link :href="route('admin.information_site.create')" class="admin-regular-btn">新規登録</Link>
            </div>
            <div class="container mx-auto pt-4 py-16 ">
                <div class="container">
                    <table class="base-table">
                        <thead>
                        <tr class="base-th-tr-search">
                            <th colspan="5" class="p-1 table-cell">
                                <div class="flex items-center flex-col-reverse md:justify-between md:flex-row md:mr-6">
                                    <square-search v-model="tableKeyword" placeholder="テーブル内検索"/>
                                    <p class="text-center">サイトからのお知らせ一覧</p>
                                </div>
                            </th>
                        </tr>
                        <tr class="base-th-tr">
                            <th class="base-th-th">
                                <form @submit.prevent="submitDelete(deleteUrl, I_SELECT_INFORMATION_SITE, I_DELETE_INFORMATION_SITE)">
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
                                    <p class="mr-2">ステータス</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortStatusUp" :class="{ 'admin-text-active': sortStatus.statusUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortStatusDown" :class="{ 'admin-text-active': sortStatus.statusDown }"/>
                                </div>
                            </th>
                            <th class="base-th-th">
                                <div class="flex items-center">
                                    <p class="mr-2">タイトル</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortTitleUp" :class="{ 'admin-text-active': sortStatus.titleUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortTitleDown" :class="{ 'admin-text-active': sortStatus.titleDown }"/>
                                </div>
                            </th>
                            <th class="base-th-th">
                                <div class="flex items-center">
                                    <p class="mr-2">予約投稿日時</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortReservedAtUp" :class="{ 'admin-text-active': sortStatus.reservedAtUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortReservedAtDown" :class="{ 'admin-text-active': sortStatus.reservedAtDown }"/>
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
                            <td class="base-tb-td">
                                <checkbox :value="searchedTableContent.id" v-model:checked="formDelete.checked"/>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ searchedTableContent.status_name }}</p>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ searchedTableContent.title }}</p>
                            </td>
                            <td class="base-tb-td">
                                <p class="" v-if="searchedTableContent.reserved_at !== null">{{ formatDateTime(searchedTableContent.reserved_at) }}</p>
                            </td>

                            <td class="base-tb-td">
                                <div class="flex justify-center">
                                    <!--                                    <Link :href="route('admin.information_site.edit', {'id': searchedTableContent.id})" as="button" methods="get">-->
                                    <!--                                        <Fa :icon="faEdit" class="admin-hover"/>-->
                                    <!--                                    </Link>-->
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
import { ref, reactive, computed, toRefs } from "vue";
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
import RegularButton from '@/Components/Buttons/RegularButton'
import useCommonAction from '@/Composables/useCommonAction'
import { messageConst } from '@/Consts/messageConst'

export default {
    name: "Index",
    components: {
        RegularButton,
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
        informationSites: Object,
        keyword: String,
    },
    setup(props) {
        const keyword = props.keyword
        const NO_RESULTS = -1
        const { data, links } = toRefs(props.informationSites)
        const { I_SELECT_INFORMATION_SITE, I_DELETE_INFORMATION_SITE } = messageConst

        //テーブル内検索
        let tableKeyword = ref('')

        const searchedTableContents = computed(() => {
            let filteredTableContents = reactive([])

            for (const i in data.value) {
                let searchedTableContent = data.value[i]
                if (
                    searchedTableContent.title.indexOf(tableKeyword.value) !== NO_RESULTS
                ) {
                    filteredTableContents.push(searchedTableContent)
                }
            }
            return filteredTableContents
        })


        //ソート
        let sortStatus = reactive({
            titleUp: false,
            titleDown: false,
            statusUp: false,
            statusDown: false,
            reservedAtUp: false,
            reservedAtDown: false,
        })

        const resetSortStatus = () => {
            sortStatus.titleUp = false
            sortStatus.titleDown = false
            sortStatus.statusUp = false
            sortStatus.statusDown = false
            sortStatus.reservedAtUp = false
            sortStatus.reservedAtDown = false
        }

        //送信先
        const keywordUrl = route('admin.information_site.index')
        const deleteUrl = route('admin.information_site.delete')


        //日付のフォーマット
        const { formatDateTime } = useCommonAction();

        const {
            allChecked,
            submitDelete,
            formDelete,
            formKeyword,
            submitKeyword,
            sortTitleUp,
            sortTitleDown,
            sortReservedAtUp,
            sortReservedAtDown,
            sortStatusUp,
            sortStatusDown,
        } = useTableAction(keyword, searchedTableContents, links, data, sortStatus, resetSortStatus)

        return {
            links,
            tableKeyword,
            searchedTableContents,
            formKeyword,
            submitKeyword,
            faTrashAlt,
            formDelete,
            submitDelete,
            allChecked,
            faCaretSquareUp,
            faCaretSquareDown,
            sortStatus,
            sortTitleUp,
            sortTitleDown,
            sortReservedAtUp,
            sortReservedAtDown,
            formatDateTime,
            faEdit,
            I_DELETE_INFORMATION_SITE,
            I_SELECT_INFORMATION_SITE,
            deleteUrl,
            keywordUrl,
            sortStatusUp,
            sortStatusDown,
        }
    }
}
</script>

<style scoped>

</style>
