<template>
    <full-page-layout>
        <template #content>
            <div class="w-11/12 mx-auto my-8 md:max-w-4xl">
                <h2 class="base-font-l">Information</h2>
                <p class="text-xs my-12">Kisspatoからのお知らせやメンテナンス情報の一覧です</p>
                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                    <li v-for="(informationSite, key) in informationSites" :key="key" class="py-3 sm:py-4 px-1 sm:px-12 hover:text-blue-300 hover:cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <div class="w-28">{{ formatDate(informationSite.posted_at) }}</div>
                            <div class="w-full">{{ informationSite.title }}</div>
                        </div>
                    </li>
                </ul>
            </div>
        </template>
    </full-page-layout>
</template>

<script>
import FullPageLayout from '@/Layouts/Users/FullPageLayout'
import { toRefs } from 'vue'
import useCommonAction from '@/Composables/useCommonAction'

export default {
    name: "Index",
    components: { FullPageLayout },
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
