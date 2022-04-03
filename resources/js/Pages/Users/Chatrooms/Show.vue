<template>
    <my-page-layout :isChatroom="true">
        <template #content>
            <div class="flex-1 p:2 sm:p-6 flex flex-col h-full">
            <Chatroom :messages="messages" :chatroom="chatroom" :profile="expertProfile"/>
            <div v-show="!isRequesting" class="flex justify-center mt-4">
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
            REQUEST,
            REQUEST_CANCELED,
            CONSULTATION,
        } = commonConst;

        const { chatroom, messages, expertProfile } = toRefs(props);


        //依頼リクエスト・相談キャンセル
        const isRequesting = ref(false);
        if (chatroom.value.request_status === REQUEST || chatroom.value.request_status === REQUEST_CANCELED) {
            isRequesting.value = true;
        }

        const requestConfirmMessage = ref('')
        const requestForm = useForm({
            id: chatroom.value.id,
            request_status: '',
            consultation_status: '',
        });

        const submitChatroomStatus = (requestConfirmMessage) => {
            if (confirm(requestConfirmMessage)) {
                requestForm.post(route('chatroom.update'))
            }
        }

        const submitRequest = () => {
            if (chatroom.value.request_status === REQUEST_EXAMINATION) {
                requestConfirmMessage.value = '仕事依頼をしたら、あなたからキャンセルできません。本当に仕事を依頼しますか？'
                requestForm.request_status = '1';
                requestForm.consultation_status = '1';
                submitChatroomStatus(requestConfirmMessage.value)
            } else {
                alert('不正な送信です');
            }

        }

        const submitCancelConsultation = () => {
            if (chatroom.value.consultation_status === CONSULTATION) {
                requestConfirmMessage.value = '相談をキャンセルしたら、メッセージを送ることができなくなります。本当に相談をキャンセルしますか？'
                requestForm.request_status = '3';
                requestForm.consultation_status = '2';
                submitChatroomStatus(requestConfirmMessage.value)
            } else {
                alert('不正な送信です')
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
