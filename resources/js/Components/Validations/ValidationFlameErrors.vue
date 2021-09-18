<template>
    <div v-show="open" v-if="hasErrors"
         class="text-red-500 border border-gray-200 px-6 py-4 rounded relative mb-4 admin-bg-white">
  <span class="text-xl inline-block mr-5 align-middle">
    <Fa :icon="faExclamationTriangle"/>
  </span>
        <p class="inline-block align-middle mr-8 base-font-bold" v-for="(error, index) in errors"
              :key="index">{{ error }}</p>
        <button @click="closeForm"
                class="absolute bg-transparent text-2xl font-semibold leading-none right-0 top-0 mt-4 mr-6 outline-none focus:outline-none">
            <span>×</span>
        </button>
    </div>
</template>

<script>
import Fa from 'vue-fa';
import {faExclamationTriangle} from '@fortawesome/free-solid-svg-icons';
import {computed, ref} from "vue";
import {usePage} from '@inertiajs/inertia-vue3'

export default {
    name: "ValidationFlameErrors",
    components: {
        Fa,
    },
    setup() {
        let open = ref(true)
        const closeForm = () => open.value = false

        const errors = computed(() => usePage().props.value.errors)

        const hasErrors = computed(() => Object.keys(errors.value).length > 0)

        return {
            faExclamationTriangle,
            closeForm,
            open,
            errors,
            hasErrors,

        }
    }
}
</script>

<style scoped>

</style>
