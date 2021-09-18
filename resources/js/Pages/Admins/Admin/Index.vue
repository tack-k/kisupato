<template>
    <main-layout>
        <template #content>
            <form @submit.prevent="submitKeyword">
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
                                    <p class="mr-2">職員番号</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortStaffUp" :class="{ 'admin-text-active': sortStatus.staffUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortStaffDown" :class="{ 'admin-text-active': sortStatus.staffDown }"/>
                                </div>
                            </th>
                            <th class="base-th-th" >
                                <div class="flex items-center">
                                    <p class="mr-2">氏名</p>
                                        <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortNameUp" :class="{ 'admin-text-active': sortStatus.nameUp }"/>
                                        <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortNameDown" :class="{ 'admin-text-active': sortStatus.nameDown }"/>
                                </div>
                            </th>
                            <th class="base-th-th" >
                                <div class="flex items-center">
                                    <p class="mr-2">部署</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortDepartmentUp" :class="{ 'admin-text-active': sortStatus.departmentUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortDepartmentDown" :class="{ 'admin-text-active': sortStatus.departmentDown }"/>
                                </div>
                            </th>
                            <th class="base-th-th" >
                                <div class="flex items-center">
                                    <p class="mr-2">権限</p>
                                    <Fa :icon="faCaretSquareUp" class="mr-1 admin-hover" @click="sortAuthorityUp" :class="{ 'admin-text-active': sortStatus.authorityUp }"/>
                                    <Fa :icon="faCaretSquareDown" class="admin-hover" @click="sortAuthorityDown" :class="{ 'admin-text-active': sortStatus.authorityDown }"/>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(admin, index) in searchAdmins" :key="index"
                            class="base-tb-tr">
                            <td v-if="canDelete" class="base-tb-td">
                                <checkbox :value="admin.id" v-model:checked="formDelete.checked"/>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ admin.staff_number }}</p>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ admin.last_name }}{{ admin.first_name }}</p>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ admin.department_name }}</p>
                            </td>
                            <td class="base-tb-td">
                                <p class="">{{ admin.authority_name }}</p>
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
import AdminRegisterModal from "@/Layouts/Admins/AdminRegisterModal";
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
        const sideBarLists = props.sideBarLists
        const authorities = props.authorities
        const departments = props.departments
        const keyword = props.keyword
        const NO_RESULTS = -1
        const NO_VALUE = 0
        const NEXT = '次 &raquo'
        let admins = props.admins['data']
        let paginations = props.admins['links']

        //テーブル内検索
        let tableKeyword = ref('')

        const searchAdmins = computed(() => {
            let filteredAdmins = reactive([])

            for (const i in admins) {
                let admin = admins[i]
                if (
                    admin.last_name.indexOf(tableKeyword.value) !== NO_RESULTS ||
                    admin.first_name.indexOf(tableKeyword.value) !== NO_RESULTS ||
                    admin.staff_number.indexOf(tableKeyword.value) !== NO_RESULTS ||
                    admin.department_name.indexOf(tableKeyword.value) !== NO_RESULTS ||
                    admin.authority_name.indexOf(tableKeyword.value) !== NO_RESULTS
                ) {
                    filteredAdmins.push(admin)
                }
            }
            return filteredAdmins
        })

        //テーブル内検索時にチェックボックス選択結果を検索結果と一致させる
        watch(searchAdmins, (newval, oldval) => {
            const adminIds = newval.map(admin => admin.id)
            const deleteIds = formDelete.checked.map(deleteId => deleteId)
            const allValues = [...adminIds, ...deleteIds]
            const duplicatedValues = allValues.filter(allValue => adminIds.includes(allValue) && deleteIds.includes(allValue))

            formDelete.checked = [...new Set(duplicatedValues)];

        })


        //キーワード検索
        const formKeyword = useForm({
            keyword: '',
        })

        const submitKeyword = () => {
            formKeyword.get(route('admin.index'), {
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
                if(index.url === null && index.label === NEXT && formDelete.checked.length === admins.length) {
                    formDelete.page -= 1
                }
            })
        }

        //選択削除のデータ送信
        const submitDelete = () => {
            if(formDelete.checked.length === NO_VALUE ) {
               return confirm('削除するユーザーを選択してください')
            }
            getAfterDeletePageParam()
            formDelete.post(route('admin.delete'),{
                onBefore: () => confirm('選択したユーザーを本当に削除しますか？')
            })
        }

        //全選択
        const allChecked = computed({
            get: () => {
              return formDelete.checked.length === searchAdmins.value.length && searchAdmins.value.length !== 0
            },
            set: (val) => {
                if (val) {
                    formDelete.checked = searchAdmins.value.map((admin) => admin.id);
                } else {
                    formDelete.checked = [];
                }
            }
        });

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

        // データ取得時の作成日順にソート
        const sortDefault = () => {
            searchAdmins.value.sort((a, b) => {
                if(a.created_at < b.created_at) {
                    return 1
                } else if (a.created_at > b.created_at){
                    return -1
                } else {
                    return 0
                }
            })
        }


        const sortStaffUp = () => {
            if(sortStatus.staffUp) {
                sortDefault()
                sortStatus.staffUp = false
                return
            }

            searchAdmins.value.sort((a, b) => {
                if(a.staff_number > b.staff_number) {
                    return 1
                } else if (a.staff_number < b.staff_number){
                    return -1
                } else {
                    return 0
                }
            })

            resetSortStatus()
            sortStatus.staffUp = true
        }

        const sortStaffDown = () => {
            if(sortStatus.staffDown) {
                sortDefault()
                sortStatus.staffDown = false
                return
            }

            searchAdmins.value.sort((a, b) => {
                if(a.staff_number < b.staff_number) {
                    return 1
                } else if (a.staff_number > b.staff_number){
                    return -1
                } else {
                    return 0
                }
            })
            resetSortStatus()
            sortStatus.staffDown = true
        }

        const sortNameUp = () => {
            if(sortStatus.nameUp) {
                sortDefault()
                sortStatus.nameUp = false
                return
            }

            searchAdmins.value.sort((a, b) => {
                if(a.name_kana > b.name_kana) {
                    return 1
                } else if (a.name_kana < b.name_kana){
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

            searchAdmins.value.sort((a, b) => {
                if(a.name_kana < b.name_kana) {
                    return 1
                } else if (a.name_kana > b.name_kana){
                    return -1
                } else {
                    return 0
                }
            })
            resetSortStatus()
            sortStatus.nameDown = true
        }

        const sortDepartmentUp = () => {
            if(sortStatus.departmentUp) {
                sortDefault()
                sortStatus.departmentUp = false
                return
            }

            searchAdmins.value.sort((a, b) => {
                if(a.department_name > b.department_name) {
                    return 1
                } else if (a.department_name < b.department_name){
                    return -1
                } else {
                    return 0
                }
            })

            resetSortStatus()
            sortStatus.departmentUp = true
        }

        const sortDepartmentDown = () => {
            if(sortStatus.departmentDown) {
                sortDefault()
                sortStatus.departmentDown = false
                return
            }

            searchAdmins.value.sort((a, b) => {
                if(a.department_name < b.department_name) {
                    return 1
                } else if (a.department_name > b.department_name){
                    return -1
                } else {
                    return 0
                }
            })
            resetSortStatus()
            sortStatus.departmentDown = true
        }

        const sortAuthorityUp = () => {
            if(sortStatus.authorityUp) {
                sortDefault()
                sortStatus.authorityUp = false
                return
            }

            searchAdmins.value.sort((a, b) => {
                if(a.authority_name > b.authority_name) {
                    return 1
                } else if (a.authority_name < b.authority_name){
                    return -1
                } else {
                    return 0
                }
            })

            resetSortStatus()
            sortStatus.authorityUp = true
        }

        const sortAuthorityDown = () => {
            if(sortStatus.authorityDown) {
                sortDefault()
                sortStatus.authorityDown = false
                return
            }

            searchAdmins.value.sort((a, b) => {
                if(a.authority_name < b.authority_name) {
                    return 1
                } else if (a.authority_name > b.authority_name){
                    return -1
                } else {
                    return 0
                }
            })
            resetSortStatus()
            sortStatus.authorityDown = true
        }


        return {
            sideBarLists,
            paginations,
            tableKeyword,
            searchAdmins,
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
            sortStaffUp,
            sortStaffDown,
            sortDepartmentUp,
            sortDepartmentDown,
            sortAuthorityUp,
            sortAuthorityDown,

        }
    },


}
</script>

<style scoped lang="scss">

</style>
