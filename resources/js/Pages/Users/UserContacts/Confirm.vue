<template>
    <full-page-layout>
        <template #content>

            <div class="flex flex-col w-full sm:w-10/12 mx-auto max-w-lg p-4 sm:p-16 my-12 user-bg-white shadow-lg">
                <ValidationErrors class="mb-4"/>
                <h2 class="base-font-m base-font-bold">お問い合わせ</h2>
                <form @submit.prevent="submit">
                    <div class="mt-4">
                        <h3 class="contact-title">氏名</h3>
                        <p>{{ params.name }}</p>
                    </div>

                    <div class="mt-4">
                        <h3 class="contact-title">メールアドレス</h3>
                        <p>{{ params.email }}</p>
                    </div>

                    <div class="mt-4">
                        <h3 class="contact-title">電話番号</h3>
                        <p>{{ params.tel }}</p>
                    </div>

                    <div class="mt-4">
                        <h3 class="contact-title">項目</h3>
                        <p>{{ params.user_contact_title_name }}</p>
                    </div>

                    <div class="mt-4">
                        <h3 class="contact-title">内容</h3>
                        <p>{{ params.content }}</p>
                    </div>

                    <div class="flex items-center justify-center mt-4">
                        <Link :href="route('contact.create')">
                            <OutlineButton>戻る</OutlineButton>
                        </Link>

                        <RegularButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            送信する
                        </RegularButton>
                    </div>
                </form>
            </div>
        </template>
    </full-page-layout>
</template>
<script>
import FullPageLayout from "@/Layouts/Users/FullPageLayout";
import RegularButton from "@/Components/Buttons/RegularButton";
import ValidationErrors from '@/Components/Validations/ValidationErrors'
import OutlineButton from "@/Components/Buttons/OutlineButton";
import { Link } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
import { toRefs } from "vue";

export default {
    name: "Confirm",
    components: {
        FullPageLayout,
        RegularButton,
        ValidationErrors,
        OutlineButton,
        Link,

    },
    props: {
        params: Object,
    },
    setup(props) {
        const { params } = toRefs(props);
        const form = useForm({
            name: params.value.name,
            email: params.value.email,
            tel: params.value.tel,
            user_contact_title_id: params.value.user_contact_title_id,
            content: params.value.content,
        })

        const submit = () => {
            form.post(route('contact.finish'))
        }

        return {
            form,
            params,
            submit,
        }
    }
}
</script>

<style scoped lang="scss">
.contact-title {
    @apply font-medium
}

</style>
