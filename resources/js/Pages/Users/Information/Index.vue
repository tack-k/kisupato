<template>
    <full-page-layout>
        <template #content>
            <div class="w-11/12 mx-auto py-24 md:max-w-4xl">
                <h2 class="base-font-l">Information</h2>
                <p class="text-xs my-12">Kisspatoからのお知らせやメンテナンス情報の一覧です</p>
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    <li v-for="(informationSite, key) in informationSites" :key="key" class="py-3 sm:py-4 px-1 sm:px-12 hover:text-blue-300 hover:cursor-pointer">
                        <Link :href="route('information.show', {information_site_id: informationSite.id})" class="flex flex-col sm:flex-row">
                            <div class="w-48">{{ formatDate(informationSite.posted_at) }}</div>
                            <div class="w-full">{{ informationSite.title }}</div>
                        </Link>
                    </li>
                </ul>
                <div class="pt-6 w-full text-right">
                    <Link :href="route('home')" class="text-sm hover:text-blue-300 hover:cursor-pointer">トップページへ戻る</Link>
                </div>
            </div>
        </template>
    </full-page-layout>
</template>

<script>
import FullPageLayout from '@/Layouts/Users/FullPageLayout'
import { toRefs } from 'vue'
import useCommonAction from '@/Composables/useCommonAction'
import { Link } from '@inertiajs/inertia-vue3'

export default {
    name: "Index",
    components: {
        FullPageLayout,
        Link
    },
    props: {
        informationSites: Object,
    },
    setup(props) {
        const { informationSites } = toRefs(props)

        const { formatDate } = useCommonAction()

        return {
            informationSites,
            formatDate,
        }
    }
}
</script>

<style scoped>

</style>
