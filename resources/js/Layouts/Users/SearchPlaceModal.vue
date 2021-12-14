<template>
        <div class="">
            <input class="rounded-l-full" type="text" placeholder="市町村から選ぶ" @click="toggleModal" :value="checkedStr">
        </div>
        <div v-if="showModal" @click.self="emitChecked"
             class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
            <div class="relative w-auto my-6 mx-auto max-w-3xl">
                <!--content-->
                <div
                    class="border-0 rounded-lg shadow-lg relative flex flex-col w-full admin-bg-white">

                    <!--body-->
                    <div class="relative p-6 flex-auto">
                            <div class="border-b border-solid border-blueGray-200 rounded-b pb-4" v-for="value in 4" :key="value">
                                <label class="flex items-center mb-2 mt-4"><Checkbox v-model="allChecked" :checked="allChecked"/><span class="ml-2">北信</span></label>
                                <ul class="ml-4 flex flex-wrap">
                                    <li v-for="expert in experts" :key="expert" class="mr-3 mb-1"><label class="flex items-center"><Checkbox v-model:checked="checked" :value="expert"/><span class="ml-2">{{ expert }}</span></label></li>
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
        <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
</template>

<script>
import {ref, reactive, computed, watch} from "vue";
import BreezeValidationErrors from '@/Components/Validations/ValidationErrors'
import OutlineButton from "@/Components/Buttons/OutlineButton";
import RegularButton from "@/Components/Buttons/RegularButton";
import LabelRequired from "@/Components/Labels/LabelRequired";
import Input from "@/Components/Forms/Input";
import Select from "@/Components/Forms/Select";
import {useForm} from '@inertiajs/inertia-vue3'
import Fa from "vue-fa";
import { faWindowClose } from "@fortawesome/free-regular-svg-icons";
import Checkbox from "@/Components/Forms/Checkbox";

export default {
    name: "RegisterModal",
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

    },
    emits: ['update:checked'],
    setup(props, { emit }) {


        let checked = ref([])
        const experts = ref(['長野市', '須坂市', '中野市', '栄村'])

        const showModal = ref(false)
        const toggleModal = () => {
            showModal.value = !showModal.value
        }

        const emitChecked = () => {
            emit('update:checked', checked.value)
            toggleModal()
        }

        const checkedStr = computed(() => {
            return checked.value.join('・')
        })

        const allChecked = computed({
            get: () => {
              return checked.value.length === experts.value.length
            },
            set: val => {
                if(val) {
                    checked.value = experts.value
                } else {
                    checked.value = []
                }
            }
        })

        return {
            showModal,
            toggleModal,
            checked,
            faWindowClose,
            experts,
            emitChecked,
            checkedStr,
            allChecked,
        }
    },

    // data() {
    //     return {
    //         form: this.$inertia.form({
    //             staff_number: '',
    //             last_name_kana: '',
    //             first_name_kana: '',
    //             last_name: '',
    //             first_name: '',
    //             department: '',
    //             authority: '',
    //             email: '',
    //         })
    //     }
    // },
    //
    // methods: {
    //     submit() {
    //         this.form.post(this.route('admin.store'), {
    //             onSuccess: () => this.form.reset()
    //         })
    //     }
    // }

}
</script>

<style scoped>

</style>
