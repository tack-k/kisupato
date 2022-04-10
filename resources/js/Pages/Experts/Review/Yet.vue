<template>
    <my-page-layout :isValidationShow="isValidationShow">
        <template #content>
            <FixedMessage v-if="chatrooms.length === 0 && flashMessage === null" :messages="messages"/>
            <StandardTab :tabs="tabs" :active="active"/>
            <div v-if="chatrooms.length > 0" class="w-full mx-auto mt-8">
                <div class="bg-white rounded-lg border shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <ReviewYetCard @click="showModal(chatroom)" v-for="(chatroom, key) in chatrooms" :key="key" :chatroom="chatroom" :display-profile-path="setDisplayedProfilePath(chatroom.profile_image)"/>
                        </ul>
                    </div>
                </div>
            </div>
            <ReviewRegisterModal :isShow="isShow" :ids="ids" :url="'expert.review.store'" @emitIsShow="handleIsShow"/>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Experts/MyPageLayout'
import FixedMessage from '@/Components/Messages/FixedMessage'
import { commonConst } from '@/Consts/commonConst';
import ReviewRegisterModal from '@/Layouts/Users/ReviewRegisterModal'
import { ref, toRefs, reactive, watch, computed } from 'vue'
import StandardTab from '@/Components/Tabs/StandardTab'
import { expertReviewTabs } from '@/Consts/commonConst';
import ReviewYetCard from '@/Components/Cards/ReviewYetCard'
import { usePage } from '@inertiajs/inertia-vue3'
import useCommonAction from '@/Composables/useCommonAction'

export default {
    name: "Yet",
    components: {
        ReviewYetCard,
        ReviewRegisterModal,
        MyPageLayout,
        FixedMessage,
        StandardTab,
    },
    props: {
        chatrooms: Object,
    },
    setup(props) {
        const { chatrooms } = toRefs(props);
        const { PROFILE_PATH } = commonConst
        const { setDisplayedProfilePath } = useCommonAction();
        const tabs = expertReviewTabs;
        const active = 'yet';
        const isValidationShow = ref(false);
        const isShow = ref(false);

        const flashMessage = computed(() => usePage().props.value.flash.message)

        const ids = reactive({
            user_id: null,
            chatroom_id: null,
        });

        const showModal = (chatroom) => {
            ids.chatroom_id = chatroom.id
            ids.user_id = chatroom.user_id
            isShow.value = true;
        }

        const handleIsShow = (data) => {
            isShow.value = data
        }

        const messages = ref([]);
        const checkChatroomCount = () => {
            if (chatrooms.value.length === 0) {
                messages.value.push('未レビューはありません');
            }
        }
        checkChatroomCount()

        watch(chatrooms, () => {
            checkChatroomCount()
        })

        return {
            PROFILE_PATH,
            isShow,
            handleIsShow,
            showModal,
            chatrooms,
            ids,
            isValidationShow,
            tabs,
            active,
            messages,
            flashMessage,
            setDisplayedProfilePath,
        }
    }
}
</script>

<style scoped>

</style>
