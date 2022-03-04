<template>
    <nav class="relative flex flex-wrap items-center justify-between px-2 py-3 user-bg">
        <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
            <div class="w-full relative flex justify-between lg:w-auto  px-4 lg:static lg:block lg:justify-start">
                <Link class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-white" :href="route('home')">
                    KissPATO
                </Link>
                <button class="text-white cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none" type="button" @click="toggleNavbar">
                    <Fa :icon="faBars" />
                </button>
            </div>
            <div v-bind:class="{'hidden': !showMenu, 'flex': showMenu}" class="lg:flex lg:flex-grow items-center">
                <ul class="flex flex-col lg:flex-row list-none ml-auto" v-if="!user">
                    <li class="nav-item">
                        <Link :href="route('login')" class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75">
                            ログイン
                        </Link>
                    </li>
                    <li class="nav-item">
                        <Link :href="route('create')" class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75">
                            ユーザー登録
                        </Link>
                    </li>
                </ul>
                <ul class="flex flex-col lg:flex-row list-none ml-auto" v-if="user">
                    <li class="nav-item">
                        <Link :href="route('logout')" method="post" as="button" class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75">
                            ログアウト
                        </Link>
                    </li>
                    <li class="nav-item">
                        <a class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75" href="#pablo">
                            <Fa :icon="faUser" class="text-lg leading-lg text-white opacity-7"/><span class="ml-2">{{ user?.last_name }}{{ user?.first_name }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import Fa from "vue-fa";
import { Link } from "@inertiajs/inertia-vue3";
import { ref, computed } from "vue";
import { faUser } from "@fortawesome/free-regular-svg-icons";
import { faBars } from "@fortawesome/free-solid-svg-icons"
import { usePage } from "@inertiajs/inertia-vue3"

export default {
    name: "Header",
    components: {
        Fa,
        Link,
    },

    setup() {
        let showMenu = ref(false)
        const toggleNavbar = () => showMenu.value = !showMenu.value
        const user = computed(() => usePage().props?.value.auth.user);


        return {
            showMenu,
            toggleNavbar,
            faUser,
            faBars,
            user,
        }
    },
}
</script>

<style scoped>

</style>
