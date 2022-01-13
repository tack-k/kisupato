<template>
    <my-page-layout>
        <template #content>
            <section class="mb-10">
                <div class="flex mb-4">
                    <h2 class="base-font-m base-font-bold mr-10">ステータス：【{{ options[profile.status].name }}】</h2>
                    <form @submit.prevent="submitStatus">
                        <regular-button v-if="profile.status === '1'" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">公開する</regular-button>
                        <regular-button v-else :class="{ 'opacity-25': form.processing }" :disabled="form.processing">非公開にする</regular-button>
                    </form>
                </div>
                <div class="my-5">
                    <Link :href="route('expert.profile.input')" as="button" type="button" class="expert-regular-btn">
                        プロフィール編集
                    </Link>
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
                <h2 class="base-font-m base-font-bold mb-4">タグ</h2>
                <ul>
                    <li v-for="(tag, index) in profile.tags" :key="index">{{ tag.name }}</li>
                </ul>
            </section>

            <section class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">肩書</h2>
                <ul>
                    <li v-for="(position, index) in profile.positions" :key="index">{{ position.name }}</li>
                </ul>
            </section>

            <section class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">活動拠点</h2>
                <p>{{ profile.activity_base }}</p>
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
                                    <img :src="ACTIVITY_PATH + activity_image.activity_image"
                                         class="rounded-md h-40 object-cover" alt=""/>
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
import {Link, useForm} from "@inertiajs/inertia-vue3";
import RegularButton from "@/Components/Buttons/RegularButton";
import {reactive, watch, watchEffect} from "vue"


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
        const NO_SKILL_TITLE = '提供技術タイトルを入力してください'
        const NO_SKILL_CONTENT = '提供技術内容を入力してください'

        const options = reactive([
            {'id': 0, 'name': '公開'},
            {'id': 1, 'name': '非公開'},
        ])

        const form = useForm({
            status: props.profile.status
        })

        let profile = reactive({
            status: props.profile.status,
            nickname: props.profile.nickname ?? 'ニックネームを入力してください',
            profile_image: props.profile.profile_image.length === 0 ? 'default_profile.png' : props.profile.profile_image,
            activity_images: props.profile.activity_images.length === 0 ? [{'activity_image': 'default_activity.png'}] : props.profile.activity_images,
            activity_title: props.profile.activity_title ?? '活動タイトルを入力してください',
            activity_content: props.profile.activity_content ?? '活動内容を入力してください',
            skills: props.profile.skills.length === 0 ? [{
                skill_title: NO_SKILL_TITLE,
                skill_content: NO_SKILL_CONTENT,
            }] : props.profile.skills,
            activity_base: props.profile.city_name ?? '活動市町村を入力してください',
            tags: props.profile.tags ?? [{name: 'タグを入力してください'}],
            positions: props.profile.positions ?? [{name: '肩書を入力してください'}]

        })

        watchEffect(() => {
            profile.status = props.profile.status
        })

        profile.skills.map((skill, index) => {
            skill.skill_title = skill.skill_title ?? NO_SKILL_TITLE
            skill.skill_content = skill.skill_content ?? NO_SKILL_CONTENT
        })

        const submitStatus = () => {
           form.status = form.status === '1' ? '0' : '1'
            form.post(route('expert.profile.status'), {
                onError: () => {
                    form.status = props.profile.status
                    alert('ステータスを変更できませんでした。時間をおいて再度お試しください')
                }
            })
        }


        return {
            PROFILE_PATH,
            ACTIVITY_PATH,
            options,
            profile,
            submitStatus,
            form,
        }
    }
}
</script>

<style scoped>

</style>
