<template>
    <my-page-layout :isChatroom="true">
        <template #content>
            <div class="flex-1 p:2 sm:p-6 flex flex-col h-full">
                <Chatroom :messages="messages" :chatroom="chatroom" :profile="expertProfile"/>
                <div v-if="!isRequesting" class="flex justify-center mt-4">
                    <button @click="submitRequest(chatroom.request_status)" :class="{ 'opacity-25': requestForm.processing }" :disabled="requestForm.processing" class="expert-regular-btn mr-20">依頼する</button>
                    <button @click="submitCancelConsultation" class="expert-outline-btn" :class="{ 'opacity-25': requestForm.processing }" :disabled="requestForm.processing">相談キャンセル</button>
                </div>
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
import useChatroomCardAction from '@/Composables/useChatroomCardAction'
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

        const {
            REQUEST_EXAMINATION,
            REQUEST_APPLYING,
            REQUEST,
            REQUEST_CANCELED,
            CONSULTATION,
            CONSULTATION_CANCELED,
            CONSULTATION_FINISHED,
        } = commonConst;

        const { M_APPLY_REQUEST, M_CANCEL_CONSULTATION, ME_SUBMIT_ILLEGAL } = messageConst;

        const { chatroom, messages, expertProfile } = toRefs(props);

        const { submitChatroomStatus } = useChatroomCardAction();


        //依頼リクエスト・相談キャンセル
        const isRequesting = ref(false);
        if (chatroom.value.request_status === REQUEST || chatroom.value.request_status === REQUEST_APPLYING || chatroom.value.request_status === REQUEST_CANCELED) {
            isRequesting.value = true;
        }

        const requestForm = useForm({
            id: chatroom.value.id,
            request_status: '',
            consultation_status: '',
        });

        const url = route('chatroom.update')

        const submitRequest = () => {
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
            messages,
            expertProfile,
            submitRequest,
            requestForm,
            isRequesting,
            submitCancelConsultation,
        }
    }
}
</script>

<style scoped lang="scss">

</style>
