<template>
    <my-page-layout>
        <template #content>
            <form @submit.prevent="submit">
                <section class="mb-10">
                    <LabelRequired class="label" value="ステータス" for="status"/>
                    <Select :options="options" id="status" v-model="form.status"/>
                </section>

                <section class="mb-10">
                    <LabelRequired class="label" value="ニックネーム" for="nickname"/>
                    <InputForm id="nickname" type="text" v-model="form.nickname"/>
                </section>

                <section class="mb-10">
                    <LabelRequired class="label" value="プロフィール画像"/>
                    <div class="flex flex-col items-center md:flex-row">
                        <div @dragenter="dragEnterSelf" @dragleave="dragLeaveSelf" @dragover.prevent
                             @drop.prevent="dropSelfFile"
                             :class="{enter: isEnterSelf}"
                             class="border-dashed border-4 border-light-blue-500 h-40 flex items-center justify-center w-full md:w-1/2">
                            ファイルアップロード
                        </div>
                        <ul class="h-40 w-40 mt-10 md:ml-10 md:mt-0">
                            <li v-for="(file, index) in form.saved_profile_image" :key="index">
                            <div class="relative">
                                    <img :src="PROFILE_PATH + file" class="h-40 w-40 rounded-full object-cover" alt="">
                                    <Fa :icon="faTimes" @click="deleteSavedProfileFile(index)"
                                        class="absolute expert-hover top-2 right-2"/>
                                </div>
                            </li>
                            <li v-for="(file, index) in form.profile_image" :key="index">
                                <div class="relative">
                                    <img :src="file.url" class="h-40 w-40 rounded-full object-cover" alt="">
                                    <Fa :icon="faTimes" @click="deleteProfileFile(index)"
                                        class="absolute expert-hover top-2 right-2"/>
                                </div>
                            </li>
                        </ul>
                    </div>
                </section>

                <section class="mb-10">
                    <LabelRequired class="label" value="自己紹介" for="self_introduction"/>
                    <textarea id="self_introduction" class="base-form w-full" rows="2"
                              v-model="form.self_introduction"></textarea>
                </section>

                <section class="mb-10">
                    <LabelRequired class="label" value="活動タイトル" for="activity_title"/>
                    <textarea id="activity_title" class="base-form w-full" rows="2"
                              v-model="form.activity_title"></textarea>
                </section>

                <section class="mb-10">
                    <LabelRequired class="label" value="活動内容" for="activity_content"/>
                    <textarea id="activity_content" class="base-form w-full" rows="5"
                              v-model="form.activity_content"></textarea>
                </section>

                <section class="mb-10">
                    <LabelRequired class="label" value="活動写真" for="activity_title"/>
                    <div @dragenter="dragEnterActivity" @dragleave="dragLeaveActivity" @dragover.prevent
                         @drop.prevent="dropActivityFile"
                         :class="{enter: isEnterActivity}"
                         class="border-dashed border-4 border-light-blue-500 h-40 flex items-center justify-center w-full md:w-1/2">
                        ファイルアップロード
                    </div>
                    <div class="w-full flex">
                        <!-- main -->
                        <main class="w-full">
                            <ul class="grid grid-cols-4 gap-4">
                                <li v-for="(saved_activity_image, index) in form.saved_activity_images" :key="index"
                                    class="col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-1 xl:col-span-1 flex flex-col items-center">
                                    <div class="bg-white rounded-lg mt-5 relative">
                                        <img :src="ACTIVITY_PATH + saved_activity_image.activity_image" class="rounded-md h-40 object-cover" alt="">
                                        <Fa :icon="faTimes" @click="deleteSavedActivityFile(index)"
                                            class="absolute expert-hover top-2 right-2"/>
                                    </div>
                                </li>
                                <li v-for="(activity_image, index) in form.activity_images" :key="index"
                                     class="col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-1 xl:col-span-1 flex flex-col items-center">
                                    <div class="bg-white rounded-lg mt-5 relative">
                                        <img :src="activity_image.url" class="rounded-md h-40 object-cover" alt="">
                                        <Fa :icon="faTimes" @click="deleteActivityFile(index)"
                                            class="absolute expert-hover top-2 right-2"/>
                                    </div>
                                </li>
                                <!-- end cols -->
                            </ul>
                        </main>
                    </div>
                </section>

                <section class="mb-10">
                    <LabelRequired class="label" value="提供スキル" for="activity_title"/>
                    <div v-for="(skill, index) in form.skills" :key="skill" class="mb-6">
                        <div class="mb-4">
                            <h3 class="base-font-s base-font-bold mb-2">タイトル{{ index + 1 }}</h3>
                            <textarea class="base-form w-full" rows="2" v-model="skill.skill_title"></textarea>
                        </div>
                        <div>
                            <h3 class="base-font-s base-font-bold mb-2">内容{{ index + 1 }}</h3>
                            <textarea class="base-form w-full" rows="5" v-model="skill.skill_content"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button @click="addSkill" v-show="isAddSkill" class="expert-regular-btn mr-4" type="button">追加</button>
                        <button @click="deleteSkill" v-show="isDeleteSkill" class="expert-outline-btn" type="button">削除</button>
                    </div>
                </section>
                <div class="flex justify-center">
                    <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            type="submit"
                            class="expert-regular-btn mr-20">保存する
                    </button>
                    <button :disabled="form.processing"
                            type="button" @click="submitDraft"
                            class="expert-regular-btn mr-20">一時保存
                    </button>
                    <Link href="#" as="button" type="button" class="expert-outline-btn">戻る</Link>
                </div>
            </form>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from "@/Layouts/Experts/MyPageLayout";
