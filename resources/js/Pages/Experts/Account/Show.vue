<template>
    <my-page-layout>
        <template #content>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">氏名（カナ）</h2>
                <p class="base-font-s">{{ expert.last_name_kana }} {{ expert.first_name_kana }}</p>
            </div>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">氏名</h2>
                <p class="base-font-s">{{ expert.last_name }} {{ expert.first_name }}</p>
            </div>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">電話番号</h2>
                <p class="base-font-s">{{ expert.postal_code }}</p>
            </div>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">住所</h2>
                <p class="base-font-s">{{ expert.region }}{{ expert.city }}{{ expert.street }}{{ expert.building }}</p>
            </div>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">性別</h2>
                <p class="base-font-s">{{ expert.genderName }}</p>
            </div>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">生年月日</h2>
                <p class="base-font-s">{{ expert.birthday }}</p>
            </div>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">メールアドレス</h2>
                <p class="base-font-s">{{ expert.email }}</p>
            </div>
            <div class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">パスワード</h2>
                <p class="base-font-s">●●●●●●●●</p>
            </div>
            <div class="flex justify-center mt-4">
                <Link :href="route('expert.account.edit')" class="expert-regular-btn mr-20">変更する</Link>
                <Link :href="route('expert.profile.show')" class="expert-outline-btn">戻る</Link>
            </div>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Experts/MyPageLayout'
import { computed } from 'vue'
import { usePage, Link } from '@inertiajs/inertia-vue3'
import { commonConst } from '@/Consts/commonConst'

export default {
    name: "Show",
    components: { MyPageLayout, Link },
    setup() {
        const expert = computed(() => usePage().props.value.auth.expert)
        const {
            MEN,
            WOMEN,
            OTHER_GENDER
        } = commonConst;

        switch (expert.value.gender) {
            case MEN:
                expert.value.genderName = '男性'
                break
            case WOMEN:
                expert.value.genderName = '女性'
                break
            case OTHER_GENDER:
                expert.value.genderName = 'その他'
                break
        }

        return {
            expert
        }
    }
}
</script>

<style scoped>

</style>
