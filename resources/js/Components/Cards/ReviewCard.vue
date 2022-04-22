<template>
    <div class="container shadow-lg rounded-lg max-w-md hover:shadow-2xl transition duration-300 p-4 sm:p-8 mb-4">
        <div class="flex items-center mb-5">
            <div class="grow-0 min-w-fit">
                <img :src="displayProfilePath + review.profile_image" alt="" class="rounded-full w-20 h-20">
            </div>
            <div class="grow break-all px-5">
                <p class="mb-2">{{ review.nickname }}</p>
                <p class="mb-2">{{ review.created_date }}</p>
                <p>
                    <StarRating :increment="rating.increment" :read-only="rating.readOnly" :star-size="rating.starSize" :rating="rating.rating"/>
                </p>
            </div>
        </div>
        <div>
            <p :class="{'limit-string': isShowNext}">{{ review.comment }}</p>
        </div>
        <div v-if="isShowNext" class="text-right mt-0.5">
            <span @click="openComment" class="text-blue-300 user-hover">続きを見る</span>
        </div>
    </div>
</template>

<script>
import StarRating from 'vue-star-rating'
import { ref, toRefs, watch } from 'vue';
import useCommonAction from '@/Composables/useCommonAction'
import { commonConst } from '@/Consts/commonConst'


export default {
    name: "ReviewCard",
    components: {
        StarRating,
    },
    props: {
        review: Object,
        displayProfilePath: String,
    },
    setup(props, { emit }) {
        const { review, displayProfilePath } = toRefs(props);

        const rating = {
            increment: 0.5,
            starSize: 15,
            readOnly: true,
            rating: review.value.evaluation,
        };

        const { MAX_REVIEW_COUNT } = commonConst;

        const isLimit = ref(true)


        const isShowNext = ref(false);
        if(review.value.comment.length > MAX_REVIEW_COUNT) {
            isShowNext.value = true
        }

        const openComment = () => isLimit.value = false;
        watch(isLimit, () => {
            isShowNext.value = false
        })


        return {
            review,
            rating,
            displayProfilePath,
            isLimit,
            openComment,
            isShowNext,
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

.min-w-fit {
    min-width: fit-content;
}
</style>
