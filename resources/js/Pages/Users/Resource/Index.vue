<template>
    <full-page-layout>
        <template #content>
            <div>
                <div class="flex">
                    <div class="py-6">
                        <div class="flex max-w-md bg-white shadow-lg rounded-lg overflow-hidden">
                            <div class="w-1/3 bg-cover" style="background-image: url('https://images.unsplash.com/photo-1494726161322-5360d4d0eeae?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80')">
                            </div>
                            <div class="w-2/3 p-4">
                                <h1 class="text-gray-900 font-bold text-2xl">Backpack</h1>
                                <p class="mt-2 text-gray-600 text-sm">Lorem ipsum dolor sit amet consectetur adipisicing elit In odit exercitationem fuga id nam quia</p>
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
                                        <button class="px-3 py-2 bg-gray-800 text-white text-xs font-bold uppercase rounded">Add to Card</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <GoogleMap
                        ref="mapRef"
                        :api-key="GOOGLE_MAP_API_KEY"
                        style="width: 100%; height: 500px"
                        :center="center"
                        :zoom="15"
                    >
                        <Marker :options="val"/>
                    </GoogleMap>
                    <!--                    <GoogleMap-->
                    <!--                        ref="mapRef"-->
                    <!--                        :api-key=GOOGLE_MAP_API_KEY-->
                    <!--                        class="map"-->
                    <!--                        :center="center"-->
                    <!--                        :zoom="2"-->
                    <!--                    >-->
                    <!--                        <Marker :options="markerOptions" class="rounded-full w-3 h-3"/>-->

                    <!--                    </GoogleMap>-->
                    <!--                    <label for="lng">Longitude</label>-->
                    <!--                    <input v-model.number="lng" id="lng" type="number" min="-180" max="180" step="10" />-->
                </div>
            </div>
        </template>
    </full-page-layout>
</template>

<script>
import Header from "@/Layouts/Users/Header"
import FullPageLayout from "@/Layouts/Users/FullPageLayout"
import { GoogleMap, Marker, IControlPosition } from 'vue3-google-map'
import { ref, computed, watch, onMounted, reactive, watchEffect } from "vue";

export default {
    name: "Index",
    components: {
        FullPageLayout,
        Header,
        Marker,
        GoogleMap,
    },
    setup() {
        const mapRef = ref(null)
        const GOOGLE_MAP_API_KEY = process.env.MIX_GOOGLE_MAP_API_KEY;
        const center = { lat: 40.689247, lng: -74.044502 }
        let markerOptions = reactive({});

       const val = computed(() => {

            console.log(mapRef.value?.ready)
            if (mapRef.value?.ready) {

               return markerOptions = {
                    position: center,
                    label: {
                        text: 'TTTTT',
                        color: 'red',
                    },
                    icon: {
                        url: '/images/users/profile.png',
                        scaledSize: mapRef.value.api.Size(15, 15)
                    },
                   anchorPoint: mapRef.value.api.Point(100, 100)
               }
                console.log(markerOptions)
                //     title: 'LADY LIBERTY'
            } else {
                return markerOptions = {}
            }

       })
        // }, {
        //     flush: 'post'
        // })

// onMounted(() => {
//     console.log(mapRef.value.ready)
//          markerOptions = {
//             position: center,
//             label: {
//                 text: 'TTTTT',
//                 color: 'red',
//             },
//             icon: {
//                 url: '/images/users/profile.png',
//                 scaledSize: mapRef.value.api.Size(30, 30)
//             },
//        //     title: 'LADY LIBERTY'
//         }
// })
        // const center = { lat: 0, lng: 0 }
        //
        // const _lng = ref(0)
        // const lng = computed({
        //     get: () => _lng.value,
        //     set: v => {
        //         if (!Number.isFinite(v)) {
        //             _lng.value = 0
        //         } else if (v > 180) {
        //             _lng.value = 180
        //         } else if (v < -180) {
        //             _lng.value = -180
        //         } else {
        //             _lng.value = v
        //         }
        //     },
        // })

        // watch(lng, () => {
        //     if (mapRef.value?.ready) {
        //         console.log(mapRef.value?.ready)
        //         mapRef.value.map.panTo({ lat: 0, lng: lng.value })
        //     }
        // })
        return {
            center,
            GOOGLE_MAP_API_KEY,
            markerOptions,
            mapRef,
            // lng,
            val,

        }
    }
}
</script>

<style scoped>
.map {
    position: relative;
    width: 100%;
    height: 500px;
}

.map::after {
    position: absolute;
    content: '';
    width: 1px;
    height: 100%;
    top: 0;
    left: 50%;
    background: red;
}

input[type='number'] {
    width: 200px;
    margin-top: 20px;
    margin-left: 10px;
}
</style>
