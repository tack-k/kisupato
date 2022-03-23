<template>
        <div v-if="isShow" @click.self="toggleModal"
             class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
            <div class="relative w-auto my-6 mx-auto max-w-3xl">
                <!--content-->
                <div
                    class="border-0 rounded-lg shadow-lg relative flex flex-col w-80 admin-bg-white">
                    <!--header-->
                    <div
                        class="flex items-center justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                        <h3 class="base-font-m">レビュー登録</h3>
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

                        <form @submit.prevent="submit()">
                            <div class="mt-4 mb-12">
                                <div class="mb-8">
                                    <LabelRequired for="comment" value="満足度"/>
                                    <star-rating v-model:rating="form.evaluation" :star-size="rating.starSize" :increment="rating.increment"></star-rating>
                                </div>
                                <div class="">
                                    <Label for="comment" value="コメント"/>
                                    <TextArea id="comment" v-model="form.comment" class="w-full"/>
                                </div>
                            </div>

                            <!--footer-->
                            <div
                                class="flex items-center justify-center p-6 border-t border-solid border-blueGray-200 rounded-b">
                                <outline-button @click="toggleModal">閉じる</outline-button>
                                <regular-button :class="{ 'opacity-25': form.processing }" class="ml-8"
                                                :disabled="form.processing">登録する
                                </regular-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="isShow" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
</template>

<script>
import { ref, reactive, toRefs, watch } from "vue";
import BreezeValidationErrors from '@/Components/Validations/ValidationErrors'
import OutlineButton from "@/Components/Buttons/OutlineButton";
import RegularButton from "@/Components/Buttons/RegularButton";
import LabelRequired from "@/Components/Labels/LabelRequired";
import Label from "@/Components/Labels/Label";
import Input from "@/Components/Forms/Input";
import Select from "@/Components/Forms/Select";
import { useForm } from '@inertiajs/inertia-vue3'
import Fa from "vue-fa";
import { faWindowClose } from "@fortawesome/free-regular-svg-icons";
import TextArea from '@/Components/Forms/TextArea'
import StarRating from 'vue-star-rating'

export default {
    name: "ReviewRegisterModal",
    components: {
        TextArea,
        BreezeValidationErrors,
        OutlineButton,
        RegularButton,
        LabelRequired,
        Input,
        Select,
        Fa,
        Label,
        StarRating,
    },
    props: {
        isShow: Boolean,
        ids: Object,
    },
    emits: ['emitIsShow'],

    setup(props, { emit }) {

        const { isShow, ids } = toRefs(props);

        const form = useForm({
            evaluation: null,
            comment: '',
            chatroom_id: null,
            expert_id: null,

        })

        watch(ids.value, (newVal, oldVal) => {
            form.expert_id = newVal.expert_id
            form.chatroom_id = newVal.chatroom_id
        })

        const submit = () => {
            form.post(route('review.store'), {
                onSuccess: () => {
                    form.reset()
                    toggleModal()
                }
            })

        }

        const toggleModal = () => {
            form.comment = '';
            form.evaluation = null;
            emit('emitIsShow', false)
        }

        const rating ={
            increment: 0.5,
            starSize: 30,
        };

        return {
            isShow,
            toggleModal,
            form,
            submit,
            faWindowClose,
            ids,
            rating,
        }
    },

}
</script>

<style scoped>

</style>
