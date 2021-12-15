<template>
    <my-page-layout>
        <template #content>
            <form @submit.prevent="submit">
                <section class="mb-10">
                    <LabelRequired class="label" value="ニックネーム" for="nickname"/>
                    <InputForm id="nickname" type="text" v-model="form.nickname"/>
                </section>

              <section>
                <LabelRequired class="label" value="タグ" for="tag"/>
                <div class="flex">
                 <div class="">
                  <input class="rounded-full border-0 hover:bg-gray-100 focus:ring-0 py-4 hover:cursor-pointer" type="text"
                         @click="toggleTagsOpen" v-model="form.tag" placeholder="タグから探す">
                  </div>
                  <ul v-if="displayTags.value.length >= 1" class="flex items-center">
                    <li class="rounded-lg px-4 py-2 user-bg ml-6 user-text-white base-font-bold relative" v-for="(tag, index) in displayTags.value" :key="index">{{ tag }}
                      <span class="absolute -top-1 -right-1 hover:cursor-pointer text-gray-400">✕</span>
                    </li>
                  </ul>
                </div>
                <ul v-if="isTagsOpen" @click.self="closeTags"
                    class="border rounded shadow-lg user-bg-white overflow-y-scroll absolute fixed z-50 w-full">
                  <li v-for="(tag, index) in searchTags.value" :key="tag" @click="getSelectedTag(index)"
                      class="px-2 py-0.5 hover:bg-blue-500 hover:text-white hover:cursor-pointer">{{
                      tag
                    }}
                  </li>
                </ul>
              </section>

                <section class="mb-10">
                    <LabelRequired class="label" value="プロフィール画像"/>
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
                    <label>
                        <div class="flex items-center mb-1.5">
                            <LabelRequired class="label" value="活動写真" for="activity_image"/>
                            <div class="expert-regular-btn inline-block expert-hover">アップロード</div>
                        </div>
                        <div @dragenter="dragEnterActivity" @dragleave="dragLeaveActivity" @dragover.prevent
                             @drop.prevent="dropActivityFile"
                             :class="{enter: isEnterActivity}"
                             class="border-dashed border-4 border-light-blue-500 h-40 flex items-center justify-center w-full md:w-1/2 hidden lg:flex">
                            ファイルアップロード
                        </div>
                        <input type="file" class="hidden" @change="uploadActivityImage">
                    </label>
                    <div class="w-full flex">
                        <!-- main -->
                        <main class="w-full">
                            <ul class="grid grid-cols-4 gap-4">
                                <li v-for="(saved_activity_image, index) in form.saved_activity_images" :key="index"
                                    class="col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-1 xl:col-span-1 flex flex-col items-center">
                                    <div class="bg-white rounded-lg mt-5 relative">
                                        <img :src="displayedActivityPath + saved_activity_image.activity_image"
                                             class="rounded-md h-40 object-cover" alt="">
                                        <Fa :icon="faTimes" @click="deleteSavedActivityFile(index)"
                                            class="absolute expert-hover -top-2 -right-2"/>
                                    </div>
                                </li>
                                <li v-for="(activity_image, index) in form.activity_images" :key="index"
                                    class="col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-1 xl:col-span-1 flex flex-col items-center">
                                    <div class="bg-white rounded-lg mt-5 relative">
                                        <img :src="activity_image.url" class="rounded-md h-40 object-cover" alt="">
                                        <Fa :icon="faTimes" @click="deleteActivityFile(index)"
                                            class="absolute expert-hover -top-2 -right-2"/>
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
                        <button @click="addSkill" v-show="isAddSkill" class="expert-regular-btn mr-4" type="button">追加
                        </button>
                        <button @click="deleteSkill" v-show="isDeleteSkill" class="expert-outline-btn" type="button">
                            削除
                        </button>
                    </div>
                </section>
                <div class="flex justify-center">
                    <button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            type="submit"
                            class="expert-regular-btn mr-20">保存する
                    </button>
                    <Link :href="route('expert.profile.show')" as="button" type="button" class="expert-outline-btn">戻る
                    </Link>
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
import useTagAction from "@/Composables/useTagAction";

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
        tags: Object,
        positions: Object,
    },

    setup(props) {
        const options = reactive([
            {'id': 0, 'name': '公開'},
            {'id': 1, 'name': '非公開'},
        ])

        const form = useForm({
            nickname: props.profile.nickname ?? '',
            profile_image: [],
            self_introduction: props.profile.self_introduction ?? '',
            activity_title: props.profile.activity_title ?? '',
            activity_content: props.profile.activity_content ?? [],
            activity_images: [],
            skills: props.skills.length != 0 ? props.skills : [{id: null, skill_title: '', skill_content: ''}],
            saved_profile_image: props.profile.profile_image.length === 0 ? [] : [props.profile.profile_image],
            saved_activity_images: props.activityImages ?? [],
            delete_profile_image: [],
            delete_activity_images: [],
            delete_skills: [],
            saved_flag: props.profile.saved_flag ?? null,
            tag: [],
        })

        const NOT_EXIST = 'undefined'
        const PROFILE_PATH = '/storage/profile_images/'
        const ACTIVITY_PATH = '/storage/activity_images/'
        const DRAFT_PROFILE_PATH = '/storage/draft_profile_images/'
        const DRAFT_ACTIVITY_PATH = '/storage/draft_activity_images/'
        const NOT_SAVED = '0'
        const SAVED = '1'

        let displayedProfilePath = props.saved === SAVED ? DRAFT_PROFILE_PATH : PROFILE_PATH
        let displayedActivityPath = props.saved === SAVED ? DRAFT_ACTIVITY_PATH : ACTIVITY_PATH


        //プロフィール画像ドラッグ&ドロップ
        let isEnterProfile = ref(false)

        const dragEnterProfile = () => isEnterProfile.value = true
        const dragLeaveProfile = () => isEnterProfile.value = false

        const MAX_PROFILE_FILES = 1
        const dropProfileFile = () => {

            isEnterProfile.value = false
            if (event.dataTransfer.files.length >= 2) {
                return alert(`アップロードできる写真は${MAX_PROFILE_FILES}枚です。`)
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
            if (form.saved_profile_image !== null) {
                form.delete_profile_image = form.saved_profile_image
                form.saved_profile_image = []
            }
            form.profile_image.forEach(profileFile => profileFile['url'] = URL.createObjectURL(profileFile))
        }

        //活動写真ドラッグ&ドロップ
        let isEnterActivity = ref(false)

        const dragEnterActivity = () => isEnterActivity.value = true
        const dragLeaveActivity = () => isEnterActivity.value = false

        const MAX_ACTIVITY_FILES = 3
        const dropActivityFile = () => {
            if (event.dataTransfer.files.length + form.saved_activity_images.length + form.activity_images.length > MAX_ACTIVITY_FILES
                || form.activity_images.length + form.saved_activity_images.length >= MAX_ACTIVITY_FILES
            ) {
                return alert(`アップロードできる写真は${MAX_ACTIVITY_FILES}枚です。`)
            }
            isEnterActivity.value = false
            form.activity_images.push(...event.dataTransfer.files)
            form.activity_images.forEach(activityFile => activityFile['url'] = URL.createObjectURL(activityFile))
        }

        const deleteActivityFile = (index) => {
            form.activity_images.splice(index, 1)
        }

        const deleteSavedActivityFile = index => {
            form.delete_activity_images.push(form.saved_activity_images[index])
            form.saved_activity_images.splice(index, 1)
        }

        //活動写真アップロード
        const uploadActivityImage = event => {
            if (event.target.files.length + form.saved_activity_images.length + form.activity_images.length > MAX_ACTIVITY_FILES
                || form.activity_images.length + form.saved_activity_images.length >= MAX_ACTIVITY_FILES
            ) {
                return alert(`アップロードできる写真は${MAX_ACTIVITY_FILES}枚です。`)
            }
            form.activity_images.push(...event.target.files)
            form.activity_images.forEach(activityFile => activityFile['url'] = URL.createObjectURL(activityFile))
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
            if (Number.isFinite(form.skills[form.skills.length - 1].id)) {
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

        //タグの表示
        const { isTagsOpen, toggleTagsOpen, closeTags, searchTags, getSelectedTag, isNoTag, displayTags } = useTagAction(props.tags, form)

        return {
            form,
            options,
            dragEnterProfile,
            isEnterProfile,
            dragLeaveProfile,
            dropProfileFile,
            faTimes,
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
            deleteSavedActivityFile,
            displayedProfilePath,
            displayedActivityPath,
            uploadProfileImage,
            uploadActivityImage,
            isTagsOpen,
            toggleTagsOpen,
            closeTags,
            searchTags,
            getSelectedTag,
            isNoTag,
            displayTags
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
