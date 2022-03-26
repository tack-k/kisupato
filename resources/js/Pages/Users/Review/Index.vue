<template>
    <my-page-layout>
        <template #content>
            <StandardTab :tabs="tabs" :active="active"/>
            <h2 class="mb-8 pt-8 base-font-m base-font-bold">レビュー一覧</h2>
            <FixedMessage v-if="messages.length > 0" :messages="messages"/>
            <div v-if="reviews.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
                <template v-for="(review, key) in reviews" :key="key">
                    <ReviewCard :review="review"/>
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
import { reviewTabs } from '@/Consts/commonConst';


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
        const { reviews, messages } = props;

        const tabs = reviewTabs;

        const active = 'index';

        return {
            reviews,
            messages,
            tabs,
            active,
        }
    }

}
</script>

<style scoped>

</style>
