<template>
    <my-page-layout>
        <template #content>
            <h2 class="mb-8 base-font-m base-font-bold">お気に入り一覧</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-12">
                <template v-for="(profile, key) in profiles" :key="key">
                    <VerticalCardNoFavoriteButton :profile="profile" @emitDeleteFavorite="handleDeleteFavorite"/>
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
        const handleDeleteFavorite = (favoriteId) => {
            profiles.value = profiles.value.some((profile, index) => {
                if (profile.favorite_id === favoriteId) {
                    profiles.value.splice(index, 1)
                }
            })
        }

        return {
            profiles,
            handleDeleteFavorite,
        }
    }
}
</script>

<style scoped>

</style>
