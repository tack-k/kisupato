<template>
    <my-page-layout>
        <template #content>
            <h2 class="mb-8 pt-8 base-font-m base-font-bold">お気に入り一覧</h2>
            <FixedMessage v-if="messages.length > 0" :messages="messages"/>
            <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
                <template v-for="(profile, key) in profiles" :key="key">
                    <VerticalCardNoFavoriteButton :profile="profile" @emitDeleteFavorite="handleDeleteFavorite"/>
                </template>
            </div>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Users/MyPageLayout'
import { ref, toRefs, watch } from 'vue'
import VerticalCardNoFavoriteButton from '@/Components/Cards/VerticalCardNoFavoriteButton'
import FixedMessage from '@/Components/Messages/FixedMessage'

export default {
    name: "Index",
    components: { FixedMessage, VerticalCardNoFavoriteButton, MyPageLayout },
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

        const messages = ref([]);
        const checkProfileCount = () => {
            if (profiles.value.length === 0) {
                messages.value.push('お気に入りの登録がありません');
            }
        }
        checkProfileCount()

        watch(profiles.value, () => {
            checkProfileCount()
        })

        return {
            profiles,
            handleDeleteFavorite,
            messages,
        }
    }
}
</script>

<style scoped>

</style>
