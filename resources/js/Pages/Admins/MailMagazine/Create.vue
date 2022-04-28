<template>
    <main-layout>
        <template #content>
            <div class="container mx-auto pt-4 py-16 admin-bg-white">
                <div class="w-3/4 py-10 flex flex-col mx-auto">
                    <ValidationFlameErrors/>
                    <h2 class="base-font-m mb-10 text-center">メルマガ配信入力</h2>
                    <form @submit.prevent="submit()">
                        <div class="mt-4">
                            <div class="mb-4">
                                <label-required for="title" value="宛先"/>
                                <div class="flex items-center">
                                    <Checkbox v-model:checked="form.send_user"/> <span class="ml-2">ユーザに送信</span>
                                    <Checkbox v-model:checked="form.send_expert" class="ml-2"/> <span class="ml-2">専門人材に送信</span>
                                </div>
                                <div v-if="isShowSendUser" class="flex flex-col mt-2 ml-4">
                                    <p class="my-2 base-font-bold">ユーザーの送信設定</p>
                                    <Radio :options="mailUserTagOptions" v-model="form.target_user" :checked="decideInitChecked" :name="'user'"/>
                                </div>
                                <div v-if="isShowSendExpert" class="flex flex-col mt-2 ml-4">
                                    <p class="my-2 base-font-bold">専門人材の送信設定</p>
                                    <Radio :options="mailExpertTagOptions" v-model="form.target_expert" :checked="decideInitChecked" :name="'expert'"/>
                                    <div v-if="isShowSelectButton" class="flex mt-4">
                                        <regular-button :type="'button'" @click="onClickTagModal">タグから選択<span>{{ tagSelectedText }}</span></regular-button>
                                        <regular-button :type="'button'" @click="onClickPositionModal" class="ml-4">肩書から選択<span>{{ positionSelectedText }}</span></regular-button>
                                    </div>
                                    <MailMagazineTagModal v-model:checked="form.checked_tags" :tags="tags" :showModal="showModalTag" @emitShowModal="handleShowTagModal"/>
                                    <MailMagazinePositionModal v-model:checked="form.checked_positions" :positions="positions" :showModal="showModalPosition" @emitShowModal="handleShowPositionModal"/>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label-required for="title" value="件名"/>
                                <Input id="title" type="text" class="mt-1 w-full max-w-6xl"
                                       v-model="form.title" autofocus/>
                            </div>
                            <div class="mb-4">
                                <label-required for="description" value="内容"/>
                                <TextArea id="description" v-model="form.description" class="w-full"/>
                            </div>
                            <div class="mb-4">
                                <label-required for="status" value="ステータス"/>
                                <Select id="status" :options="options" v-model="form.status" class="w-1/2"/>
                            </div>
                            <div v-if="isShowReserveForm" class="mb-4">
                                <label-required for="reserve" value="予約日時"/>
                                <Input id="reserve" type="datetime-local" class="mt-1 w-full max-w-6xl"
                                       v-model="form.reserved_at" autofocus/>
                            </div>
                        </div>

                        <div class="flex items-center justify-center p-6 border-t border-solid border-blueGray-200 rounded-b">
                            <div class="mr-6">
                                <Link :href="route('admin.information_site.index')" class="admin-outline-btn">戻る</Link>
                            </div>

                            <regular-button :class="{ 'opacity-25': form.processing }"
                                            :disabled="form.processing">実行する
                            </regular-button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </main-layout>
</template>

<script>
import MainLayout from "@/Layouts/Admins/MainLayout";
import { useForm, Link } from "@inertiajs/inertia-vue3";
import { ref, toRefs, watch } from "vue";
import ValidationFlameErrors from "@/Components/Validations/ValidationFlameErrors";
import OutlineButton from "@/Components/Buttons/OutlineButton";
import RegularButton from "@/Components/Buttons/RegularButton";
import LabelRequired from "@/Components/Labels/LabelRequired";
import Input from "@/Components/Forms/Input";
import TextArea from '@/Components/Forms/TextArea'
import Select from '@/Components/Forms/Select'
import { commonConst, mailMagazineStatusOptions, mailExpertTagOptions, mailUserTagOptions } from '@/Consts/commonConst'
import DoubleButton from '@/Layouts/Common/DoubleButton'
import Radio from '@/Components/Forms/Radio'
import MailMagazineTagModal from '@/Layouts/Admins/MailMagazineTagModal'
import MailMagazinePositionModal from '@/Layouts/Admins/MailMagazinePositionModal'
import Checkbox from '@/Components/Forms/Checkbox'

