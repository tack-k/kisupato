<template>
    <my-page-layout>
        <template #content>
            <h2 class="mb-8 base-font-m base-font-bold">お気に入り一覧</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-12">
                <template v-for="(profile, key) in profiles" :key="key">
                    <VerticalCardNoFavoriteButton :profile="profile"/>
                </template>
            </div>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Users/MyPageLayout'
import { ref, toRefs } from 'vue'
import { useFavoriteAction } from '@/Composables/useFavoriteAction'
import VerticalCardNoFavoriteButton from '@/Components/Cards/VerticalCardNoFavoriteButton'

export default {
    name: "Index",
    components: { VerticalCardNoFavoriteButton, MyPageLayout },
    props: {
        profiles: Object,
    },
    setup(props) {
        const { profiles } = toRefs(props);


        return {
            profiles,
        }
    }
}
</script>

<style scoped>

</style>
