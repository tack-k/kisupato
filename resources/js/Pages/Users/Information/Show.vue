<template>
    <full-page-layout>
        <template #content>
            <div class="w-11/12 mx-auto py-24 md:max-w-4xl">
                <h2 class="base-font-m text-center">{{ informationSite.title }}</h2>
                <p class="my-12">{{ informationSite.description }}</p>
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
import { Link } from '@inertiajs/inertia-vue3'

export default {
    name: "Show",
    components: {
        FullPageLayout,
        Link
    },
    props: {
        informationSite: Object,
    },
    setup(props) {

        const { informationSite } = toRefs(props)

        return {
            informationSite,
        }
    }
}
</script>

<style scoped>

</style>