export default {
    name: "Create",
    components: {
        Checkbox,
        MailMagazinePositionModal,
        MailMagazineTagModal,
        Radio,
        DoubleButton,
        Select,
        TextArea,
        MainLayout,
        ValidationFlameErrors,
        OutlineButton,
        RegularButton,
        LabelRequired,
        Input,
        Link,
    },
    props: {
        tags: Array,
        positions: Array,
    },
    setup() {
        const options = mailMagazineStatusOptions;
        const { TARGET_SELECT, RESERVED, TARGET_RECEIVED } = commonConst;

        //投稿予約の初期値のため、現在日時を取得
        const date = new Date();
        date.setMinutes(date.getMinutes() - date.getTimezoneOffset());
        const currentDateTime = date.toISOString().slice(0, -8)

        const form = useForm({
            id: null,
            send_user: null,
            send_expert: null,
            target_user: null,
            target_expert: null,
            checked_tags: [],
            checked_positions: [],
            title: null,
            description: null,
            status: '',
            reserved_at: null,
        });

        const isShowReserveForm = form.reserved_at !== null ? ref(true) : ref(false);

        watch(() => form.status, () => {
            if (form.status === RESERVED) {
                isShowReserveForm.value = true
                form.reserved_at = currentDateTime
            } else {
                isShowReserveForm.value = false
                form.reserved_at = ''
            }

        })

        const submit = () => {
            form.post(route('admin.mail_magazine.update'), {
                onSuccess: () => {
                    form.reset()
                }
            })
        }

        const showModalTag = ref(false)
        const onClickTagModal = () => showModalTag.value = true

        const handleShowTagModal = (data) => {
            showModalTag.value = data
        }

        const showModalPosition = ref(false)

        const handleShowPositionModal = (data) => {
            showModalPosition.value = data
        }

        const onClickPositionModal = () => showModalPosition.value = true

        const isShowSelectButton = ref(false);
        const resetExpertCheckedForm = () => {
            form.checked_tags = []
            form.checked_positions = []
        }

        watch(() => form.target_expert, () => {
            if (form.target_expert === TARGET_SELECT) {
                isShowSelectButton.value = true
            } else {
                isShowSelectButton.value = false
                resetExpertCheckedForm()
            }
        })

        const tagSelectedText = ref('【未選択】')
        watch(() => form.checked_tags, () => {
            tagSelectedText.value = form.checked_tags.length === 0 ? '【未選択】' : '【選択中】';
        })

        const positionSelectedText = ref('【未選択】')
        watch(() => form.checked_positions, () => {
            positionSelectedText.value = form.checked_positions.length === 0 ? '【未選択】' : '【選択中】';
        })

        const decideInitChecked = value => value === TARGET_RECEIVED;

        const isShowSendUser = ref(false)

        watch(() => form.send_user, () => {
            isShowSendUser.value = form.send_user
            if(form.send_user) {
                form.target_user = TARGET_RECEIVED
            }
            if(!form.send_user) {
                form.target_user = null
            }
        })

        const isShowSendExpert = ref(false)

        watch(() => form.send_expert, () => {
            isShowSendExpert.value = form.send_expert
            if(form.send_expert) {
                form.target_expert = TARGET_RECEIVED
            }
            if(!form.send_expert) {
                form.target_expert = null
                resetExpertCheckedForm()
            }
        })



        return {
            form,
            options,
            currentDateTime,
            isShowReserveForm,
            submit,
            mailExpertTagOptions,
            onClickTagModal,
            showModalTag,
            handleShowTagModal,
            handleShowPositionModal,
            onClickPositionModal,
            showModalPosition,
            isShowSelectButton,
            tagSelectedText,
            positionSelectedText,
            decideInitChecked,
            isShowSendUser,
            isShowSendExpert,
            mailUserTagOptions,
        }
    },
}
</script>

<style scoped>

</style>
