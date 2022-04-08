<template>
    <my-page-layout>
        <template #content>
            <h2 class="mb-8 pt-8 base-font-m base-font-bold">プロフィール</h2>
            <form @submit.prevent="submit">
                <section class="mb-10">
                    <LabelRequired class="label" value="ニックネーム" for="nickname"/>
                    <InputForm id="nickname" type="text" class="w-full sm:w-1/2" v-model="form.nickname"/>
                </section>

                <section class="mb-10">
                    <Label class="label" value="プロフィール画像"/>
                    <div class="flex flex-col items-center lg:flex-row">
                        <label class="w-full md:w-1/2">
                            <div @dragenter="dragEnterProfile" @dragleave="dragLeaveProfile" @dragover.prevent
                                 @drop.prevent="dropProfileFile"
                                 :class="{enter: isEnterProfile}"
                                 class="border-dashed border-4 border-light-blue-500 h-40 flex items-center justify-center expert-hover hidden lg:flex">
                                ファイルアップロード
                            </div>
                            <input type="file" class="hidden" @change="uploadProfileImage">
                        </label>
                        <ul class="h-40 w-40 mt-10 md:ml-10 md:mt-0">
                            <li v-for="(file, index) in form.saved_profile_image" :key="index">
                                <div class="relative">
                                    <label>
                                        <img :src="displayedProfilePath + file"
                                             class="h-40 w-40 rounded-full object-cover expert-hover" alt="">
                                        <input type="file" class="hidden" @change="uploadProfileImage">
                                    </label>

                                </div>
                            </li>
                            <li v-for="(file, index) in form.profile_image" :key="index">
                                <div class="relative">
                                    <label>
                                        <img :src="file.url" class="h-40 w-40 rounded-full object-cove expert-hover"
                                             alt="">
                                        <input type="file" class="hidden" @change="uploadProfileImage">
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </section>

                <section class="mb-10">
                    <Label class="label" value="自己紹介" for="self_introduction"/>
                    <textarea id="self_introduction" class="base-form w-full" rows="2"
                              v-model="form.self_introduction"></textarea>
                </section>

                <div class="flex justify-center">
                    <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            type="submit"
                            class="expert-regular-btn mr-20">保存する
                    </button>
                    <Link :href="route('profile.show')" as="button" type="button" class="expert-outline-btn">戻る
                    </Link>
                </div>
            </form>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Users/MyPageLayout'
import Label from '@/Components/Labels/Label'
import LabelRequired from '@/Components/Labels/LabelRequired'
import InputForm from "@/Components/Forms/Input";
import { ref, toRefs } from 'vue'
import { useForm, Link } from '@inertiajs/inertia-vue3'
import useCommonAction from '@/Composables/useCommonAction'


export default {
    name: "Input",
    props: {
        profile: Object,
    },
    components: {
        MyPageLayout,
        Label,
        InputForm,
        Link,
        LabelRequired,
    },
    setup(props) {

        const { profile } = toRefs(props);

        const form = useForm({
            nickname: profile.value?.nickname ?? '',
            profile_image: [],
            saved_profile_image: [profile.value?.profile_image],
            delete_profile_image: [],
            self_introduction: profile.value?.self_introduction ?? '',
        });

        const { setDisplayedProfilePath } = useCommonAction();
        let displayedProfilePath = setDisplayedProfilePath(profile.value.profile_image);


        //プロフィール画像ドラッグ&ドロップ
        let isEnterProfile = ref(false)

        const dragEnterProfile = () => isEnterProfile.value = true
        const dragLeaveProfile = () => isEnterProfile.value = false

        const MAX_PROFILE_FILES = 1
        const dropProfileFile = () => {

            isEnterProfile.value = false
            if (event.dataTransfer.files.length >= 2) {
                return alert(`アップロードできる写真は${ MAX_PROFILE_FILES }枚です。`)
            }
            form.profile_image = [...event.dataTransfer.files]

            createImageUrl()
        }

        //プロフィール画像アップロード
        const uploadProfileImage = (event) => {
            form.profile_image = [...event.target.files]

            createImageUrl()
        }

        const createImageUrl = () => {
            if (form.saved_profile_image.length !== 0) {
                form.delete_profile_image = form.saved_profile_image
                form.saved_profile_image = []
            }
            form.profile_image.forEach(profileFile => profileFile['url'] = URL.createObjectURL(profileFile))
        }

        //フォーム送信
        const submit = () => {
            form.post(route('profile.update'), {
                forceFormData: true,
                onSuccess: () => {
                    form.reset()
                }
            })
        }

        return {
            dragEnterProfile,
            dragLeaveProfile,
            dropProfileFile,
            uploadProfileImage,
            isEnterProfile,
            displayedProfilePath,
            form,
            submit,
        }
    },
}
</script>

<style scoped lang="scss">
.enter {
    @apply border-solid border-blue-500
}

.label {
    @apply text-xl font-bold mr-10
}
</style>
