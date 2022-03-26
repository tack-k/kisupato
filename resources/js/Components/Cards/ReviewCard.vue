<template>
    <div class="container mx-auto shadow-lg rounded-lg max-w-md hover:shadow-2xl transition duration-300 p-4">
        <div class="flex items-center mb-5">
            <div class="w-1/2">
                <img :src="PROFILE_PATH + review.profile_image" alt="" class="rounded-full w-20 h-20">
            </div>
            <div class="w-1/2 break-words px-1">
                <p class="mb-2">{{ review.nickname }}</p>
                <p class="mb-2">{{ review.created_date }}</p>
                <p><StarRating :increment="rating.increment" :read-only="rating.readOnly" :star-size="rating.starSize" :rating="rating.rating" :show-rating="rating.showRating"/></p>
            </div>
        </div>
        <div>
            <p :class="{'limit-string': isLimit}">{{ review.comment }}</p>
        </div>
        <div v-if="!isNoComment" class="text-right mt-0.5">
            <span @click="toggleComment" class="text-blue-300 user-hover">{{ text }}</span>
        </div>
    </div>
</template>

<script>
import StarRating from 'vue-star-rating'
import { commonConst } from "@/Consts/commonConst";
import { ref, toRefs, watch } from 'vue';


export default {
    name: "ReviewCard",
    components: {
        StarRating,
    },
    props: {
        review: Object,
    },
    setup(props, {emit}) {
        const { review } = toRefs(props);
        const { PROFILE_PATH } = commonConst;

        const rating ={
            increment: 0.5,
            starSize: 15,
            readOnly: true,
            rating: review.value.evaluation,
            showRating: false,
        };

        const isLimit = ref(true)

        const isNoComment = ref(false)
        if (review.value.comment.length === 0) {
            isNoComment.value = true
        }

        const toggleComment = () => {
            isLimit.value = !isLimit.value
        }

        const text = ref('続きを見る')
        watch(isLimit, () => {
            text.value = isLimit.value ? '続きを見る' : '閉じる';
        })




        return {
            review,
            rating,
            PROFILE_PATH,
            isLimit,
            toggleComment,
            text,
            isNoComment,
        }
    }
}
</script>

<style scoped>
.limit-string {
    display: -webkit-box;
    overflow: hidden;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}
</style>
