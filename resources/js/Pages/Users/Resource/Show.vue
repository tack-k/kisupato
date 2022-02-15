<template>
    <full-page-layout>
        <template #content>
            <div class="container my-0 mx-auto">
                <div class="max-w-screen-lg sm:px-8 my-0 mx-auto">
                    <section class="section-common">
                        <div class="mt-10">
                            <SearchInput/>
                        </div>
                        <h1 class="base-font-l base-font-bold my-20 text-center">{{ profile.activity_title }}</h1>
                        <ImageGrid/>
                        <div class="flex max-w-screen-lg flex-col sm:flex-row my-0 mx-auto items-center :items-start mt-8">
                            <div class="flex w-full sm:w-3/5 flex-col sm:flex-row">
                                <div class="w-full sm:w-1/4 flex flex-col items-center">
                                    <div class="mb-5">
                                        <img :src="'/images/users/profile.png'" alt="" class="w-40 sm:w-24 h-40 sm:h-24 rounded-full">
                                    </div>
                                    <p>{{ profile.nickname }}</p>
                                </div>
                                <div class="p-3 w-full sm:w-3/4">
                                    <span class="base-font-bold mb-5 user-text-white user-bg-active py-0.5 px-1 text-xs rounded">スーパー人材</span>
                                    <p class="pt-2">{{ profile.self_introduction }}</p>
                                </div>
                            </div>
                            <div class="flex justify-center items-center w-full sm:w-2/5">
                                <regular-button class="px-16 py-4 font-medium">相談する</regular-button>
                            </div>
                        </div>
                    </section>
                    <section class="section-common px-4 sm:px-0">
                        <h2 class="section-title">活動内容</h2>
                        <p>{{ profile.activity_content }}</p>
                    </section>
                    <section class="section-common px-4 sm:px-0">
                        <h2 class="section-title">提供技術</h2>
                        <div v-for="(skill, index) in profile.skills" :key="index" class="mb-5">
                            <h3 class="base-font-s base-font-bold mb-2">{{ skill.skill_title }}</h3>
                            <p>{{ skill.skill_content }}</p>
                        </div>
                        <div class="flex justify-center items-center w-full">
                            <regular-button class="px-16 py-4 font-medium">相談する</regular-button>
                        </div>
                    </section>

                    <section class="section-common">
                        <div class="bg-gray-100 min-h-screen py-32 px-10 ">
                            <h2 class="section-title">レビュー</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 md:gap-x-10 xl-grid-cols-4 gap-y-10 gap-x-6 ">
                                <template v-for="(value, index) in 6" :key="index">
                                    <ReviewCard/>
                                </template>
                            </div>
                            <div class="text-right mt-5">
                                <span class="text-blue-300 user-hover">○件のレビューをすべて表示</span>
                            </div>
                        </div>
                    </section>

                    <section class="section-common px-4 sm:px-0">
                        <h2 class="section-title">この人材をチェックした人におすすめ</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-12">
                            <template v-for="(profile, key) in profiles" :key="key">
                                <VerticalCard :profile="profile"/>
                            </template>
                        </div>
                    </section>

                </div>
            </div>
        </template>
    </full-page-layout>
</template>

<script>
import FullPageLayout from "@/Layouts/Users/FullPageLayout";
import SearchInput from "@/Components/Forms/RoundSearch";
import ImageGrid from "@/Components/Cards/ImageGrid";
import RegularButton from "@/Components/Buttons/RegularButton";
import ReviewCard from "@/Components/Cards/ReviewCard";
import {toRefs} from "vue";

export default {
    name: "Show",
    components: {ReviewCard, RegularButton, ImageGrid, SearchInput, FullPageLayout},
    props: {
        profile: Object,
    },
    setup(props) {
        const {profile} = toRefs(props)

        return {
            profile,
        }
    }
}
</script>

<style scoped lang="scss">
.section-title {
    @apply text-2xl mb-3 font-bold
}

.section-common {
    @apply mb-24
}

</style>
