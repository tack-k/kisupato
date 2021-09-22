<template>
    <div>
        <div class="flex justify-end mt-8">
        <regular-button @click="toggleModal">新規登録</regular-button>
        </div>
        <div v-if="showModal" @click.self="toggleModal"
             class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
            <div class="relative w-auto my-6 mx-auto max-w-3xl">
                <!--content-->
                <div
                    class="border-0 rounded-lg shadow-lg relative flex flex-col w-full admin-bg-white">
                    <!--header-->
                    <div
                        class="flex items-center justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                        <h3 class="base-font-m">
                            専門人材タグ登録
                        </h3>
                        <button
                            class=""
                            v-on:click="toggleModal()">
                              <span
                                  class="">
                                  <Fa :icon="faWindowClose" size="lg" />
                              </span>
                        </button>
                    </div>
                    <!--body-->
                    <div class="relative p-6 flex-auto">

                        <breeze-validation-errors class="mb-4"/>

                        <form @submit.prevent="submit()">
                            <div class="mt-4 mb-12">
                                <div class="mr-2">
                                    <label-required for="name" value="専門人材タグ名"/>
                                    <Input id="name" type="text" class="mt-1 w-full"
                                           v-model="form.name" autofocus/>
                                </div>
                            </div>

                            <!--footer-->
                            <div
                                class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                                <outline-button @click="toggleModal">閉じる</outline-button>
                                <regular-button :class="{ 'opacity-25': form.processing }"
                                                :disabled="form.processing">登録する
                                </regular-button>
                            </div>
                        </form>
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
import {useForm} from '@inertiajs/inertia-vue3'
import Fa from "vue-fa";
import { faWindowClose } from "@fortawesome/free-regular-svg-icons";

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
    },

    setup() {

        const form = useForm({
            name: '',
        })

        const submit = () => {
           form.post(route('admin.tag.store'), {
               onSuccess: () => {
                   form.reset()
                   toggleModal()
               }
           })

        }

        const showModal = ref(false)
        const toggleModal = () => {
            showModal.value = !showModal.value
        }
        return {
            showModal,
            toggleModal,
            form,
            submit,
            faWindowClose,

        }
    },

}
</script>

<style scoped>

</style>
