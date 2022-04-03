<template>
    <my-page-layout>
        <template #content>
            <!-- component -->
            <div v-if="chatrooms.length === 0" class="pt-8">
                <FixedMessage>チャットルームの登録がありません。</FixedMessage>
            </div>
            <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
                <template v-for="(chatroom, key) in chatrooms" :key="key">
                    <ChatroomCard :chatroom="chatroom"/>
                </template>
            </div>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Experts/MyPageLayout'
import FixedMessage from '@/Components/Messages/FixedMessage'
import ChatroomCard from '@/Components/Cards/ChatroomCard'
import { toRefs } from 'vue'

export default {
    name: "Index",
    components: {
        ChatroomCard,
        MyPageLayout,
        FixedMessage,
    },
    props: {
        chatrooms: Object,
    },
    setup(props) {
        const { chatrooms } = toRefs(props);

        return {
            chatrooms,
        }
    }
}
</script>

<style scoped>

</style>
