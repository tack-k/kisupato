<template>
    <my-page-layout>
        <template #content>
            <section class="mb-10">
                <div class="flex mb-4">
                    <h2 class="base-font-m base-font-bold mr-10">【{{ options[profile.status].name }}】</h2>
                    <regular-button class="expert-bg-active">編集する</regular-button>
                </div>
                <div class="flex flex-col items-center md:flex-row">
                    <div class="flex flex-col items-center mb-8 md:mb-0">
                        <div class="mb-3">
                            <img
                                class="h-40 w-40 rounded-full object-cover"
                                :src="PROFILE_PATH + profile.profile_image"
                                alt=""
                            />
                        </div>
                        <p>{{ profile.nickname }}</p>
                    </div>
                    <p class="md:ml-8">{{ profile.self_introduction }}</p>
                </div>
            </section>

            <section class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">活動タイトル</h2>
                <p>{{ profile.activity_title }}</p>
            </section>

            <section class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">活動内容</h2>
                <p>{{ profile.activity_content }}</p>
            </section>

            <section class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">活動写真</h2>
                <div class="w-full flex">
                    <!-- main -->
                    <main class="w-full">
                        <div class="grid grid-cols-4 gap-4">
                            <div v-for="(activity_image, index) in profile.activity_images" :key="index"
                                 class="col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-1 xl:col-span-1 flex flex-col items-center">
                                <div class="bg-white rounded-lg mt-5">
                                    <img :src="ACTIVITY_PATH + activity_image.activity_image" class="rounded-md h-40 object-cover" alt=""/>
                                </div>
                            </div>
                            <!-- end cols -->
                        </div>
                    </main>
                </div>
            </section>

            <section class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">提供技術</h2>
                <div v-for="(skill, index) in profile.skills" :key="index" class="mb-6">
                    <div class="mb-4">
                        <h3 class="base-font-s base-font-bold mb-2">{{ index + 1 }}.{{ skill.skill_title }}</h3>
                        <p>{{ skill.skill_content }}</p>
                    </div>
                </div>
            </section>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from "@/Layouts/Experts/MyPageLayout";
import {Link} from "@inertiajs/inertia-vue3";
import RegularButton from "@/Components/Buttons/RegularButton";
import { reactive } from "vue"


export default {
    name: "Show",
    components: {
        RegularButton,
        MyPageLayout,
        Link,
    },
    props: {
      profile: Object,
    },
    setup(props) {
        const PROFILE_PATH = '/storage/profile_images/'
        const ACTIVITY_PATH = '/storage/activity_images/'
        const options = reactive([
            {'id': 0, 'name': '公開'},
            {'id': 1, 'name': '非公開'},
        ])
        return {
            PROFILE_PATH,
            ACTIVITY_PATH,
            options,
        }
    }
}
</script>

<style scoped>

</style>
