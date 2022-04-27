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
                                <div class="flex flex-col">
                                    <Radio :options="mailMagazineTagOptions" v-model="form.target"/>
                                    <div v-if="isShowSelectButton" class="flex mt-4">
                                        <regular-button :type="'button'" @click="onClickTagModal">タグから選択</regular-button>
                                        <regular-button :type="'button'" @click="onClickPositionModal" class="ml-4">肩書から選択</regular-button>
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
import { commonConst, mailMagazineStatusOptions, mailMagazineTagOptions } from '@/Consts/commonConst'
import DoubleButton from '@/Layouts/Common/DoubleButton'
import Radio from '@/Components/Forms/Radio'
import MailMagazineTagModal from '@/Layouts/Admins/MailMagazineTagModal'
import MailMagazinePositionModal from '@/Layouts/Admins/MailMagazinePositionModal'

export default {
    name: "Create",
    components: {
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
        const { TARGET_SELECT, RESERVED } = commonConst;

        //投稿予約の初期値のため、現在日時を取得
        const date = new Date();
        date.setMinutes(date.getMinutes() - date.getTimezoneOffset());
        const currentDateTime = date.toISOString().slice(0, -8)

        const form = useForm({
            id: null,
            target: null,
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

        watch(() => form.target, () => {
            if (form.target === TARGET_SELECT) {
                isShowSelectButton.value = true
            } else {
                isShowSelectButton.value = false
                form.checked_tags = []
                form.checked_positions = []
            }
        })


        return {
            form,
            options,
            currentDateTime,
            isShowReserveForm,
            submit,
            mailMagazineTagOptions,
            onClickTagModal,
            showModalTag,
            handleShowTagModal,
            handleShowPositionModal,
            onClickPositionModal,
            showModalPosition,
            isShowSelectButton,
        }
    },
}
</script>

<style scoped>

</style>
