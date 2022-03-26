<template>
    <!-- This is an example component -->
    <div class="w-full mx-auto">
        <div class="max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-end px-4 pt-4">
                <button @click="linkChatroomShow(chatroom.chatroom_id)" id="dropdownButton" data-dropdown-toggle="dropdown" class="hidden sm:inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                    </svg>
                </button>

                <div id="dropdown"
                     class="hidden z-10 w-44 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
                    <ul class="py-1" aria-labelledby="dropdownButton">
                        <li>
                            <a href="#"
                               class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                        </li>
                        <li>
                            <a href="#"
                               class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Export
                                Data</a>
                        </li>
                        <li>
                            <a href="#"
                               class="block py-2 px-4 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col items-center pb-10">
                <img class="mb-3 w-24 h-24 rounded-full shadow-lg" :src="PROFILE_PATH + chatroom.profile_image" alt="Bonnie image">
                <h3 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ chatroom.nickname }}</h3>
                <div class="flex mt-4 space-x-3 lg:mt-6 mb-4">
                    <div :class="setConsultationColor(chatroom.consultation_status)" class="inline-flex items-center py-2 px-4 text-sm font-medium rounded">{{ chatroom.consultation_status_name }}</div>
                    <div :class="setRequestColor(chatroom.request_status)" class="inline-flex items-center py-2 px-4 text-sm font-medium rounded">{{ chatroom.request_status_name }}</div>
                </div>
                <table>
                    <tbody class="text-sm text-gray-500 dark:text-gray-400">
                    <tr>
                        <td>ルーム作成日</td>
                        <td>{{ chatroom.c_created_at }}</td>
                    </tr>
                    <tr>
                        <td>依頼完了日</td>
                        <td>{{ chatroom.request_finished_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import { commonConst } from '@/Consts/commonConst'
import { toRefs } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default {
    name: "ChatroomCard",
    components: {},
    props: {
        chatroom: Object,
    },
    setup(props) {
        const { chatroom } = toRefs(props);
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
            chatroom,
            PROFILE_PATH,
            linkChatroomShow,
            setRequestColor,
            setConsultationColor,
        }
    }
}
</script>

<style scoped>

</style>
