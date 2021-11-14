<template>
    <div v-show="open" v-if="hasErrors" class="flex text-red-500 border border-gray-200 px-6 py-4 rounded relative mb-4 admin-bg-white">
          <span class="text-xl inline-block mr-5 align-middle">
            <Fa :icon="faExclamationTriangle"/>
          </span>
        <ul>
          <li class="align-middle mr-8 base-font-bold" v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
        <button @click="closeForm"
                class="absolute bg-transparent text-2xl font-semibold leading-none right-2 top-1 outline-none focus:outline-none">
            <span>×</span>
        </button>
    </div>
</template>

<script>
import Fa from 'vue-fa';
import {faExclamationTriangle} from '@fortawesome/free-solid-svg-icons';
import {computed, ref, watch} from "vue";
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

        watch(errors, () => open.value = true)

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
