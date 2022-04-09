<template>
    <my-page-layout :isChatroom="true">
        <template #content>
            <div class="flex-1 p:2 sm:p-6 flex flex-col h-full">
                <Chatroom :messages="messages" :chatroom="chatroom" :profile="expertProfile"/>
            </div>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Users/MyPageLayout'
import { toRefs, ref } from 'vue'
import { useForm } from "@inertiajs/inertia-vue3"
import { commonConst } from '@/Consts/commonConst'
import Chatroom from '@/Layouts/Common/Chatroom'
import { messageConst } from '@/Consts/messageConst'

export default {
    name: "Show",
    props: {
        messages: Object,
        chatroom: Object,
        expertProfile: Object,
    },
    components: { Chatroom, MyPageLayout },
    setup(props) {

        const {  messages, expertProfile } = toRefs(props);

        return {
            messages,
            expertProfile,
        }
    }
}
</script>

<style scoped lang="scss">

</style>
