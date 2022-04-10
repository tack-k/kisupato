<template>
    <my-page-layout :isValidationShow="isValidationShow">
        <template #content>
            <FixedMessage v-if="chatrooms.length === 0 && flashMessage === null" :messages="messages"/>
            <StandardTab :tabs="tabs" :active="active"/>
            <div v-if="chatrooms.length > 0" class="w-full mx-auto mt-8">
                <div class="bg-white rounded-lg border shadow-md dark:bg-gray-800 dark:border-gray-700">
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <ReviewYetCard @click="showModal(chatroom)" v-for="(chatroom, key) in chatrooms" :key="key" :chatroom="chatroom" :display-profile-path="PROFILE_PATH"/>
                        </ul>
                    </div>
                </div>
            </div>
            <ReviewRegisterModal :isShow="isShow" :ids="ids" @emitIsShow="handleIsShow"/>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Users/MyPageLayout'
import FixedMessage from '@/Components/Messages/FixedMessage'
import { commonConst } from '@/Consts/commonConst';
import ReviewRegisterModal from '@/Layouts/Users/ReviewRegisterModal'
import { ref, toRefs, reactive, watch, computed } from 'vue'
import StandardTab from '@/Components/Tabs/StandardTab'
import { reviewTabs } from '@/Consts/commonConst';
import ReviewYetCard from '@/Components/Cards/ReviewYetCard'
import { usePage } from '@inertiajs/inertia-vue3'

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
        const tabs = reviewTabs;
        const active = 'yet';
        const isValidationShow = ref(false);
        const isShow = ref(false);

        const flashMessage = computed(() => usePage().props.value.flash.message)

        const ids = reactive({
            expert_id: null,
            chatroom_id: null,
        });

        const showModal = (chatroom) => {
            ids.chatroom_id = chatroom.id
            ids.expert_id = chatroom.expert_id
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
        }
    }
}
</script>

<style scoped>

</style>
