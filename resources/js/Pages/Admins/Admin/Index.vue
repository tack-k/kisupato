<template>
    <Header/>
    <div class="flex">
        <sideBar :sideBarLists="sideBarLists"/>
        <div class="container p-4 lg:p-40">

            <FlashMessage />

            <form @submit.prevent="submitKeyword">
                <RoundSearch v-model="formKeyword.keyword" placeholder="全体検索"/>
            </form>
            <admin-register-modal :authorities="authorities" :departments="departments"></admin-register-modal>
            <div class="container mx-auto pt-4 py-16 ">
                <div class="container">
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
                                <th class="px-3 py-5 table-cell">
                            <form @submit.prevent="submitDelete(formDelete.checked)">
                                    <div class="flex items-center">
                                        <checkbox v-model="allChecked" :checked="allChecked" />
                                        <button type="submit" :class="{ 'opacity-25': formDelete.processing }" :disabled="formDelete.processing">
                                        <Fa :icon="faTrashAlt" class="ml-3 hover:cursor-pointer" size="lg" />
                                        </button>
                                    </div>
                            </form>
                                </th>
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
                                    <checkbox :value="admin.id" v-model:checked="formDelete.checked"/>
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
import { faTrashAlt } from "@fortawesome/free-solid-svg-icons";

export default {
    name: "Index",

    components: {
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
    },

    setup(props) {
        const sideBarLists = props.sideBarLists
        const authorities = props.authorities
        const departments = props.departments
        const keyword = props.keyword
        const NO_RESULTS = -1
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

        const submitDelete = () => {
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
        }
    },


}
</script>

<style scoped lang="scss">

</style>
