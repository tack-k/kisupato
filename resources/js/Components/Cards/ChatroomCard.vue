<template>
    <!-- This is an example component -->
    <div class="w-full mx-auto user-hover" @click="linkChatroomShow(chatroom.chatroom_id)">
        <div class="max-w-sm p-2 h-full bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
            <div class="flex justify-end px-4 py-4">
                <div v-if="chatroom.consultation_status_name !== null" :class="setConsultationColor(chatroom.consultation_status)" class="inline-flex items-center py-1 px-2 text-xs font-medium rounded">{{ chatroom.consultation_status_name }}</div>
                <div v-if="isShowRequestName(chatroom)" :class="setRequestColor(chatroom.request_status)" class="inline-flex items-center py-1 px-2 text-xs font-medium rounded">{{ chatroom.request_status_name }}</div>
            </div>
            <div class="flex flex-col items-center pb-10">
                <div class="flex items-center">
                    <img class="mb-3 w-24 h-24 rounded-full shadow-lg" :src="PROFILE_PATH + chatroom.profile_image" alt="Bonnie image">
                    <div v-if="chatroom.message !== null" class="ml-2 limit-string bg-gray-300 rounded-lg rounded-bl-none px-4 py-2">
                        <span class="limit-string inline-block text-gray-600 text-xs">{{ chatroom.message }}</span>
                    </div>
                </div>
                <h3 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ chatroom.nickname }}</h3>
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
                <div v-if="!isRequesting" class="flex justify-center mt-4">
                    <button @click.stop="submitRequest(chatroom.request_status)" :class="{ 'opacity-25': requestForm.processing }" :disabled="requestForm.processing" class="expert-regular-btn mr-2">依頼する</button>
                    <button @click.stop="submitCancelConsultation" class="expert-outline-btn" :class="{ 'opacity-25': requestForm.processing }" :disabled="requestForm.processing">相談キャンセル</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { commonConst } from '@/Consts/commonConst'
import { ref, toRefs } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import useChatroomCardAction from '@/Composables/useChatroomCardAction'
import { useForm } from '@inertiajs/inertia-vue3'
import { messageConst } from '@/Consts/messageConst'

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
            REQUEST_APPLYING,
            REQUEST,
            REQUEST_CANCELED,
            CONSULTATION,
            CONSULTATION_CANCELED,
            CONSULTATION_FINISHED,
        } = commonConst;

        const { M_APPLY_REQUEST, M_CANCEL_CONSULTATION, ME_SUBMIT_ILLEGAL } = messageConst;

        const linkChatroomShow = (chatroomId) => {
            Inertia.visit(route('chatroom.show', [chatroomId]));
        }

        const { isShowRequestName, setRequestColor, setConsultationColor, submitChatroomStatus } = useChatroomCardAction();

        //依頼リクエスト・相談キャンセル
        const isRequesting = ref(true);
        if (chatroom.value.request_status === REQUEST_EXAMINATION ) {
            isRequesting.value = false;
        }

        const requestForm = useForm({
            id: chatroom.value.id,
            request_status: '',
            consultation_status: '',
        });

        const url = route('chatroom.update')

        const submitRequest = () => {
            console.log(chatroom.value.request_status)
            if (chatroom.value.request_status === REQUEST_EXAMINATION) {
                submitChatroomStatus(M_APPLY_REQUEST, REQUEST_APPLYING, CONSULTATION_FINISHED, requestForm, url)
            } else {
                alert(ME_SUBMIT_ILLEGAL);
            }

        }

        const submitCancelConsultation = () => {
            if (chatroom.value.consultation_status === CONSULTATION) {
                submitChatroomStatus(M_CANCEL_CONSULTATION, REQUEST_CANCELED, CONSULTATION_CANCELED, requestForm, url)
            } else {
                alert(ME_SUBMIT_ILLEGAL)
            }

        }

        return {
            chatroom,
            PROFILE_PATH,
            linkChatroomShow,
            setRequestColor,
            setConsultationColor,
            REQUEST_EXAMINATION,
            CONSULTATION_CANCELED,
            REQUEST_CANCELED,
            isShowRequestName,
            submitRequest,
            requestForm,
            isRequesting,
            submitCancelConsultation,
        }
    }
}
</script>

<style scoped lang="scss">
.limit-string {
    display: -webkit-box;
    overflow: hidden;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

</style>
