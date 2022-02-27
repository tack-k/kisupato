<template>
    <button v-if="user" class="block" :disabled="isDisabled" @click="switchFavorite(expertId)">
        <Fa :icon="faHeart" class="text-lg absolute right-2 top-2" :class="{'text-red-400': isFavorite}"/>
    </button>
</template>

<script>
import Fa from 'vue-fa';
import { faHeart } from "@fortawesome/free-solid-svg-icons"
import { useFavoriteAction } from "@/Composables/useFavoriteAction";
import { toRefs, computed, watch, ref, reactive } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

export default {
    name: "FavoriteButton",
    props: {
        expertId: Number,
        isFavorite: Boolean,
    },
    components: {
        Fa,
    },
    setup(props, {emit}) {
        const { expertId, isFavorite } = toRefs(props);
        const user = computed(() => usePage().props.value.auth.user)

        let isDisabled = ref(false);
        let allFavoriteData = ref(null);

        const switchFavorite = (expertId) => {
            isDisabled.value = true;
            const params = reactive({
                expert_id: expertId,
            })

            axios.post(
                route('favorite.switch'),
                params
            ).then((res) => {
                allFavoriteData.value = res.data
            }).catch((res) => {
                alert('エラーが発生しました。時間をおいてから再度お試しください')
            })
            isDisabled.value = false;
        }


        watch(allFavoriteData, () => {
            emit('emitFavorite', allFavoriteData.value)
        })

        return {
            faHeart,
            isFavorite,
            isDisabled,
            switchFavorite,
            expertId,
            user,
            allFavoriteData,

        }
    }
}
</script>

<style scoped>

</style>
