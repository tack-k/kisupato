<template>
    <my-page-layout :isValidationShow="isValidationShow">
        <template #content>
            <StandardTab :tabs="tabs" :tab="active"/>
            <div class="pt-8" v-if="chatrooms.length === 0">
                <FixedMessage>未レビューの人材はいません。</FixedMessage>
            </div>
            <section v-else class="container mx-auto p-6 font-mono">
                <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full">
                            <thead>
                            <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                                <th class="px-4 py-3"></th>
                                <th class="px-4 py-3">専門人材</th>
                                <th class="px-4 py-3">依頼完了日</th>
                                <th class="px-4 py-3">レビュー可能日</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <tr @click="showModal(chatroom)" class="text-gray-700 user-hover hover:bg-gray-100" v-for="(chatroom, index) in chatrooms" :key="index">
                                <td class="px-4 py-3 border">
                                    <img class="object-cover w-12 h-12 rounded-full" :src="PROFILE_PATH + chatroom.profile_image" alt="" loading="lazy"/>
                                </td>
                                <td class="px-4 py-3 text-xs font-semibold border">
                                    <p class="font-semibold text-black">{{ chatroom.nickname }}</p>

                                </td>
                                <td class="px-4 py-3 text-sm border">{{ chatroom.request_finished_at }}</td>
                                <td class="px-4 py-3 text-sm border">{{ chatroom.request_enable_day }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <ReviewRegisterModal :isShow="isShow" :ids="ids" @emitIsShow="handleIsShow"/>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Users/MyPageLayout'
import FixedMessage from '@/Components/Messages/FixedMessage'
import { commonConst } from '@/Consts/commonConst';
import ReviewRegisterModal from '@/Layouts/Users/ReviewRegisterModal'
import { ref, toRefs, reactive } from 'vue'
import StandardTab from '@/Components/Tabs/StandardTab'
import { reviewTabs } from '@/Consts/commonConst';

export default {
    name: "Yet",
    components: {
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
        }
    }
}
</script>

<style scoped>

</style>
