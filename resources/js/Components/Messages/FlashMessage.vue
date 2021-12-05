<template>
    <div v-show="open" v-if="$page.props.flash.message"
         class="text-red-500 border border-gray-200 px-6 py-4 rounded relative mb-4 admin-bg-white">
  <span class="text-xl inline-block mr-5 align-middle">
    <Fa :icon="faInfoCircle"/>
  </span>
        <ul v-if="Array.isArray($page.props.flash.message)" v-for="(message, index) in $page.props.flash.message"
            :key="index">
            <li class="inline-block align-middle mr-8 base-font-bold mt-0.5">{{ message }}</li>
        </ul>
        <span class="inline-block align-middle mr-8 base-font-bold" v-else>{{ $page.props.flash.message }}</span>
        <button @click="closeForm"
                class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none">
            <span>×</span>
        </button>
    </div>
</template>

<script>
import Fa from 'vue-fa';
import {faInfoCircle} from '@fortawesome/free-solid-svg-icons';
import {ref} from "vue";

export default {
    name: "FlashMessage",
    components: {
        Fa,
    },
    setup() {
        let open = ref(true)
        const closeForm = () => open.value = false

        return {
            faInfoCircle,
            closeForm,
            open,
        }
    }
}
</script>

<style scoped>

</style>
