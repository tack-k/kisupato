<template>
    <my-page-layout>
        <template #content>
            <section class="mb-10">
                <LabelRequired class="label" value="ステータス" for="status"/>
                <Select :options="options" id="status"/>
            </section>

            <section class="mb-10">
                <LabelRequired class="label" value="ニックネーム" for="nickname"/>
                <Input id="nickname" type="text"/>
            </section>

            <section class="mb-10">
                <LabelRequired class="label" value="プロフィール画像"/>
                <div class="flex flex-col items-center md:flex-row">
                    <div @dragenter="dragEnterSelf" @dragleave="dragLeaveSelf" @dragover.prevent @drop.prevent="dropSelfFile"
                         :class="{enter: isEnterSelf}"
                         class="border-dashed border-4 border-light-blue-500 h-40 flex items-center justify-center w-full md:w-1/2">
                        ファイルアップロード
                    </div>
                    <ul class="h-40 w-40 mt-10 md:ml-10 md:mt-0">
                        <li v-for="(file, index) in selfFiles" :key="index">
                            <div class="relative">
                                <img :src="file.url" class="h-40 w-40 rounded-full object-cover" alt="">
                                <Fa :icon="faTimes" @click="deleteSelfFile" class="absolute expert-hover top-2 right-2"/>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>

            <section class="mb-10">
                <LabelRequired class="label" value="自己紹介" for="self_introduction"/>
                <textarea class="base-form w-full" rows="2" v-model="form.self_introduction"></textarea>
            </section>

            <section class="mb-10">
                <LabelRequired class="label" value="活動タイトル" for="activity_title"/>
                <textarea class="base-form w-full" rows="2" v-model="form.activity_title"></textarea>

            </section>

            <section class="mb-10">
                <LabelRequired class="label" value="活動写真" for="activity_title"/>
                <div @dragenter="dragEnterActivity" @dragleave="dragLeaveActivity" @dragover.prevent @drop.prevent="dropActivityFile"
                     :class="{enter: isEnterActivity}"
                     class="border-dashed border-4 border-light-blue-500 h-40 flex items-center justify-center w-full md:w-1/2">
                    ファイルアップロード
                </div>
                <div class="w-full flex">
                    <!-- main -->
                    <main class="w-full">
                        <div class="grid grid-cols-4 gap-4">
                            <div v-for="(activityFile, index) in activityFiles" :key="index"
                                 class="col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-1 xl:col-span-1 flex flex-col items-center">
                                <div class="bg-white rounded-lg mt-5 relative">
                                    <img :src="activityFile.url" class="rounded-md h-40 object-cover" alt="">
                                    <Fa :icon="faTimes" @click="deleteActivityFile" class="absolute expert-hover top-2 right-2"/>
                                </div>
                            </div>
                            <!-- end cols -->
                        </div>
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
                    <button @click="addSkill" v-show="isAddSkill" class="expert-regular-btn">追加</button>
                    <button @click="deleteSkill" v-show="isDeleteSkill" class="expert-outline-btn">削除</button>
                </div>

            </section>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from "@/Layouts/Experts/MyPageLayout";
import {useForm} from "@inertiajs/inertia-vue3";
import RegularButton from "@/Components/Buttons/RegularButton";
import Select from "@/Components/Forms/Select";
import {ref, reactive} from "vue"
import Input from "@/Components/Forms/Input";
import { faTimes } from "@fortawesome/free-solid-svg-icons"
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
    },

    setup() {
        const options = reactive([
            {'id': 0, 'name': '公開'},
            {'id': 0, 'name': '非公開'},
        ])

        const form = useForm({
            status: '',
            nickname: '',
            image: '',
            self_introduction: '',
            activity_title: '',
            activity_image: [],
            activity_content: [],
            skills: [{skill_title: '', skill_content: ''}],
            skill_title: '',
            skill_content: '',
        })

        //自己紹介ドラッグ&ドロップ
        let isEnterSelf = ref(false)

        const dragEnterSelf = () => isEnterSelf.value = true
        const dragLeaveSelf = () => isEnterSelf.value = false

        let selfFiles = ref([])

        const dropSelfFile = () => {
            isEnterSelf.value = false
            if(event.dataTransfer.files.length >= 2) {
                return
            }
            selfFiles.value = [...event.dataTransfer.files]
            selfFiles.value.forEach(selfFile => selfFile['url'] = URL.createObjectURL(selfFile))
        }

        const deleteSelfFile = (index) => {
            selfFiles.value.splice(index, 1)
        }

        //活動写真ドラッグ&ドロップ
        let isEnterActivity = ref(false)

        const dragEnterActivity = () => isEnterActivity.value = true
        const dragLeaveActivity = () => isEnterActivity.value = false

        let activityFiles = ref([])

        const dropActivityFile = () => {
            isEnterActivity.value = false
            activityFiles.value.push(...event.dataTransfer.files)
            activityFiles.value.forEach(selfFile => selfFile['url'] = URL.createObjectURL(selfFile))
        }

        const deleteActivityFile = (index) => {
            activityFiles.value.splice(index, 1)
        }

        //提供スキルの追加・削除
        let isAddSkill = ref(true)
        let isDeleteSkill = ref(false)
        const MAX_SKILLS = 3;
        const MIN_SKILLS = 1;

        const addSkill = () => {
            form.skills.push({skill_title: '', skill_content: ''})
            if(form.skills.length === MAX_SKILLS) {
                isAddSkill.value = false
            }
            if(form.skills.length === MIN_SKILLS + 1) {
                isDeleteSkill.value = true
            }
        }

        const deleteSkill = (index) => {
            form.skills.splice(index, 1)
            if(form.skills.length === MAX_SKILLS - 1) {
                isAddSkill.value = true
            }
            if(form.skills.length === MIN_SKILLS) {
                isDeleteSkill.value = false
                return
            }

        }


        return {
            form,
            options,
            dragEnterSelf,
            isEnterSelf,
            dragLeaveSelf,
            dropSelfFile,
            selfFiles,
            faTimes,
            deleteSelfFile,
            isEnterActivity,
            dragEnterActivity,
            dragLeaveActivity,
            dropActivityFile,
            activityFiles,
            deleteActivityFile,
            addSkill,
            deleteSkill,
            isAddSkill,
            isDeleteSkill,
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
