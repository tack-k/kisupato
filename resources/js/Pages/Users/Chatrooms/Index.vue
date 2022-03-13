<template>
    <my-page-layout>
        <template #content>
            <!-- component -->
            <div v-if="chatrooms.length === 0" class="pt-8">
                <FixedMessage>チャットルームの登録がありません。</FixedMessage>
            </div>
            <section v-else class="container mx-auto p-6 font-mono">
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
                                <td class="px-4 py-3 text-xs font-semibold border">
                                    <span :class="setConsultationColor(chatroom.consultation_status)" class="px-2 py-1 font-semibold leading-tight rounded-sm">{{ chatroom.consultation_status_name }}</span>
                                </td>
                                <td class="px-4 py-3 text-xs font-semibold border">
                                    <span :class="setRequestColor(chatroom.request_status)" class="px-2 py-1 font-semibold leading-tight rounded-sm">{{ chatroom.request_status_name }}</span>
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
import FixedMessage from '@/Components/Messages/FixedMessage'
import { Inertia } from '@inertiajs/inertia'
import { commonConst } from '@/Consts/commonConst'

export default {
    name: "Index",
    components: {
        MyPageLayout,
        FixedMessage,
    },
    props: {
        chatrooms: Object,
    },
    setup(props) {
        const { chatrooms } = props;
        const {
            PROFILE_PATH,
            REQUEST_EXAMINATION,
            REQUEST,
            REQUEST_CANCELED,
            REQUEST_FINISHED,
            CONSULTATION,
            CONSULTATION_FINISHED,
            CONSULTATION_CANCELED,
        } = commonConst;

        const linkChatroomShow = (chatroomId) => {
            Inertia.visit(route('chatroom.show', [chatroomId]));
        }

        //依頼状態によるカラー設定
        const setRequestColor = (status) => {
            switch (status) {
                case REQUEST_EXAMINATION:
                    return 'examination-status'
                    break
                case REQUEST:
                    return 'running-status'
                    break
                case REQUEST_FINISHED:
                    return 'finished-status'
                    break
                case REQUEST_CANCELED:
                    return 'canceled-status'
                    break
            }
        }

        //相談状態によるカラー設定
        const setConsultationColor = (status) => {
            switch (status) {
                case CONSULTATION:
                    return 'running-status'
                    break
                case CONSULTATION_FINISHED:
                    return 'finished-status'
                    break
                case CONSULTATION_CANCELED:
                    return 'canceled-status'
                    break
            }
        }

        return {
            chatrooms,
            linkChatroomShow,
            setRequestColor,
            setConsultationColor,
        }
    }
}
</script>

<style scoped>

</style>
