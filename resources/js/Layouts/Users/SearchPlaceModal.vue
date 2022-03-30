<template>
    <div>
        <div class="">
            <input class="rounded-full border-0 hover:bg-gray-100 focus:ring-0 py-4 hover:cursor-pointer" type="text"
                   placeholder="場所から探す" @click="toggleModal" :value="checkedStr">
        </div>
        <div v-if="showModal" @click.self="onClickOutsideModal"
             class="fixed inset-0 z-20 outline-none focus:outline-none justify-center items-center flex">
            <div class="relative w-auto my-6 mx-auto max-w-3xl">
                <!--content-->
                <div
                    class="border-0 rounded-lg shadow-lg relative flex flex-col w-full admin-bg-white max-h-screen overflow-y-scroll">

                    <!--body-->
                    <div class="relative p-6 flex-auto">
                        <div class="border-b border-solid border-blueGray-200 rounded-b pb-4"
                             v-for="(area, index) in areas" :key="index">
                            <label class="flex items-center mb-2 mt-4">
                                <Checkbox v-if="area.id === 1" v-model="allCheckedNorth" :checked="allCheckedNorth"/>
                                <Checkbox v-if="area.id === 2" v-model="allCheckedMiddle" :checked="allCheckedMiddle"/>
                                <Checkbox v-if="area.id === 3" v-model="allCheckedEast" :checked="allCheckedEast"/>
                                <Checkbox v-if="area.id === 4" v-model="allCheckedSouth" :checked="allCheckedSouth"/>
                                <span class="ml-2">{{ area.name }}</span>
                            </label>
                            <ul class="ml-4 flex flex-wrap">
                                <li v-for="(city, index) in area.cities" :key="index" class="mr-3 mb-1"><label
                                    class="flex items-center">
                                    <Checkbox v-if="area.id === 1" v-model:checked="checked['north']"
                                              :value="city.city_id"/>
                                    <Checkbox v-if="area.id === 2" v-model:checked="checked['middle']"
                                              :value="city.city_id"/>
                                    <Checkbox v-if="area.id === 3" v-model:checked="checked['east']"
                                              :value="city.city_id"/>
                                    <Checkbox v-if="area.id === 4" v-model:checked="checked['south']"
                                              :value="city.city_id"/>
                                    <span class="ml-2">{{ city.name }}</span><span class="ml-2">{{ city.count }}</span></label>
                                </li>
                            </ul>
                        </div>

                        <!--footer-->
                        <div
                            class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                            <button type="button" class="user-regular-btn" @click="emitChecked">決定</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="opacity-25 fixed inset-0 z-10 bg-black"></div>
    </div>
</template>

<script>
import { ref, reactive, computed, watchEffect, toRefs } from "vue";
import BreezeValidationErrors from '@/Components/Validations/ValidationErrors'
import OutlineButton from "@/Components/Buttons/OutlineButton";
import RegularButton from "@/Components/Buttons/RegularButton";
import LabelRequired from "@/Components/Labels/LabelRequired";
import Input from "@/Components/Forms/Input";
import Select from "@/Components/Forms/Select";
import {useForm} from '@inertiajs/inertia-vue3'
import Fa from "vue-fa";
import {faWindowClose} from "@fortawesome/free-regular-svg-icons";
import Checkbox from "@/Components/Forms/Checkbox";

export default {
    name: "SearchPlaceModal",
    components: {
        Checkbox,
        BreezeValidationErrors,
        OutlineButton,
        RegularButton,
        LabelRequired,
        Input,
        Select,
        Fa,
    },
    props: {
        areas: Object,
    //    checked: String
    },
    emits: [
        'update:checked',
        'test'
    ],
    setup(props, {emit}) {


        let { areas } = toRefs(props);

        let checked = reactive({
                'north': [],
                'middle': [],
                'east': [],
                'south': [],
            }
        )

        const showModal = ref(false)
        const toggleModal = () => {
            showModal.value = !showModal.value
        }

        const onClickOutsideModal = () => {
            showModal.value = false;
            checked['north'] = [];
            checked['middle'] = [];
            checked['east'] = [];
            checked['south'] = [];
        }

        const emitChecked = () => {
            emit('update:checked', checked)
            toggleModal()
        }

        const checkedStr = computed(() => {
            if (checked['north'].length > 0 ||
                checked['middle'].length > 0 ||
                checked['east'].length > 0 ||
                checked['south'].length > 0
            ) {
                return '入力済みです'
            }
        })

        const allCheckedNorth = computed({
            get: () => {
                return checked['north'].length === areas.value['north'].cities.length
            },
            set: val => {
                if (val) {
                    const newCities = areas.value['north'].cities.map(city => city.city_id)
                    checked['north'] = newCities
                } else {
                    checked['north'] = []
                }
            }
        })

        const allCheckedEast = computed({
            get: () => {
                return checked['east'].length === areas.value['east'].cities.length
            },
            set: val => {
                if (val) {
                    const newCities = areas.value['east'].cities.map(city => city.city_id)
                    checked['east'] = newCities
                } else {
                    checked['east'] = []
                }
            }
        })

        const allCheckedSouth = computed({
            get: () => {
                return checked['south'].length === areas.value['south'].cities.length
            },
            set: val => {
                if (val) {
                    const newCities = areas.value['south'].cities.map(city => city.city_id)
                    checked['south'] = newCities
                } else {
                    checked['south'] = []
                }
            }
        })

        const allCheckedMiddle = computed({
            get: () => {
                return checked['middle'].length === areas.value['middle'].cities.length
            },
            set: val => {
                if (val) {
                    const newCities = areas.value['middle'].cities.map(city => city.city_id)
                    checked['middle'] = newCities
                } else {
                    checked['middle'] = []
                }
            }
        })

        return {
            showModal,
            toggleModal,
            checked,
            faWindowClose,
            emitChecked,
            checkedStr,
            allCheckedNorth,
            allCheckedMiddle,
            allCheckedEast,
            allCheckedSouth,
            onClickOutsideModal,
        }
    },

}
</script>

<style scoped>

</style>
