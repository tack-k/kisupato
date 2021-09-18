<template>
        <div class="bg-gray-200" v-show="show">
            <div class="w-64 h-screen admin-bg-white ">
                <div class="flex items-start justify-end p-2">
                    <Fa class="admin-hover" @click="show = !show" :icon="faAlignJustify" size="2x"/>
                </div>
                <nav class="mt-10">
                    <div x-data="{ open: false }" v-for="sideBarList in sideBarLists" key="sideBarList.title">
                        <button @click="open[sideBarList.id] = !open[sideBarList.id]"
                                class="w-full flex justify-between items-center py-3 px-6 text-gray-600 hover:bg-gray-100 hover:cursor-pointer focus:outline-none">
                        <span class="flex items-center">
                            <Fa :icon="sideBarList.icon"/>


                            <span class="mx-4 font-medium">{{ sideBarList.title }}</span>
                        </span>

                            <span>

                            <svg v-if="sideBarList.subtitle !== null" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path v-show="!open[sideBarList.id]" d="M9 5L16 12L9 19" stroke="currentColor"
                                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path v-show="open[sideBarList.id]" d="M19 9L12 16L5 9" stroke="currentColor"
                                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                        </button>

                        <div v-show="open[sideBarList.id]" class="bg-gray-100" v-for="item in sideBarList.subtitle">
                            <Link class="py-2 px-16 block text-sm text-gray-600 hover:bg-blue-500 hover:text-white"
                               :href="route(sideBarList.link)">{{ item }}</Link>
                        </div>
                    </div>
                </nav>

                <div class="absolute bottom-0 my-8">
                    <a class="flex items-center py-2 px-8 text-gray-700 hover:text-gray-600" href="#">
                        <img class="h-6 w-6 rounded-full mr-3 object-cover"
                             src="https://lh3.googleusercontent.com/a-/AOh14Gi0DgItGDTATTFV6lPiVrqtja6RZ_qrY91zg42o-g"
                             alt="avatar">
                        <span>Khatabwedaa</span>
                    </a>
                </div>
            </div>
        </div>
    <div v-show="!show" @click="show = !show" class="flex items-start justify-end p-2 hover:cursor-pointer">
        <Fa :icon="faAlignJustify" size="2x"/>
    </div>
</template>

<script>
import {inject, ref, computed} from "vue";
import Fa from 'vue-fa';
import {
    faUser,
    faDatabase,
    faDesktop,
    faQuestionCircle,
    faInfoCircle,
    faAlignJustify
} from '@fortawesome/free-solid-svg-icons';
import { Link } from "@inertiajs/inertia-vue3"


export default {
    name: "SideBar",
    components: {
        Fa,
        Link,
    },

    setup(props) {
        const sideBarLists = {
            "user_management": {
                "id": 0,
                'icon': faUser,
                "title": "ユーザー管理",
                "subtitle": {
                    "admin": "職員",
                    "user": "ユーザー",
                    "expert": "専門人材"
                },
                "link": "admin.index"
            },
            "data_management": {
                "id": 1,
                'icon': faDatabase,
                "title": "データ管理",
                "subtitle": {
                    "expert_position": "専門人材肩書",
                    "expert_tag": "専門人材タグ",
                    "department": "部署",
                    "authority": "権限",
                    "user_contact_title": "ユーザー問い合わせ項目",
                    "expert_contact_title": "専門人材問い合わせ項目"
                },
                "link": "admin.index"
            },
            "utilization_status": {
                "id": 2,
                'icon': faDesktop,
                "title": "サイト活用状況",
                "subtitle": null,
                "link": "admin.index"
            },
            "contact_management": {
                "id": 3,
                'icon': faQuestionCircle,
                "title": "問い合わせ管理",
                "subtitle": {
                    "user": "ユーザー",
                    "expert": "専門人材"
                },
                "link": "admin.index"
            },
            "notification_function": {
                "id": 4,
                'icon': faInfoCircle,
                "title": "お知らせ機能",
                "subtitle": {
                    "mail_magazine": "メルマガ",
                    "information_site": "サイトからのお知らせ"
                },
                "link": "admin.index"
            }
        }


        const open = ref([])
        const showMenu = ref(false)

        const setOpen = computed(() => {
            for (const sideBarList in sideBarLists) {
                open.value.push(false);
            }
        })

        const icons = [
            faUser,
            faDatabase,
            faDesktop,
            faQuestionCircle,
            faInfoCircle,
        ]

        let show = ref(true)

        return {
            sideBarLists,
            open,
            showMenu,
            setOpen,
            icons,
            faAlignJustify,
            show,
        }
    },


}


</script>

<style scoped lang="scss">


//.fade {
//    &-enter {
//        transform: translateX(-100%);
//        &-to {
//            transform: translateX(0);
//        }
//        &-active {
//            transition: all 1s;
//
//        }
//    }
//
//    &-leave {
//transform: translateX(0);
//        &-to {
//            transform: translateX(-100%);
//        }
//        &-active {
//transition: all 1s;
//        }
//    }
//}
</style>
