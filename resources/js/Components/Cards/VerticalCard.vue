<template>
    <div class="overflow-hidden shadow-lg rounded-lg h-90 w-60 md:w-80 cursor-pointer m-auto">
        <a href="#" class="w-full block h-full">
            <div class="relative">
                <button class="block" :disabled="isDisabled" @click="switchFavorite(profile.expert_id)">
                    <Fa :icon="faHeart" class="text-lg absolute right-2 top-2" :class="{'text-red-400': isFavorite}"/>
                </button>
                <!--                                最終的には活動画像の配列をカルーセルで表示させる-->
                <img alt="blog photo" :src="ACTIVITY_PATH + profile.activity_image"
                     class="max-h-40 w-full object-cover"/>
            </div>
            <div class="bg-white dark:bg-gray-800 w-full p-4">
                <ul>
                    <li class="text-indigo-500 text-md font-medium"
                        v-for="(position, index) in profile.positions" :key="index">
                        {{ position.position }}
                    </li>
                </ul>
                <p class="text-gray-800 dark:text-white text-xl font-medium mb-2">
                    {{ profile.activity_title }}
                </p>
                <p class="text-gray-400 dark:text-gray-300 font-light text-md">
                    {{ profile.activity_content }}
                </p>
                <div class="flex items-center mt-4">
                    <a href="#" class="block relative">
                        <img alt="profile" :src="PROFILE_PATH + profile.profile_image"
                             class="mx-auto object-cover rounded-full h-10 w-10 "/>
                    </a>
                    <div class="flex flex-col justify-between ml-4 text-sm">
                        <p class="text-gray-800 dark:text-white">
                            {{ profile.nickname }}
                        </p>
                        <ul class="flex">
                            <li class="text-gray-400 dark:text-gray-300 ml-4"
                                v-for="(tag, index) in profile.tags" :key="index">
                                {{ tag.tag }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </a>
    </div>
</template>

<script>
import { faHeart } from "@fortawesome/free-solid-svg-icons"
import Fa from 'vue-fa';
import { commonConst } from "@/Consts/commonConst"
import { reactive, ref, toRefs } from "vue";


export default {
    name: "VerticalCard",
    components: {
        Fa,

    },
    props: {
        profile: Object,
    },
    setup(props) {
        let { profile } = toRefs(props);
        const { PROFILE_PATH, ACTIVITY_PATH } = commonConst;
        let isFavorite = ref(profile.value.favorite_id !== null);
        let isDisabled = ref(false);

        const switchFavorite = (expertId) => {
            isDisabled.value = true;
            const params = reactive({
                expert_id: expertId,
            })

            axios.post(
                route('favorite.switch'),
                params
            ).then((res) => {
                isFavorite.value = !isFavorite.value
            }).catch((res) => {
                alert('エラーが発生しました。時間をおいてから再度お試しください')
            })
            isDisabled.value = false;
        }

        return {
            profile,
            PROFILE_PATH,
            ACTIVITY_PATH,
            faHeart,
            switchFavorite,
            isFavorite,
            isDisabled,
        }
    }
}
</script>

<style scoped>

</style>
