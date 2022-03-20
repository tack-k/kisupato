<template>
    <my-page-layout>
        <template #content>
            <div class="pt-8">
                <FixedMessage>未レビューの人材はいません。</FixedMessage>
            </div>
            <section v-else class="container mx-auto p-6 font-mono">
                <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full">
                            <thead>
                            <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                                <th class="px-4 py-3"></th>
                                <th class="px-4 py-3">専門人材</th>
                                <th class="px-4 py-3">依頼完了日</th>
                                <th class="px-4 py-3">レビュー可能日</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white">
                            <tr class="text-gray-700 user-hover hover:bg-gray-100" v-for="(value, index) in 10" :key="index">
                                <td class="px-4 py-3 border">
                                    <img class="object-cover w-12 h-full rounded-full" :src="COMMON_PATH + DEFAULT_PROFILE" alt="" loading="lazy"/>
                                </td>
                                <td class="px-4 py-3 text-xs font-semibold border">
                                    <p class="font-semibold text-black">タック</p>

                                </td>
                                <td class="px-4 py-3 text-sm border">2022/01/20</td>
                                <td class="px-4 py-3 text-sm border">2022/01/30</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Users/MyPageLayout'
import FixedMessage from '@/Components/Messages/FixedMessage'
import { commonConst } from '@/Consts/commonConst';

export default {
    name: "Yet",
    components: {
        MyPageLayout,
        FixedMessage
    },
    props: {},
    setup() {
        const { COMMON_PATH, DEFAULT_PROFILE } = commonConst

        return {
            DEFAULT_PROFILE,
            COMMON_PATH,
        }
    }
}
</script>

<style scoped>

</style>
