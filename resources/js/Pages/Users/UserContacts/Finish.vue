<template>
    <full-page-layout>
        <template #content>
            <div class="flex flex-col w-full sm:w-10/12 mx-auto max-w-lg p-4 sm:p-16 my-12 user-bg-white shadow-lg">
                <p class="mb-8">お問い合わせを受け付けました。担当者から連絡があるまでしばらくお待ちください。</p>
                <Link class="text-right text-blue-400" :href="route('home')">トップページへ戻る</Link>
            </div>
        </template>
    </full-page-layout>
</template>

<script>
import FullPageLayout from "@/Layouts/Users/FullPageLayout";
import { Link } from "@inertiajs/inertia-vue3";

export default {
    name: "Finish",
    components: {
        FullPageLayout,
        Link,
    }
}
</script>

<style scoped>

</style>