import {useForm, Link} from "@inertiajs/inertia-vue3";
import RegularButton from "@/Components/Buttons/RegularButton";
import Select from "@/Components/Forms/Select";
import {ref, reactive, watch, onMounted, computed} from "vue"
import InputForm from "@/Components/Forms/Input";
import {faTimes} from "@fortawesome/free-solid-svg-icons"
import Fa from 'vue-fa';
import LabelRequired from "@/Components/Labels/LabelRequired";
import OutlineButton from "@/Components/Buttons/OutlineButton";

export default {
    name: "Input",
    components: {
        OutlineButton,
        LabelRequired,
        InputForm,
        Select,
        RegularButton,
        MyPageLayout,
        Fa,
        Link,
    },
    props: {
        profile: Object,
        skills: Object,
        activityImages: Object,
    },

    setup(props) {
        const options = reactive([
            {'id': 0, 'name': '公開'},
            {'id': 1, 'name': '非公開'},
        ])
        const form = useForm({
            status: props.profile.status ?? '',
            nickname: props.profile.nickname ?? '',
            profile_image: [],
            self_introduction: props.profile.self_introduction ?? '',
            activity_title: props.profile.activity_title ?? '',
            activity_content: props.profile.activity_content ?? [],
            activity_images: [],
            skills: props.skills.length != 0 ? props.skills : [{id: null, skill_title: '', skill_content: ''}],
            saved_profile_image: [props.profile.profile_image] ?? [],
            saved_activity_images: props.activityImages ?? [],
            delete_profile_image: [],
            delete_activity_images: [],
            delete_skills: [],
            saved_flag: props.profile.saved_flag ?? null
        })

        const NOT_EXIST = 'undefined'
        const PROFILE_PATH = '/storage/profile_images/'
        const ACTIVITY_PATH = '/storage/activity_images/'

        //自己紹介ドラッグ&ドロップ
        let isEnterSelf = ref(false)

        const dragEnterSelf = () => isEnterSelf.value = true
        const dragLeaveSelf = () => isEnterSelf.value = false

        const MAX_PROFILE_FILES = 1
        const dropSelfFile = () => {
            if(form.profile_image.length + form.saved_profile_image.length >= MAX_PROFILE_FILES) {
                return alert(`アップロードできる写真は${MAX_PROFILE_FILES}枚です。`)
            }
            isEnterSelf.value = false
            if (event.dataTransfer.files.length >= 2) {
                return
            }
            form.profile_image.push(...event.dataTransfer.files)
            form.profile_image.forEach(selfFile => selfFile['url'] = URL.createObjectURL(selfFile))
        }

        const deleteProfileFile = index => form.profile_image.splice(index, 1)


        const  deleteSavedProfileFile = index => {
            form.delete_profile_image.push(form.saved_profile_image[index])
            form.saved_profile_image.splice(index, 1)
        }

        //活動写真ドラッグ&ドロップ
        let isEnterActivity = ref(false)

        const dragEnterActivity = () => isEnterActivity.value = true
        const dragLeaveActivity = () => isEnterActivity.value = false

        const MAX_ACTIVITY_FILES = 3
        const dropActivityFile = () => {
            console.log(event.dataTransfer.files.length  + form.saved_activity_images.length)
            if(event.dataTransfer.files.length + form.saved_activity_images.length > MAX_ACTIVITY_FILES
            || form.activity_images.length + form.saved_activity_images.length >= MAX_ACTIVITY_FILES
            ) {
                return alert(`アップロードできる写真は${MAX_ACTIVITY_FILES}枚です。`)
            }
            isEnterActivity.value = false
            form.activity_images.push(...event.dataTransfer.files)
            form.activity_images.forEach(selfFile => selfFile['url'] = URL.createObjectURL(selfFile))
        }

        const deleteActivityFile = (index) => {
            form.activity_images.splice(index, 1)
        }

        const deleteSavedActivityFile = index => {
            console.log(index)
            form.delete_activity_images.push(form.saved_activity_images[index])
            form.saved_activity_images.splice(index, 1)
        }

        //提供スキルの追加・削除
        const MAX_SKILLS = 3;
        const MIN_SKILLS = 1;
        let isAddSkill = form.skills.length >= MAX_SKILLS ? ref(false) : ref(true)
        let isDeleteSkill = form.skills.length <= MIN_SKILLS ? ref(false) : ref(true)

        const addSkill = () => {
            form.skills.push({id: '', skill_title: '', skill_content: ''})
            if (form.skills.length === MAX_SKILLS) {
                isAddSkill.value = false
            }
            if (form.skills.length === MIN_SKILLS + 1) {
                isDeleteSkill.value = true
            }
        }
        const deleteSkill = () => {
            if(Number.isFinite(form.skills[form.skills.length - 1].id)) {
            form.delete_skills.push((form.skills[form.skills.length - 1]).id)
            }
            form.skills.splice(form.skills.length - 1, 1)
            if (form.skills.length === MAX_SKILLS - 1) {
                isAddSkill.value = true
            }
            if (form.skills.length === MIN_SKILLS) {
                isDeleteSkill.value = false
                return
            }

        }

        //フォーム送信
        const submit = () => {
            form.saved_flag = 1
            form.post(route('expert.profile.update'), {
                forceFormData: true,
                onSuccess: () => {
                    form.reset()
                }
            })
        }

       // 一時保存フォーム送信
        const submitDraft = () => {
            form.saved_flag = 0
            form.post(route('expert.profile.update'), {
                forceFormData: true,
                onSuccess: () => {
                    form.profile_image = []
                    form.activity_images = []
                    form.saved_profile_image =[props.profile.profile_image]
                    form.saved_activity_images = props.activityImages
                    form.delete_activity_images = []
                    alert('一時保存しました。')
                }
            })
        }

        return {
            form,
            options,
            dragEnterSelf,
            isEnterSelf,
            dragLeaveSelf,
            dropSelfFile,
            faTimes,
            deleteProfileFile,
            isEnterActivity,
            dragEnterActivity,
            dragLeaveActivity,
            dropActivityFile,
            deleteActivityFile,
            addSkill,
            deleteSkill,
            isAddSkill,
            isDeleteSkill,
            submit,
            PROFILE_PATH,
            ACTIVITY_PATH,
            NOT_EXIST,
            deleteSavedProfileFile,
            deleteSavedActivityFile,
            submitDraft,
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
