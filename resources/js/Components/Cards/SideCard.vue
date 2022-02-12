<template>
    <div class="flex bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="w-1/2 bg-cover bg-center" :style="{backgroundImage: 'url(' + ACTIVITY_PATH + profile.activity_image + ')'}">
        </div>
        <div class="w-1/2 p-4">
            <h1 class="text-gray-900 font-bold text-2xl">{{ profile.activity_title }}</h1>
            <p class="mt-2 text-gray-600 text-sm">{{ profile.activity_content }}</p>
            <div class="flex item-center mt-2">
                <svg class="w-5 h-5 fill-current text-gray-700" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z"/>
                </svg>
                <svg class="w-5 h-5 fill-current text-gray-700" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z"/>
                </svg>
                <svg class="w-5 h-5 fill-current text-gray-700" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z"/>
                </svg>
                <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z"/>
                </svg>
                <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z"/>
                </svg>
            </div>
            <div>
                <div class="flex mt-5">
                    <img alt="profile" class="w-12 h-12 rounded-full border-2 border-gray-300" :src="PROFILE_PATH + profile.profile_image"/>
                    <div>
                        <p class="ml-3">{{ profile.nickname }}</p>
                        <ul>
                            <li v-for="(position, index) in profile.positions" :key="index" class="ml-3 text-gray-700 font-bold text-sm py-2">
                                {{ position.position }}
                            </li>
                        </ul>
                    </div>
                </div>

                <ul class="flex">
                    <li v-for="(tag, index) in profile.tags" :key="index" class="ml-3 px-2 py-1 bg-gray-800 text-white text-xs font-bold uppercase rounded">
                        {{ tag.tag }}
                    </li>
                </ul>
            </div>

        </div>
    </div>
</template>

<script>
import {toRefs} from "vue";
import {commonConst} from "@/Consts/commonConst";

export default {
    name: "SideCard",
    props: {
        profile: Object,
    },
    setup(props) {
        const {profile} = toRefs(props)
        const {PROFILE_PATH, ACTIVITY_PATH} = commonConst;

        return {
            profile,
            ACTIVITY_PATH,
            PROFILE_PATH,
        }
    }
}
</script>

<style scoped>

</style>
