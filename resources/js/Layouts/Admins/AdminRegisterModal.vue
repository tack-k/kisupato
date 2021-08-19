<template>
    <div>
        <regular-button @click="toggleModal">新規登録</regular-button>
        <div v-if="showModal" @click.self="toggleModal"
             class="overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
            <div class="relative w-auto my-6 mx-auto max-w-3xl">
                <!--content-->
                <div class="border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                    <!--header-->
                    <div class="flex items-start justify-between p-5 border-b border-solid border-blueGray-200 rounded-t">
                        <h3 class="text-3xl font-semibold">
                            職員ユーザー登録
                        </h3>
                        <button
                            class="p-1 ml-auto bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                            v-on:click="toggleModal()">
                              <span class="bg-transparent text-black opacity-5 h-6 w-6 text-2xl block outline-none focus:outline-none">
                                   <i class="fas fa-times"></i>
                              </span>
                        </button>
                    </div>
                    <!--body-->
                    <div class="relative p-6 flex-auto">
                        <form @submit.prevent="submit">
                            <div>
                                <label-required for="staff_number" value="職員番号" />
                                <Input id="staff_number" type="text" class="mt-1 block w-1/2" placeholder="00011121" v-model="form.staff_number"  />
                            </div>

                            <div class="mt-4 flex">
                                <div class="mr-2">
                                    <label-required for="last_name_kana" value="姓（カナ）"/>
                                    <Input id="last_name_kana" type="text" class="mt-1 block w-full" placeholder="ヤマダ"
                                           v-model="form.last_name_kana" autofocus/>
                                </div>
                                <div>
                                    <label-required for="first_name_kana" value="名（カナ）"/>
                                    <Input id="first_name_kana" type="text" class="mt-1 block w-full" placeholder="タロウ"
                                           v-model="form.first_name_kana" autofocus/>
                                </div>
                            </div>

                            <div class="mt-4 flex">
                                <div class="mr-2">
                                    <label-required for="last_name" value="姓"/>
                                    <Input id="last_name" type="text" class="mt-1 block w-full" placeholder="山田"
                                           v-model="form.last_name" autofocus autocoplete="family-name"/>
                                </div>
                                <div>
                                    <label-required for="first_name" value="名"/>
                                    <Input id="first_name" type="text" class="mt-1 block w-full" placeholder="太郎"
                                           v-model="form.first_name" autofocus autocomplete="given-name"/>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label-required for="email" value="メールアドレス"/>
                                <Input id="email" type="email" class="mt-1 block w-full"
                                       placeholder="taro.yamada@gmail.com" v-model="form.email" autocomplete="email"/>
                            </div>

                            <div class="mt-4">
                                <label-required for="department" value="部署" />
                                <Select :options="departments" v-model="form.department"/>
                            </div>

                            <div class="mt-4">
                                <label-required for="authority" value="権限" />
                                <Select :options="authorities" v-model="form.authority"/>
                            </div>

                        </form>
                    </div>
                    <!--footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-blueGray-200 rounded-b">
                        <outline-button @click="toggleModal">閉じる</outline-button>
                        <regular-button @click="toggleModal">登録する</regular-button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
    </div>
</template>

<script>
import { ref, reactive } from "vue";
import OutlineButton from "@/Components/Buttons/OutlineButton";
import RegularButton from "@/Components/Buttons/RegularButton";
import LabelRequired from "@/Components/Labels/LabelRequired";
import Input from "@/Components/Forms/Input";
import Select from "@/Components/Forms/Select";
import { Inertia } from '@inertiajs/inertia';

export default {
    name: "RegisterModal",
    components: {
        OutlineButton,
        RegularButton,
        LabelRequired,
        Input,
        Select,
    },
    props: {
        authorities: Array,
        departments: Array,
    },

    setup(props) {
        const authorities = props.authorities
        const departments = props.departments

        const form = reactive({
            staff_number: '',
            last_name_kana: '',
            first_name_kana: '',
            last_name: '',
            first_name: '',
            department: '',
            authority: '',
            email: '',
        })
        //
        // const submit = () => {
        //     Inertia.post('/admin/register', form)
        // }

        const showModal = ref(false)
        const toggleModal = () => {
            showModal.value = !showModal.value
        }

        return {
            showModal,
            toggleModal,
            form,
            // submit,
            authorities,
            departments,

        }
    },
}
</script>

<style scoped>

</style>
