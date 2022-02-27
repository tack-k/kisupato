export const useFavoriteAction = (profiles, isFavorites) => {

    const setIsFavorites = () => {
        profiles.value.map(profile => {
            isFavorites.value[profile.expert_id] = profile.favorite_id !== null;
        })
    }

    const handleFavorite = (favorites) => {

        const expertIds = profiles.value.map(profile => {
            return profile.expert_id;
        })

        const favoriteExpertId = favorites.map(favorite => {
            return favorite.expert_id;
        })

        expertIds.map(expertId => {
            isFavorites.value[expertId] = favoriteExpertId.includes(expertId);
        })

        return isFavorites;

    }

    return {
        handleFavorite,
        setIsFavorites,
    }
}
