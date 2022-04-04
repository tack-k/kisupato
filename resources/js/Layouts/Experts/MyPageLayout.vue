<template>
    <Header :isChatroom="isChatroom"/>
    <div class="flex">
        <SideBar :isChatroom="isChatroom"/>
        <div class="overflow-y-scroll h-screen w-full" :class="{'display-container': isChatroom}">
            <div class="container mx-auto py-10 max-w-screen-lg expert-bg-white shadow-md w-full md:px-10 p-4" :class="{'chatroom-container': isChatroom}">
                <FlashMessage/>
                <ValidationFlameErrors v-if="isValidationShow"/>
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
import { toRefs } from 'vue'

export default {
    name: "MyPageLayout",
    props: {
        isChatroom: {
            type: Boolean,
            default: false,
        },
        isValidationShow: {
            type: Boolean,
            default: true,
        },
    },
    components: {
        FlashMessage,
        ValidationFlameErrors,
        SideBar,
        Header,
    },
    setup(props) {

        const { isChatroom, isValidationShow } = toRefs(props);

        return {
            isChatroom,
            isValidationShow,
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
