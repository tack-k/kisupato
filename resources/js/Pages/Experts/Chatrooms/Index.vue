<template>
    <my-page-layout>
        <template #content>
            <!-- component -->
            <div v-if="chatrooms.length === 0" class="pt-8">
                <FixedMessage :messages="messages" />
            </div>
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                <template v-for="(chatroom, key) in chatrooms" :key="key">
                    <ChatroomCardExpert :chatroom="chatroom"/>
                </template>
            </ul>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Experts/MyPageLayout'
import FixedMessage from '@/Components/Messages/FixedMessage'
import { toRefs } from 'vue'
import ChatroomCardExpert from '@/Components/Cards/ChatroomCardExpert'

export default {
    name: "Index",
    components: {
        ChatroomCardExpert,
        MyPageLayout,
        FixedMessage,
    },
    props: {
        chatrooms: Object,
        messages: Array,
    },
    setup(props) {
        const { chatrooms, messages } = toRefs(props);

        return {
            chatrooms,
            messages,
        }
    }
}
</script>

<style scoped>

</style>
