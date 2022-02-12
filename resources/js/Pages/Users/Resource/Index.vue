<template>
    <full-page-map-layout>
        <template #content>
            <div >
                <div class="flex">
                    <div class="p-3 w-1/2 h-screen absolute top-16 z-0">
                        <template v-for="(profile, index) in profiles" :key="index" class="overflow-y-auto">
                            <SideCard :profile="profile" class="mb-2"/>
                        </template>
                    </div>

                    <div class="w-1/2 fixed top-16 right-0 h-screen">
                        <GoogleMap
                            ref="mapRef"
                            :api-key="GOOGLE_MAP_API_KEY"
                            style="width: 100%; height: 100%"
                            :center="center"
                            :zoom="DEFAULT_ZOOM"
                        >
                            <Marker :options="markerOption.map" v-for="(markerOption, index) in markerOptions" :key="index" @click="showProfileCard(markerOption.card)"/>
                        </GoogleMap>
                        <div v-show="isCardOpen">
                            <div class="card-wrapper">
                                <VerticalCard :profile="profileCard"/>
                            </div>
                        </div>
                        <div v-if="isCardOpen" @click="onClickCardOutside" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
                    </div>
                </div>
            </div>
        </template>
    </full-page-map-layout>
</template>

<script>
import Header from "@/Layouts/Users/Header"

import {GoogleMap, Marker, IControlPosition} from 'vue3-google-map'
import {ref, computed} from "vue";
import {commonConst} from "@/Consts/commonConst"
import VerticalCard from "@/Components/Cards/VerticalCard";
import SideCard from "@/Components/Cards/SideCard";
import FullPageMapLayout from "@/Layouts/Users/FullPageMapLayout";


export default {
    name: "Index",
    components: {
        FullPageMapLayout,
        SideCard,
        VerticalCard,
        Header,
        Marker,
        GoogleMap,
    },
    props: {
        profiles: Array,
    },
    setup(props) {
        const {profiles} = props;
        const {PROFILE_PATH} = commonConst;
        const mapRef = ref(null)
        const GOOGLE_MAP_API_KEY = process.env.MIX_GOOGLE_MAP_API_KEY;
        const DEFAULT_LAT = 36.23908157359135
        const DEFAULT_LNG = 137.97533854505457
        const DEFAULT_ZOOM = 8.5
        const center = {lat: DEFAULT_LAT, lng: DEFAULT_LNG}
        let initMarkerOptions = ref([]);
        let isCardOpen = ref(false);
        let profileCard = ref({});
        //GoogleMap API
        const mapProfiles = profiles.map(profile => {
            return {
                url: PROFILE_PATH + profile.profile_image,
                lat: profile.latitude,
                lng: profile.longitude,
                id: profile.id
            }
        })

        const markerOptions = computed(() => {
            if (mapRef.value?.ready) {

                initMarkerOptions = mapProfiles.map((mapProfile) => {
                    return {
                        map: {
                            position: {lat: mapProfile.lat, lng: mapProfile.lng},
                            icon: {
                                url: mapProfile.url,
                                scaledSize: new mapRef.value.api.Size(30, 30),
                            },
                        },
                        card: {
                            id: mapProfile.id
                        }
                    }
                })

            } else {
                initMarkerOptions = {}
            }

            return initMarkerOptions
        })

        //Google Map プロフィールカード表示
        const showProfileCard = (id) => {
            isCardOpen.value = true
            axios.post(route('resource.card'), id).then(res => {
                profileCard.value = res.data
            }).catch(err => {
                console.log(err)
            })
        }

        const onClickCardOutside = () => isCardOpen.value = false


        return {
            center,
            GOOGLE_MAP_API_KEY,
            markerOptions,
            mapRef,
            isCardOpen,
            showProfileCard,
            profileCard,
            onClickCardOutside,
            DEFAULT_ZOOM,
            profiles,
        }
    }
}
</script>

<style scoped lang="scss">
.card-wrapper {
    transform: translate(-50%, -50%);
    @apply absolute right-1/2 top-1/2 z-50
}
</style>
