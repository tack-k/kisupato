<template>
    <button v-if="user" class="block" :disabled="isDisabled" @click="switchFavorite(expertId)">
        <Fa :icon="faHeart" class="text-lg absolute right-2 top-2" :class="{'text-red-400': isFavorite}"/>
    </button>
</template>

<script>
import Fa from 'vue-fa';
import { faHeart } from "@fortawesome/free-solid-svg-icons"
import { useFavoriteAction } from "@/Composables/useFavoriteAction";
import { toRefs, computed } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

export default {
    name: "FavoriteButton",
    props: {
        expertId: Number,
        favoriteId: Number,
    },
    components: {
        Fa,
    },
    setup(props) {
        const { expertId, favoriteId } = toRefs(props);
        const user = computed(() => usePage().props.value.auth.user)

        //お気に入り登録・解除
        const { isFavorite, isDisabled, switchFavorite } = useFavoriteAction(favoriteId.value);

        return {
            faHeart,
            isFavorite,
            isDisabled,
            switchFavorite,
            expertId,
            user,
        }
    }
}
</script>

<style scoped>

</style>
