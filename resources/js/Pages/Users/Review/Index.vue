<template>
    <my-page-layout>
        <template #content>
            <FixedMessage v-if="messages.length > 0" :messages="messages"/>
            <StandardTab :tabs="tabs" :active="active"/>
            <h2 class="mb-8 pt-8 base-font-m base-font-bold">{{ reviewCount }}件のレビュー</h2>
            <div v-if="reviews.length > 0" class="flex flex-col items-start">
                <template v-for="(review, key) in reviews" :key="key">
                    <ReviewCard :review="review" :display-profile-path="PROFILE_PATH"/>
                </template>
            </div>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Users/MyPageLayout'
import ReviewCard from "@/Components/Cards/ReviewCard";
import FixedMessage from '@/Components/Messages/FixedMessage'
import StandardTab from '@/Components/Tabs/StandardTab'
import { commonConst, userReviewTabs } from '@/Consts/commonConst';
import { ref, toRefs } from 'vue'


export default {
    name: "Index",
    components: {
        MyPageLayout,
        ReviewCard,
        FixedMessage,
        StandardTab,
    },
    props: {
        reviews: Object,
        messages: Array,
    },
    setup(props) {
        const { reviews, messages } = toRefs(props);
        const { PROFILE_PATH } = commonConst;

        const tabs = userReviewTabs;

        const active = 'index';

        const reviewCount = Object.keys(reviews.value).length;

        const isLimit = ref(true);

        return {
            reviews,
            messages,
            tabs,
            active,
            reviewCount,
            isLimit,
            PROFILE_PATH,
        }
    }

}
</script>

<style scoped>

</style>
