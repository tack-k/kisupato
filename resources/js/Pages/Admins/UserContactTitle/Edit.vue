<template>
    <main-layout>
        <template #content>
            <div class="container mx-auto pt-4 py-16 admin-bg-white">
                <div class="w-3/4 py-10 flex flex-col items-center mx-auto">
                    <ValidationFlameErrors/>
                    <h2 class="base-font-m mb-10">ユーザー問い合わせ項目編集</h2>
                    <form @submit.prevent="submit()">
                        <div class="mt-4 mb-20">
                            <div class="mr-2">
                                <label-required for="name" value="ユーザー問い合わせ項目名"/>
                                <Input id="name" type="text" class="mt-1 w-full max-w-6xl"
                                       v-model="form.name" autofocus/>
                            </div>
                        </div>

                        <div class="flex items-center justify-center p-6 border-t border-solid border-blueGray-200 rounded-b">
                            <div class="mr-6">
                                <Link :href="route('admin.userContactTitle.index')" class="admin-outline-btn">戻る</Link>
                            </div>
                            <regular-button :class="{ 'opacity-25': form.processing }"
                                            :disabled="form.processing">変更する
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
import {useForm, Link} from "@inertiajs/inertia-vue3";
import {ref, reactive} from "vue";
import ValidationFlameErrors from "@/Components/Validations/ValidationFlameErrors";
import OutlineButton from "@/Components/Buttons/OutlineButton";
import RegularButton from "@/Components/Buttons/RegularButton";
import LabelRequired from "@/Components/Labels/LabelRequired";
import Input from "@/Components/Forms/Input";


export default {
    name: "Edit",
    components: {
        MainLayout,
        ValidationFlameErrors,
        OutlineButton,
        RegularButton,
        LabelRequired,
        Input,
        Link,
    },
    props: {
        userContactTitle: Object,
    },

    setup(props) {
        const form = useForm({
            name: props.userContactTitle.name,
        })

        const userContactTitle = props.userContactTitle

        const submit = () => {
            form.put(route('admin.userContactTitle.update', {'id': userContactTitle.id}), {
                onSuccess: () => {
                    form.reset()
                }
            })

        }

        return {
            form,
            submit,
        }
    }
}
</script>

<style scoped>

</style>
