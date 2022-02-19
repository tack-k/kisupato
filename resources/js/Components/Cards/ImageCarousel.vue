<template>
    <carousel :settings="settings" :breakpoints="breakpoints" :wrap-around="true">
        <template #slides>
            <slide v-for="(activityImage, index) in activityImages" :key="index">
                <div class="mx-2 w-full">
                    <img :src="ACTIVITY_PATH + activityImage.activity_image" alt="" :class="{'h-80': isManyImage, 'image-height': !isManyImage}" class="object-cover h-80  w-full">
                </div>
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
import { Carousel, Slide, Pagination, Navigation } from 'vue3-carousel';
import { reactive, toRefs, ref } from "vue";
import { commonConst } from "@/Consts/commonConst";


export default {
    name: "ImageCarousel",
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
        const { activityImages } = toRefs(props);
        const { ACTIVITY_PATH } = commonConst;
        let breakpoints = reactive({})
        const isManyImage = ref(null)

        const settings = {
            itemsToShow: 1,
        }

        const setBreakPoints = () => {
            if (activityImages.value.length >= 4) {
                isManyImage.value = true;
                breakpoints = {
                    // 640px and up
                    640: {
                        itemsToShow: 1.5,
                    },
                    // 1024 and up
                    1024: {
                        itemsToShow: 2.5,
                    },
                }
            } else {
                isManyImage.value = false;
                breakpoints = {
                    // 640px and up
                    640: {
                        itemsToShow: 1,
                    },
                    // 1024 and up
                    1024: {
                        itemsToShow: 1,
                    },
                }
            }
        }
        setBreakPoints();


        return {
            activityImages,
            ACTIVITY_PATH,
            settings,
            breakpoints,
            isManyImage,
        }
    }
}
</script>

<style scoped lang="scss">
@media screen and (min-width: 640px) {
    .image-height {
        height: 40rem;
    }
}


</style>
