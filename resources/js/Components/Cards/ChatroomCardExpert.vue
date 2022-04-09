<template>
    <li @click="linkChatroomShow(chatroom.chatroom_id)" class="py-3 sm:py-4 px-1 sm:px-12 hover:bg-gray-50 hover:cursor-pointer">
        <div class="flex items-center space-x-3">
            <div class="w-2/12 flex items-center flex-col">
                <div v-if="chatroom.consultation_status_name !== null" :class="setConsultationColor(chatroom.consultation_status)" class="text-xs px-1 py-0.5 rounded mb-0.5">{{ chatroom.consultation_status_name }}</div>
                <div v-if="isShowRequestName(chatroom)" :class="setRequestColor(chatroom.request_status)" class="text-xs px-1 py-0.5 rounded">{{ chatroom.request_status_name }}</div>
            </div>
            <div class="w-2/12 flex-col flex items-center">
                <img class="w-8 h-8 rounded-full mb-1" :src="displayedProfilePath + chatroom.profile_image" alt="Neil image">
                <p class="text-sm　base-font-bold"> {{ chatroom.nickname }}</p>
            </div>
            <p v-if="chatroom.message !== null" class="w-4/12 limit-string text-xs">
                {{ chatroom.message }}
            </p>
            <div class="w-2/12">
                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                    ルーム作成日
                </p>
                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                    {{ chatroom.c_created_at }}
                </p>
            </div>
            <div class="w-2/12">
                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                    依頼承諾日
                </p>
                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                    {{ chatroom.request_finished_at }}
                </p>
            </div>
            <div v-if="chatroom.request_status === REQUEST_APPLYING" class="w-2/12 flex items-center flex-col">
                <RegularButton @click.stop="submitApproval" class="mb-1">
                    依頼承認
                </RegularButton>
                <OutlineButton @click.stop="submitCancel" class="">
                    キャンセル
                </OutlineButton>
            </div>
        </div>
    </li>
</template>

<script>
import { ref, toRefs } from 'vue'
import RegularButton from '@/Components/Buttons/RegularButton'
import OutlineButton from '@/Components/Buttons/OutlineButton'
import useChatroomCardAction from '@/Composables/useChatroomCardAction'
import useCommonAction from '@/Composables/useCommonAction'
import { Inertia } from '@inertiajs/inertia'
import { commonConst } from '@/Consts/commonConst'
import { messageConst } from '@/Consts/messageConst'
import { useForm } from '@inertiajs/inertia-vue3'

export default {
    name: "ChatroomCardExpert",
    components: { OutlineButton, RegularButton },
    props: {
        chatroom: Object,
    },
    setup(props) {

        const { chatroom } = toRefs(props);
        const { REQUEST_APPLYING, REQUEST, REQUEST_CANCELED, CONSULTATION_FINISHED } = commonConst;
        const { M_CANCEL_REQUEST, M_CONFIRM_REQUEST } = messageConst;

        const {
            isShowRequestName,
            setRequestColor,
            setConsultationColor,
            submitChatroomStatus
        } = useChatroomCardAction();

        const { setDisplayedProfilePath } = useCommonAction();
        const displayedProfilePath = setDisplayedProfilePath(chatroom.value.profile_image);

        const linkChatroomShow = (chatroomId) => {
            Inertia.visit(route('expert.chatroom.show', [chatroomId]));
        }

        const form = useForm({
            id: chatroom.value.chatroom_id,
            request_status: null,
            consultation_status: CONSULTATION_FINISHED,
        });

        const url = route('expert.chatroom.update');

        const submitApproval = () => {
            submitChatroomStatus(M_CONFIRM_REQUEST, REQUEST, CONSULTATION_FINISHED, form, url)
        }

        const submitCancel = () => {
            submitChatroomStatus(M_CANCEL_REQUEST, REQUEST_CANCELED, CONSULTATION_FINISHED, form, url)
        }

        return {
            chatroom,
            displayedProfilePath,
            isShowRequestName,
            setRequestColor,
            setConsultationColor,
            linkChatroomShow,
            REQUEST_APPLYING,
            submitApproval,
            submitCancel,
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
