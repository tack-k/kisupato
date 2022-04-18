<template>
    <main-layout>
        <template #content>
            <div class="container mx-auto pt-4 py-16 admin-bg-white">
                <div class="w-3/4 py-10 flex flex-col mx-auto">
                    <ValidationFlameErrors/>
                    <h2 class="base-font-m mb-10 text-center">サイトからのお知らせ作成</h2>
                    <form @submit.prevent="submit()">
                        <div class="mt-4">
                            <div class="mb-4">
                                <label-required for="title" value="タイトル"/>
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
                                            :disabled="form.processing">登録する
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
import { informationSiteStatusOptions } from '@/Consts/commonConst'
import DoubleButton from '@/Layouts/Common/DoubleButton'

export default {
    name: "Create",
    components: {
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
        informationSite: {
            default: null,
            type: Object,
        }
    },
    setup(props) {
        const { informationSite } = toRefs(props)
        const options = informationSiteStatusOptions;
        const IS_RESERVE = '2';

        //投稿予約の初期値のため、現在日時を取得
        const date = new Date();
        date.setMinutes(date.getMinutes() - date.getTimezoneOffset());
        const currentDateTime = date.toISOString().slice(0, -8)

        const form = useForm({
            id: informationSite.value?.id ?? null,
            title: informationSite.value?.title ?? null,
            description: informationSite.value?.description ?? null,
            status: informationSite.value?.status ?? null,
            reserved_at: informationSite.value?.reserved_at == null ? null : new Date(informationSite.value?.reserved_at).toISOString().slice(0, -8),
        });

        const isShowReserveForm = form.reserved_at !== null ? ref(true) : ref(false);

        watch(() => form.status, () => {
            if (form.status === IS_RESERVE) {
                isShowReserveForm.value = true
                form.reserved_at = currentDateTime
            } else {
                isShowReserveForm.value = false
                form.reserved_at = ''
            }

        })

        const submit = () => {
            form.post(route('admin.information_site.update'), {
                onSuccess: () => {
                    form.reset()
                }
            })
        }

        return {
            form,
            options,
            currentDateTime,
            isShowReserveForm,
            submit,
        }
    },
}
</script>

<style scoped>

</style>
