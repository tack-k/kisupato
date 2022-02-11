<template>
    <full-page-layout>
        <template #content>
            <div>
                <div class="flex">
                    <div class="py-6 w-1/2">
                        <div class="flex max-w-md bg-white shadow-lg rounded-lg overflow-hidden">
                            <div class="w-1/3 bg-cover" style="background-image: url('https://images.unsplash.com/photo-1494726161322-5360d4d0eeae?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80')">
                            </div>
                            <div class="w-2/3 p-4">
                                <h1 class="text-gray-900 font-bold text-2xl">Backpack</h1>
                                <p class="mt-2 text-gray-600 text-sm">Lorem ipsum dolor sit amet consectetur adipisicing
                                    elit In odit exercitationem fuga id nam quia</p>
                                <div class="flex item-center mt-2">
                                    <svg class="w-5 h-5 fill-current text-gray-700" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z"/>
                                    </svg>
                                    <svg class="w-5 h-5 fill-current text-gray-700" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z"/>
                                    </svg>
                                    <svg class="w-5 h-5 fill-current text-gray-700" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z"/>
                                    </svg>
                                    <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z"/>
                                    </svg>
                                    <svg class="w-5 h-5 fill-current text-gray-500" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21L16.54 13.97L22 9.24L14.81 8.63L12 2L9.19 8.63L2 9.24L7.46 13.97L5.82 21L12 17.27Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="flex mt-5">
                                        <img alt="avatar" class="w-6 rounded-full border-2 border-gray-300" src="https://picsum.photos/seed/picsum/200"/>
                                        <p class="ml-3">John Doe</p>
                                    </div>
                                    <div class="flex item-center justify-between mt-3">
                                        <h1 class="text-gray-700 font-bold text-xl">$220</h1>
                                        <button class="px-3 py-2 bg-gray-800 text-white text-xs font-bold uppercase rounded">
                                            Add to Card
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="w-1/2">
                        <GoogleMap
                            ref="mapRef"
                            :api-key="GOOGLE_MAP_API_KEY"
                            style="width: 100%; height: 500px"
                            :center="center"
                            :zoom="9"
                        >
                            <Marker :options="markerOption" v-for="(markerOption, index) in markerOptions" :key="index"/>
                        </GoogleMap>
                    </div>
                </div>
            </div>
        </template>
    </full-page-layout>
</template>

<script>
import Header from "@/Layouts/Users/Header"
import FullPageLayout from "@/Layouts/Users/FullPageLayout"
import {GoogleMap, Marker, IControlPosition} from 'vue3-google-map'
import {ref, computed} from "vue";
import {commonConst} from "@/Consts/commonConst"


export default {
    name: "Index",
    components: {
        FullPageLayout,
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
        const center = {lat: 36.197910809248135, lng: 138.06393209955368}
        let initMarkerOptions = ref([]);

        const mapProfiles = profiles.map(profile => {
            return {
                url: PROFILE_PATH + profile.profile_image,
                lat: profile.latitude,
                lng: profile.longitude,
            }
        })

        const markerOptions = computed(() => {
            if (mapRef.value?.ready) {

                initMarkerOptions = mapProfiles.map((mapProfile) => {
                    return {
                        position: {lat: mapProfile.lat, lng: mapProfile.lng},
                        icon: {
                            url: mapProfile.url,
                            scaledSize: new mapRef.value.api.Size(30, 30),
                        },
                    }
                })

            } else {
                initMarkerOptions = {}
            }

            return initMarkerOptions
        })

        return {
            center,
            GOOGLE_MAP_API_KEY,
            markerOptions,
            mapRef,

        }
    }
}
</script>

<style scoped>

</style>
