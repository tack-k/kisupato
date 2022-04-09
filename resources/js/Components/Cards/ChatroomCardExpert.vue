<template>
    <li @click="linkChatroomShow(chatroom.chatroom_id)" class="py-3 sm:py-4 px-1 sm:px-4 hover:bg-gray-50 hover:cursor-pointer">
        <div class="flex items-center">
            <div class="flex items-center w-10/12">
                <div class="w-2/12 m-1 flex items-center flex-col">
                    <div v-if="chatroom.consultation_status_name !== null" :class="setConsultationColor(chatroom.consultation_status)" class="text-xs px-1 py-0.5 rounded mb-0.5">{{ chatroom.consultation_status_name }}</div>
                    <div v-if="isShowRequestName(chatroom)" :class="setRequestColor(chatroom.request_status)" class="text-xs px-1 py-0.5 rounded">{{ chatroom.request_status_name }}</div>
                </div>
                <div class="w-2/12 m-1 flex-col flex items-center">
                    <img class="w-8 h-8 rounded-full mb-1" :src="displayedProfilePath + chatroom.profile_image" alt="Neil image">
                    <p class="text-sm　base-font-bold"> {{ chatroom.nickname }}</p>
                </div>
                <p v-if="chatroom.message !== null" class="w-4/12 limit-string text-xs">
                    {{ chatroom.message }}
                </p>
                <div class="w-2/12 m-1">
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                        ルーム作成日
                    </p>
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        {{ chatroom.c_created_at }}
                    </p>
                </div>
                <div class="w-2/12 m-1">
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                        依頼完了日
                    </p>
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                        {{ chatroom.request_finished_at }}
                    </p>
                </div>
            </div>
            <DoubleButton v-if="chatroom.request_status === REQUEST_APPLYING" :regularText="'依頼承認'" :outline-text="'キャンセル'" :regular-action="submitApproval" :outline-action="submitCancel"/>
            <DoubleButton v-if="chatroom.request_status === REQUEST" :regularText="'依頼完了'" :outline-text="'キャンセル'" :regular-action="submitFinish" :outline-action="submitCancel"/>
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
import DoubleButton from '@/Layouts/Common/DoubleButton'

export default {
    name: "ChatroomCardExpert",
    components: { DoubleButton, OutlineButton, RegularButton },
    props: {
        chatroom: Object,
    },
    setup(props) {

        const { chatroom } = toRefs(props);
        const { REQUEST_APPLYING, REQUEST, REQUEST_CANCELED, REQUEST_FINISHED, CONSULTATION_FINISHED } = commonConst;
        const { M_CANCEL_REQUEST, M_ACCEPT_REQUEST, M_FINISH_REQUEST } = messageConst;

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
            submitChatroomStatus(M_ACCEPT_REQUEST, REQUEST, CONSULTATION_FINISHED, form, url)
        }

        const submitCancel = () => {
            submitChatroomStatus(M_CANCEL_REQUEST, REQUEST_CANCELED, CONSULTATION_FINISHED, form, url)
        }

        const submitFinish = () => {
            submitChatroomStatus(M_FINISH_REQUEST, REQUEST_FINISHED, CONSULTATION_FINISHED, form, url)
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
            REQUEST,
            submitFinish,
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
