<template>
    <my-page-layout>
        <template #content>
            <section class="mb-10">
                <LabelRequired class="label" value="ステータス" for="status"/>
                <p>{{ options[params.status].name }}</p>
            </section>

            <section class="mb-10">
                <LabelRequired class="label" value="ニックネーム" for="nickname"/>
                <p>{{ params.nickname }}</p>
            </section>

            <section class="mb-10">
                <LabelRequired class="label" value="プロフィール画像"/>
                <div class="h-40 w-40 mt-10">
                    <img :src="params.profile_image.profile_image_path + params.profile_image.profile_image_extension" class="h-40 w-40 rounded-full object-cover" alt="">
                </div>
            </section>

            <section class="mb-10">
                <LabelRequired class="label" value="自己紹介" for="self_introduction"/>
                <p>{{ params.self_introduction }}</p>
            </section>

            <section class="mb-10">
                <LabelRequired class="label" value="活動タイトル" for="activity_title"/>
                <p>{{ params.activity_title }}</p>
            </section>

            <section class="mb-10">
                <LabelRequired class="label" value="活動写真" for="activity_title"/>
                <div class="w-full flex">
                    <!-- main -->
                    <main class="w-full">
                        <div class="grid grid-cols-4 gap-4">
                            <div v-for="(activity_image, index) in params.activity_images" :key="index"
                                 class="col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-1 xl:col-span-1 flex flex-col items-center">
                                <div class="bg-white rounded-lg mt-5 relative">
                                    <img
                                        :src="activity_image.activity_image_path + activity_image.activity_image_extension"
                                        class="rounded-md h-40 object-cover" alt="">
                                </div>
                            </div>
                            <!-- end cols -->
                        </div>
                    </main>
                </div>
            </section>

            <section class="mb-10">
                <LabelRequired class="label" value="提供スキル" for="activity_title"/>
                <div v-for="(skill, index) in params.skills" :key="skill" class="mb-6">
                    <div class="mb-4">
                        <h3 class="base-font-s base-font-bold mb-2">タイトル{{ index + 1 }}</h3>
                        <p>{{ skill.skill_title }}</p>
                    </div>
                    <div>
                        <h3 class="base-font-s base-font-bold mb-2">内容{{ index + 1 }}</h3>
                        <p>{{ skill.skill_content }}</p>
                    </div>
                </div>

            </section>

            <div class="flex justify-center">
                <Link href="#" as="button" type="button" class="expert-regular-btn mr-20">確定する</Link>
                <Link href="#" as="button" type="button" class="expert-outline-btn">戻る</Link>
            </div>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from "@/Layouts/Experts/MyPageLayout";
import {useForm, usePage, Link} from "@inertiajs/inertia-vue3";
import RegularButton from "@/Components/Buttons/RegularButton";
import Select from "@/Components/Forms/Select";
import {ref, reactive} from "vue"
import Input from "@/Components/Forms/Input";
import {faTimes} from "@fortawesome/free-solid-svg-icons"
import Fa from 'vue-fa';
import LabelRequired from "@/Components/Labels/LabelRequired";
import OutlineButton from "@/Components/Buttons/OutlineButton";

export default {
    name: "Show",
    components: {
        OutlineButton,
        LabelRequired,
        Input,
        Select,
        RegularButton,
        MyPageLayout,
        Fa,
        Link,
    },
    props: {
        params: Object,
    },

    setup(props) {
        const params = props.params


        const options = reactive([
            {'id': 0, 'name': '公開'},
            {'id': 1, 'name': '非公開'},
        ])

        const form = useForm({
            status: '',
            nickname: '',
            image: '',
            self_introduction: '',
            activity_title: '',
            activity_image: [],
            activity_content: [],
            skills: [{skill_title: '', skill_content: ''}]
        })


        //フォーム送信
        const expertId = usePage().props.value.auth.expert.id

        const submit = () => {
            form.post(route('expert.profile.update', expertId), {
                onSuccess: () => {
                    form.reset()
                }
            })
        }

        return {
            options,
            params,
            submit,
        }
    }
}
</script>

<style scoped lang="scss">
.enter {
    @apply border-solid border-blue-500
}

.label {
    @apply text-2xl font-bold mr-10
}

</style>
