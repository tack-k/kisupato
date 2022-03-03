<template>
    <div class="overflow-hidden shadow-lg rounded-lg h-90 w-60 md:w-80 cursor-pointer m-auto">
        <Link @click.prevent :href="route('resource.show', profile.expert_id)" class="w-full block h-full">
            <div class="relative">
                <!--                                最終的には活動画像の配列をカルーセルで表示させる-->
                <img alt="blog photo" :src="ACTIVITY_PATH + profile.activity_image"
                     class="max-h-40 w-full object-cover"/>
            </div>
            <div class="bg-white dark:bg-gray-800 w-full p-4">
                <ul>
                    <li class="text-indigo-500 text-md font-medium"
                        v-for="(position, index) in profile.positions" :key="index">
                        {{ position }}
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
                                {{ tag }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </Link>
    </div>
</template>

<script>
import FavoriteButton from '@/Components/Buttons/FavoriteButton'
import { Link } from '@inertiajs/inertia-vue3'
import { toRefs } from 'vue'
import { commonConst } from '@/Consts/commonConst'

export default {
    name: "VerticalCardNoFavoriteButton",
    components: { FavoriteButton, Link },
    props: {
        profile: Object,
    },
    setup(props) {
        let { profile } = toRefs(props);
        const { PROFILE_PATH, ACTIVITY_PATH } = commonConst;


        return {
            profile,
            PROFILE_PATH,
            ACTIVITY_PATH,
        }
    }
}
</script>

<style scoped>

</style>
