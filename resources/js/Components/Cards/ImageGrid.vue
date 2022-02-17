<template>
    <carousel :items-to-show="1" :wrap-around="true">
        <template #slides>
            <slide v-for="(activityImage, index) in activityImages" :key="index">
                <img :src="ACTIVITY_PATH + activityImage.activity_image" alt="">
            </slide>
        </template>

        <template #addons>
            <navigation/>
            <pagination/>
        </template>
    </carousel>
</template>

<script>
import 'vue3-carousel/dist/carousel.css';
import {Carousel, Slide, Pagination, Navigation} from 'vue3-carousel';
import {toRefs} from "vue";
import {commonConst} from "@/Consts/commonConst";


export default {
    name: "ImageGrid",
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation,
    },
    props: {
        activityImages: Array,
    },
    setup(props) {
        const {activityImages} = toRefs(props);
        const {ACTIVITY_PATH} = commonConst;
        const slideWidth = 100;


        return {
            activityImages,
            ACTIVITY_PATH,
            slideWidth
        }
    }
}
</script>

<style scoped>

</style>
