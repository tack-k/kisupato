<template>
    <full-page-layout>
        <template #content>

            <div class="flex flex-col w-10/12 mx-auto my-0 max-w-lg sm:p-16 my-12 sm:my-0">
                <ValidationErrors class="mb-4"/>
                <div class="flex justify-between items-center">
                    <h2 class="base-font-m base-font-bold">お問い合わせ</h2>
                    <Link href="#" class=" text-blue-300">よくある質問はこちら</Link>
                </div>
                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <label-required for="name" value="氏名"/>
                        <breeze-input id="name" type="text" class="mt-1 block w-full" placeholder="山田　太郎" v-model="form.name" autocomplete="name"/>
                    </div>

                    <div class="mt-4">
                        <label-required for="email" value="メールアドレス"/>
                        <breeze-input id="email" type="email" class="mt-1 block w-full" placeholder="taro.yamada@gmail.com" v-model="form.email" autocomplete="email"/>
                    </div>

                    <div class="mt-4">
                        <label-required for="email" value="電話番号"/>
                        <breeze-input id="tel" type="tel" class="mt-1 block w-full" placeholder="09012341234" v-model="form.tel" autocomplete="tel-national"/>
                    </div>

                    <div class="mt-4">
                        <label-required for="title" value="項目"/>
                        <Select name="title" id="title" class="mt-1 w-full" :options="options" v-model="form.titleId"/>
                    </div>

                    <div class="mt-4">
                        <label-required for="content" value="内容"/>
                        <TextArea id="content" class="mt-1 block w-full h-32" placeholder="内容を入力してください" v-model="form.content"/>
                    </div>

                    <div class="flex items-center justify-center mt-4">
                        <OutlineButton>戻る</OutlineButton>

                        <RegularButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">内容を確認</RegularButton>
                    </div>
                </form>
            </div>
        </template>
    </full-page-layout>
</template>

<script>
import FullPageLayout from "@/Layouts/Users/FullPageLayout";
import RegularButton from "@/Components/Buttons/RegularButton";
import LabelRequired from "@/Components/Labels/LabelRequired";
import BreezeInput from '@/Components/Forms/Input';
import ValidationErrors from '@/Components/Validations/ValidationErrors'
import { useForm } from "@inertiajs/inertia-vue3";
import Select from "@/Components/Forms/Select";
import TextArea from "@/Components/Forms/TextArea";
import { Link } from "@inertiajs/inertia-vue3"
import OutlineButton from "@/Components/Buttons/OutlineButton";


export default {
    name: "Create",
    components: {
        OutlineButton,
        FullPageLayout,
        RegularButton,
        LabelRequired,
        BreezeInput,
        ValidationErrors,
        Select,
        TextArea,
        Link,
    },
    setup() {

        const options = [{ 'id': 1, 'name': 'aaa' }, { 'id': 2, 'name': 'iii' }];

        const form = useForm({
            name: '',
            email: '',
            tel: '',
            titleId: '',
            content: '',
        })

        return {
            form,
            options,
        }
    }
}
</script>

<style scoped>

</style>
