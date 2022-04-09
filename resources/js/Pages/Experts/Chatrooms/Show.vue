<template>
    <my-page-layout :isChatroom="true">
        <template #content>
            <div class="flex-1 p:2 sm:p-6 flex flex-col h-full">
                <Chatroom :messages="messages" :chatroom="chatroom" :profile="userProfile"/>
            </div>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Experts/MyPageLayout'
import { toRefs, ref } from 'vue'
import { useForm } from "@inertiajs/inertia-vue3"
import { commonConst } from '@/Consts/commonConst'
import Chatroom from '@/Layouts/Common/Chatroom'

export default {
    name: "Show",
    props: {
        messages: Object,
        chatroom: Object,
        userProfile: Object,
    },
    components: { Chatroom, MyPageLayout },
    setup(props) {

        const {
            REQUEST_EXAMINATION,
            REQUEST,
            REQUEST_CANCELED,
            CONSULTATION,
        } = commonConst;

        const { chatroom, messages, userProfile } = toRefs(props);


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
            userProfile,
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
