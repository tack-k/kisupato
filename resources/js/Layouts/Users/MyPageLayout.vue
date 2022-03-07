<template>
<!--  チャットルーム以前のバージョンをコメントアウト  -->
<!--    <Header/>-->
<!--    <div class="flex">-->
<!--        <SideBar/>-->
<!--        <div class="overflow-y-scroll h-screen w-full">-->
<!--            <div class="container mx-auto py-10 max-w-screen-lg expert-bg-white shadow-md w-full md:px-10 p-4">-->
<!--                <FlashMessage/>-->
<!--                <ValidationFlameErrors/>-->
<!--                <slot name="content"/>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
    <Header/>
    <div class="flex">
        <SideBar/>
        <div class="display-container w-full">
            <div class="container mx-auto max-w-screen-lg h-full expert-bg-white shadow-md w-full md:px-10">
                <FlashMessage/>
                <ValidationFlameErrors/>
                <slot name="content"/>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "@/Layouts/Users/Header"
import SideBar from "@/Layouts/Users/SideBar";
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
.display-container {
    height: calc(100vh - 4rem);
}
</style>
