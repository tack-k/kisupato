<template>
    <nav class="relative flex flex-wrap items-center justify-between px-2 py-3 bg-gray-400">
        <div class="container px-4 mx-auto flex flex-wrap items-center justify-between">
            <div class="w-full relative flex justify-between lg:w-auto  px-4 lg:static lg:block lg:justify-start">
                <a class="text-sm font-bold leading-relaxed inline-block mr-4 py-2 whitespace-nowrap uppercase text-white" href="#pablo">
                    blueGray Color
                </a>
                <button class="text-white cursor-pointer text-xl leading-none px-3 py-1 border border-solid border-transparent rounded bg-transparent block lg:hidden outline-none focus:outline-none" type="button" @click="toggleNavbar">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div v-bind:class="{'hidden': !showMenu, 'flex': showMenu}" class="lg:flex lg:flex-grow items-center">
                <ul class="flex flex-col lg:flex-row list-none ml-auto">
                    <li class="nav-item">
                        <a class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75" href="#pablo">
                            <i class="fab fa-facebook-square text-lg leading-lg text-white opacity-75" /><span class="ml-2">Share</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <Link :href="route('expert.logout')" method="post" as="button" class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75">
                            ログアウト
                        </Link>
                    </li>
                    <li class="nav-item">
                        <a class="px-3 py-2 flex items-center text-xs uppercase font-bold leading-snug text-white hover:opacity-75" href="#pablo">
                            <Fa :icon="faUser" class="text-lg leading-lg text-white opacity-7"/><span class="ml-2">{{ $page.props.auth.expert.last_name }}{{ $page.props.auth.expert.first_name }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import { ref } from "vue";
import Fa from "vue-fa";
import { Link } from "@inertiajs/inertia-vue3"
import { faUser } from "@fortawesome/free-regular-svg-icons";

export default {
    name: "Header",
    components: {
      Fa,
      Link,
    },

    setup() {
      let showMenu = ref(false)
      const toggleNavbar = () => showMenu.value = !showMenu.value


      return {
          showMenu,
          toggleNavbar,
          faUser,
      }
    },
}
</script>

<style scoped>

</style>
