<template>
    <my-page-layout>
        <template #content>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">氏名（カナ）</h2>
                <p class="base-font-s">{{ user.last_name_kana }} {{ user.first_name_kana }}</p>
            </div>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">氏名</h2>
                <p class="base-font-s">{{ user.last_name }} {{ user.first_name }}</p>
            </div>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">電話番号</h2>
                <p class="base-font-s">{{ user.postal_code }}</p>
            </div>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">住所</h2>
                <p class="base-font-s">{{ user.region }}{{ user.city }}{{ user.street }}{{ user.building }}</p>
            </div>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">性別</h2>
                <p class="base-font-s">{{ user.genderName }}</p>
            </div>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">生年月日</h2>
                <p class="base-font-s">{{ user.birthday }}</p>
            </div>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">メールアドレス</h2>
                <p class="base-font-s">{{ user.email }}</p>
            </div>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">パスワード</h2>
                <p class="base-font-s">●●●●●●●●</p>
            </div>
            <div class="flex justify-center mt-4">
                <Link :href="route('account.edit')" class="expert-regular-btn mr-20">変更する</Link>
                <Link :href="route('profile.show')" class="expert-outline-btn">戻る</Link>
            </div>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Users/MyPageLayout'
import { computed } from 'vue'
import { usePage, Link } from '@inertiajs/inertia-vue3'
import { commonConst } from '@/Consts/commonConst'

export default {
    name: "Show",
    components: { MyPageLayout, Link },
    setup() {
        const user = computed(() => usePage().props.value.auth.user)
        const {
            MEN,
            WOMEN,
            OTHER_GENDER
        } = commonConst;

        switch (user.value.gender) {
            case MEN:
                user.value.genderName = '男性'
                break
            case WOMEN:
                user.value.genderName = '女性'
                break
            case OTHER_GENDER:
                user.value.genderName = 'その他'
                break
        }

        return {
            user
        }
    }
}
</script>

<style scoped>

</style>
