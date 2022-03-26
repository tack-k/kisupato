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
            <p>{{ review.comment }}</p>
        </div>
        <div class="text-right">
            <span class="text-blue-300 user-hover">続きを読む</span>
        </div>
    </div>
</template>

<script>
import StarRating from 'vue-star-rating'
import { commonConst } from "@/Consts/commonConst";


export default {
    name: "ReviewCard",
    components: {
        StarRating,
    },
    props: {
        review: Object,
    },
    setup(props) {
        const { review } = props;
        const { PROFILE_PATH } = commonConst;

        const rating ={
            increment: 0.5,
            starSize: 15,
            readOnly: true,
            rating: review.evaluation,
            showRating: false,
        };

        return {
            review,
            rating,
            PROFILE_PATH,
        }
    }
}
</script>

<style scoped>

</style>
