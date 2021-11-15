<template>
    <div>
        <div class="flex justify-end">
            <button @click="checkTemporarilySaved" class="expert-regular-btn">編集する</button>
        </div>
        <div v-if="showModal" @click.self="toggleModal"
             class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
            <div class="relative w-auto my-6 mx-auto max-w-3xl">
                <!--content-->
                <div
                    class="border-0 rounded-lg shadow-lg relative flex flex-col w-full admin-bg-white">
                    <!--header-->
                    <div
                        class="flex items-center justify-end p-5 border-b border-solid border-blueGray-200 rounded-t">
                        <button
                            class=""
                            v-on:click="toggleModal()">
                              <span
                                  class="">
                                  <Fa :icon="faWindowClose" size="lg"/>
                              </span>
                        </button>
                    </div>
                    <!--body-->
                    <div class="relative p-6 flex-auto">

                        <breeze-validation-errors class="mb-4"/>

                            <div class="mt-4 mb-12">
                                <div class="mr-2">
                                    <p>一時保存データがあります。再開しますか？</p>
                                </div>
                            </div>

                            <!--footer-->
                            <div class="flex items-center justify-center p-6 border-t border-solid border-blueGray-200 rounded-b">
                                <Link :href="route('expert.profile.input', {'saved': 0})"
                                      class="expert-outline-btn mr-2">新規
                                </Link>
                                <Link :href="route('expert.profile.input', {'saved': 1})" class="expert-regular-btn">
                                    再開
                                </Link>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
    </div>
</template>

<script>
import {ref, reactive} from "vue";
import BreezeValidationErrors from '@/Components/Validations/ValidationErrors'
import OutlineButton from "@/Components/Buttons/OutlineButton";
import RegularButton from "@/Components/Buttons/RegularButton";
import LabelRequired from "@/Components/Labels/LabelRequired";
import Input from "@/Components/Forms/Input";
import Select from "@/Components/Forms/Select";
import {useForm, Link} from '@inertiajs/inertia-vue3'
import Fa from "vue-fa";
import {faWindowClose} from "@fortawesome/free-regular-svg-icons";

export default {
    name: "RegisterModal",
    components: {
        BreezeValidationErrors,
        OutlineButton,
        RegularButton,
        LabelRequired,
        Input,
        Select,
        Fa,
        Link,
    },

    setup() {

        const form = useForm({
            name: '',
        })


        const showModal = ref(false)
        const toggleModal = () => {
            showModal.value = !showModal.value
        }

        const checkTemporarilySaved = () => {
            axios.get(route('expert.profile.ajaxSave'))
                .then(res => {
                    console.log(res)
                    if (res.data === 1) {
                        toggleModal()
                    } else {
                          location.href = route('expert.profile.input', {'saved': 0})
                    }
                })
                .catch(error => {
                    console.log(error)
                })
        }

        return {
            showModal,
            toggleModal,
            form,
            faWindowClose,
            checkTemporarilySaved,

        }
    },

}
</script>

<style scoped>

</style>
