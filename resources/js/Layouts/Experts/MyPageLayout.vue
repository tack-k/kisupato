<template>
    <Header/>
    <div class="flex">
        <SideBar/>
        <div class="overflow-y-scroll h-screen w-full">
            <div class="container mx-auto py-10 max-w-screen-lg expert-bg-white shadow-md w-full md:px-10 p-4">
                <FlashMessage/>
                <ValidationFlameErrors/>
                <slot name="content"/>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "@/Layouts/Experts/Header"
import SideBar from "@/Layouts/Experts/SideBar";
import ValidationFlameErrors from "@/Components/Validations/ValidationFlameErrors";
import FlashMessage from "@/Components/Messages/FlashMessage";

export default {
    name: "MyPageLayout",
    components: {
        FlashMessage,
        ValidationFlameErrors,
        SideBar,
        Header,
    }
}
</script>

<style scoped>

</style>
