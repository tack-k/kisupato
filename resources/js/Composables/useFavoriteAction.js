import { reactive, ref } from "vue";

export const useFavoriteAction = (favoriteId) => {

    let isFavorite = ref(favoriteId != null);
    let isDisabled = ref(false);

    const switchFavorite = (expertId) => {
        isDisabled.value = true;
        const params = reactive({
            expert_id: expertId,
        })

        axios.post(
            route('favorite.switch'),
            params
        ).then((res) => {
            isFavorite.value = !isFavorite.value
        }).catch((res) => {
            alert('エラーが発生しました。時間をおいてから再度お試しください')
        })
        isDisabled.value = false;
    }

    return {
        isFavorite,
        isDisabled,
        switchFavorite,
    }
}
