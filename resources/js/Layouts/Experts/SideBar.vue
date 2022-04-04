<template>
        <div class="hidden md:block" v-show="show">
            <div class="w-64 h-screen admin-bg-white" :class="{'display-container': isChatroom}">
                <div class="flex items-start justify-end p-2">
                    <Fa class="admin-hover" @click="show = !show" :icon="faAlignJustify" size="2x"/>
                </div>
                <nav class="mt-10">
                    <div x-data="{ open: false }" v-for="(sideBarList, index) in sideBarLists" key="sideBarList.title">
                        <Link :href="route(sideBarList.link)" :method="getMethod(index)" :as="getType(index)" class="w-full flex justify-between items-center py-3 px-6 text-gray-600 hover:bg-gray-100 hover:cursor-pointer focus:outline-none">
                        <span class="flex items-center">
                            <Fa :icon="sideBarList.icon"/>
                            <span class="mx-4 font-medium">{{ sideBarList.title }}</span>
                        </span>
                        </Link>

                        <div class="bg-gray-100" v-for="item in sideBarList.subtitle">
                            <Link class="py-2 px-16 block text-sm text-gray-600 hover:bg-blue-500 hover:text-white"
                               :href="route(item.link)" :as="getType(index)">{{ item.title }}</Link>
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
    <div v-show="!show" @click="show = !show" class="flex items-start justify-end p-2 hover:cursor-pointer hidden md:block">
        <Fa :icon="faAlignJustify" size="2x"/>
    </div>
</template>

<script>
import { inject, ref, computed, toRefs } from "vue";
import Fa from 'vue-fa';
import { faPortrait, faUserCircle, faSignOutAlt, faAlignJustify } from '@fortawesome/free-solid-svg-icons';
import { faComments, faStar, faEnvelope } from "@fortawesome/free-regular-svg-icons"
import { faGratipay } from "@fortawesome/free-brands-svg-icons"
import { Link } from "@inertiajs/inertia-vue3"


export default {
    name: "SideBar",
    components: {
        Fa,
        Link,
    },
    props: {
        isChatroom: {
            type: Boolean,
            default: false,
        },
    },

    setup(props) {

        const { isChatroom } = toRefs(props)

        const sideBarLists = {
            "profile": {
                "id": 0,
                'icon': faPortrait,
                "title": "プロフィール",
                "link": "expert.profile.show",
            },
            "talk_room": {
                "id": 1,
                'icon': faComments,
                "title": "トークルーム",
                "link": "expert.chatroom.index",
            },
            "favorite": {
                "id": 2,
                'icon': faGratipay,
                "title": "お気に入り",
                "link": "expert.home",
            },
            "review": {
                "id": 3,
                'icon': faStar,
                "title": "レビュー",
                "link": "expert.home"
            },
            "account": {
                "id": 4,
                'icon': faUserCircle,
                "title": "アカウント",
                "link": "expert.account.show",
            },
            "mail_setting": {
                "id": 5,
                'icon': faEnvelope,
                "title": "メール配信設定",
                "link": "expert.home",
            },
            "logout": {
                "id": 6,
                'icon': faSignOutAlt,
                "title": "ログアウト",
                "link": "expert.logout",
            }
        }

        const getMethod = index => index === 'logout' ? "post" : "get"
        const getType = index => index === 'logout' ? "button" : "a"



        const open = ref([])
        const showMenu = ref(false)

        const setOpen = computed(() => {
            for (const sideBarList in sideBarLists) {
                open.value.push(false);
            }
        })

        let show = ref(true)

        return {
            sideBarLists,
            open,
            showMenu,
            setOpen,
            faAlignJustify,
            show,
            getMethod,
            getType,
            isChatroom,
        }
    },


}


</script>

<style scoped lang="scss">
.display-container {
    height: calc(100vh - 4rem);
}
</style>
