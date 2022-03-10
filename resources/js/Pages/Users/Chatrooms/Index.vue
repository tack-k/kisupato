<template>
    <my-page-layout>
        <template #content>
            <!-- component -->
            <section class="container mx-auto p-6 font-mono">
                <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full">
                            <thead>
                            <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                                <th class="px-4 py-3"></th>
                                <th class="px-4 py-3">相談</th>
                                <th class="px-4 py-3">依頼</th>
                                <th class="px-4 py-3">ルーム作成日</th>
                                <th class="px-4 py-3">依頼完了日</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <tr class="text-gray-700 user-hover hover:bg-gray-50" v-for="(chatroom, index) in chatrooms" :key="index" @click="linkChatroomShow(chatroom.chatroom_id)">
                                <td class="px-4 py-3 border">
                                    <div class="flex items-center text-sm">
                                        <div class="relative w-8 h-8 mr-3 rounded-full">
                                            <img class="object-cover w-full h-full rounded-full" src="https://images.pexels.com/photos/5212324/pexels-photo-5212324.jpeg?auto=compress&cs=tinysrgb&dpr=3&h=750&w=1260" alt="" loading="lazy"/>
                                            <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-black">{{ chatroom.nickname }}</p>
                                            <p class="text-xs text-gray-600">{{ chatroom.message }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-md font-semibold border">
                                    <span class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-red-100 rounded-sm">{{ chatroom.consultation_status }}</span>
                                </td>
                                <td class="px-4 py-3 text-xs border">
                                    <span class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-gray-100 rounded-sm">{{ chatroom.request_status }}</span>
                                </td>
                                <td class="px-4 py-3 text-sm border">{{ chatroom.c_created_at }}</td>
                                <td class="px-4 py-3 text-sm border">{{ chatroom.request_finished_at }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Users/MyPageLayout'
import { Inertia } from '@inertiajs/inertia'

export default {
    name: "Index",
    components: { MyPageLayout },
    props: {
        chatrooms: Object,
    },
    setup(props) {
        const { chatrooms } = props;

        const linkChatroomShow = (chatroomId) => {
            Inertia.visit(route('chatroom.show', [chatroomId]));
        }

        return {
            chatrooms,
            linkChatroomShow,
        }
    }
}
</script>

<style scoped>

</style>
