<template>
    <div v-if="showModal" @click.self="toggleModal"
         class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
        <div class="relative w-auto my-6 mx-auto max-w-3xl">
            <!--content-->
            <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full admin-bg-white">
                <!--header-->
                <div class="flex items-center justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                    <h3 class="text-3xl base-font-bold">
                        タグから選択する
                    </h3>
                    <button class="" v-on:click="toggleModal()">
                              <span class="">
                                  <Fa :icon="faWindowClose" size="lg"/>
                              </span>
                    </button>
                </div>
                <!--body-->
                <div class="relative p-6 flex-auto">

                    <div class="my-4">
                        <label class="flex items-center mb-2 mt-4">
                            <Checkbox v-model="allChecked" :checked="allChecked"/>
                            <span class="ml-2">すべて選択</span>
                        </label>
                        <ul class="ml-4 flex items-center flex-wrap">
                            <li v-for="(tag, key) in tags" :key="key" class="mr-3 mb-1">
                                <label class="flex items-center">
                                    <Checkbox v-model:checked="checkedTag" :value="tag.id"/>
                                    <span class="ml-2">{{ tag.name }}</span>
                                </label>
                            </li>
                        </ul>
                    </div>

                    <!--footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                        <outline-button class="mr-4" @click="toggleModal">閉じる</outline-button>
                        <regular-button :type="'button'" @click="emitChecked()">選択する</regular-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
</template>

<script>
import { ref, reactive, toRefs, watch, computed } from "vue";
import OutlineButton from "@/Components/Buttons/OutlineButton";
import RegularButton from "@/Components/Buttons/RegularButton";
import LabelRequired from "@/Components/Labels/LabelRequired";
import Input from "@/Components/Forms/Input";
import Select from "@/Components/Forms/Select";
import Fa from "vue-fa";
import { faWindowClose } from "@fortawesome/free-regular-svg-icons";
import Checkbox from '@/Components/Forms/Checkbox'

export default {
    name: "MailMagazineTagModal",
    components: {
        Checkbox,
        OutlineButton,
        RegularButton,
        LabelRequired,
        Input,
        Select,
        Fa,
    },
    props: {
        tags: Array,
        showModal: Boolean,
        checked: {
            type: Array,
        },
    },
    emits: [
        'update:checked',
        'emitShowModal',
    ],
    setup(props, { emit }) {
        const { showModal, tags, checked } = toRefs(props)
        const toggleModal = () => {
            emit('emitShowModal', !showModal.value)
            checkedTag.value = checked.value
        }

         const checkedTag = ref([]);

        const emitChecked = () => {
            emit('update:checked', checkedTag.value)
            emit('emitShowModal', !showModal.value)
        }

        const allChecked = computed({
            get: () => {
                return checkedTag.value?.length === tags.value.length
            },
            set: val => {
                if (val) {
                    const newTags = tags.value.map(tag => tag.id)
                    checkedTag.value = newTags
                } else {
                    checkedTag.value = []
                }
            }
        })

        //全員送信選択時に、チェックボックスをリセットする
        watch(checked, () => {
            if(checked.value?.length === 0) {
                checkedTag.value = []
            }
        })


        return {
            showModal,
            toggleModal,
            faWindowClose,
            emitChecked,
            checkedTag,
            allChecked,
        }
    },
}
</script>

<style scoped>

</style>
