<template>
    <main-layout>
        <template #content>
            <div class="container mx-auto pt-4 py-16 admin-bg-white">
                <div class="w-3/4 py-10 flex flex-col mx-auto">
                    <h2 class="base-font-m mb-10 text-center">サイトからのお知らせ確認</h2>
                    <div class="mt-4">
                        <div class="mb-4">
                            <label-required for="title" value="タイトル"/>
                            <p>{{ informationSite.title }}</p>
                        </div>
                        <div class="mb-4">
                            <label-required for="description" value="内容"/>
                            <p>{{ informationSite.description }}</p>
                        </div>
                        <div class="mb-4">
                            <label-required for="status" value="ステータス"/>
                            <p>{{ informationSite.status_name }}</p>
                        </div>
                        <div v-if="isShowReserveForm" class="mb-4">
                            <label-required for="reserve" value="予約日時"/>
                            <p>{{ formatDateTime(informationSite.reserved_at) }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-center p-6 border-t border-solid border-blueGray-200 rounded-b">
                        <div class="mr-6">
                            <Link :href="url" class="admin-outline-btn">戻る</Link>
                        </div>
                        <regular-button @click="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">登録する</regular-button>
                    </div>
                </div>
            </div>
        </template>
    </main-layout>
</template>

<script>
import MainLayout from "@/Layouts/Admins/MainLayout";
import { useForm, Link } from "@inertiajs/inertia-vue3";
import { ref, toRefs } from "vue";
import ValidationFlameErrors from "@/Components/Validations/ValidationFlameErrors";
import OutlineButton from "@/Components/Buttons/OutlineButton";
import RegularButton from "@/Components/Buttons/RegularButton";
import LabelRequired from "@/Components/Labels/LabelRequired";
import Input from "@/Components/Forms/Input";
import TextArea from '@/Components/Forms/TextArea'
import Select from '@/Components/Forms/Select'
import DoubleButton from '@/Layouts/Common/DoubleButton'
import useCommonAction from '@/Composables/useCommonAction'

export default {
    name: "Confirm",
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
        informationSite: Object,
        link: String,
    },
    setup(props) {
        const { informationSite, link } = toRefs(props)

        const form = useForm({
            id: informationSite.value?.id ?? null,
            title: informationSite.value.title,
            description: informationSite.value.description,
            status: informationSite.value.status,
            reserved_at: informationSite.value?.reserved_at == null ? null : new Date(informationSite.value?.reserved_at).toISOString().slice(0, -8),
        })

        const url = link.value === 'create' ? route('admin.information_site.create') : route('admin.information_site.edit', { id: informationSite.value.id });
        const isShowReserveForm = informationSite.value.reserved_at !== null ? ref(true) : ref(false);

        const submit = () => {
            form.post(route('admin.information_site.finish'), {
                onSuccess: () => {
                    form.reset()
                }
            })
        }

        const { formatDateTime } = useCommonAction();

        return {
            informationSite,
            url,
            isShowReserveForm,
            formatDateTime,
            form,
            submit,
        }
    }
}
</script>

<style scoped>

</style>
