<template>
    <Header/>
    <div class="flex">
        <sideBar />
        <div class="container p-4 lg:py-24 lg:px-40">

            <ValidationFlameErrors v-if="hasChecked"/>
            <FlashMessage />

            <div class="container mx-auto pt-4 py-16 ">

                <slot name="content" />

            </div>
        </div>
    </div>
</template>

<script>
import Header from "@/Layouts/Admins/Header";
import SideBar from "@/Layouts/Admins/SideBar";
import FlashMessage from "@/Components/Messages/FlashMessage";
import ValidationFlameErrors from "@/Components/Validations/ValidationFlameErrors";
import {usePage} from '@inertiajs/inertia-vue3'
import {computed} from "vue";

export default {
    name: "MainLayout",
    components: {
        ValidationFlameErrors,
        Header,
        SideBar,
        FlashMessage,
    },
    setup() {
        const errors = computed(() => usePage().props.value.errors)
        const hasChecked = computed(() => Object.keys(errors.value).includes('checked'))
        return {
            errors,
            hasChecked,
        }
    }
}
</script>

<style scoped>

</style>
