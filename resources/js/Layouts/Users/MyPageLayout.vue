<template>
<!--  チャットルーム以前のバージョンをコメントアウト  -->
    <Header :isChatroom="isChatroom"/>
    <div class="flex">
        <SideBar :isChatroom="isChatroom"/>
        <div class="overflow-y-scroll h-screen w-full" :class="{'display-container': isChatroom}">
            <div class="container mx-auto py-10 max-w-screen-lg expert-bg-white shadow-md w-full md:px-10 p-4" :class="{'chatroom-container': isChatroom}">
                <FlashMessage/>
                <ValidationFlameErrors/>
                <slot name="content"/>
            </div>
        </div>
    </div>
<!--    <Header/>-->
<!--    <div class="flex">-->
<!--        <SideBar/>-->
<!--        <div class="display-container w-full">-->
<!--            <div class="container mx-auto max-w-screen-lg h-full expert-bg-white shadow-md w-full md:px-10">-->
<!--                <FlashMessage/>-->
<!--                <ValidationFlameErrors/>-->
<!--                <slot name="content"/>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
</template>

<script>
import Header from "@/Layouts/Users/Header"
import SideBar from "@/Layouts/Users/SideBar";
import ValidationFlameErrors from "@/Components/Validations/ValidationFlameErrors";
import FlashMessage from "@/Components/Messages/FlashMessage";
import { toRefs } from 'vue'

export default {
    name: "MyPageLayout",
    props: {
        isChatroom: {
            type: Boolean,
            default: false,
        },
    },
    components: {
        FlashMessage,
        ValidationFlameErrors,
        SideBar,
        Header,
    },
    setup(props) {

        const {isChatroom} = toRefs(props);

        return {
            isChatroom,
        }
    }
}
</script>

<style scoped lang="scss">
.display-container {
    height: calc(100vh - 4rem);
    @apply overflow-y-visible
}

.chatroom-container {
    padding: 0;
    @apply h-full
}
</style>
