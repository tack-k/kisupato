<template>
    <main-layout>
        <template #content>
            <div class="container mx-auto pt-4 py-16 admin-bg-white">
                <div class="w-3/4 py-10 flex flex-col items-center mx-auto">
                    <ValidationFlameErrors/>
                    <h2 class="base-font-m mb-10">職員編集</h2>
                    <form @submit.prevent="submit()">
                        <div>
                            <label-required for="staff_number" value="職員番号"/>
                            <Input id="staff_number" type="text" class="mt-1 w-1/2"
                                   v-model="form.staff_number"/>
                        </div>

                        <div class="mt-4 flex">
                            <div class="mr-2">
                                <label-required for="last_name_kana" value="姓（カナ）"/>
                                <Input id="last_name_kana" type="text" class="mt-1 w-full"
                                       v-model="form.last_name_kana" autofocus/>
                            </div>
                            <div>
                                <label-required for="first_name_kana" value="名（カナ）"/>
                                <Input id="first_name_kana" type="text" class="mt-1 w-full"
                                       v-model="form.first_name_kana" autofocus/>
                            </div>
                        </div>

                        <div class="mt-4 flex">
                            <div class="mr-2">
                                <label-required for="last_name" value="姓"/>
                                <Input id="last_name" type="text" class="mt-1 w-full"
                                       v-model="form.last_name" autofocus autocoplete="family-name"/>
                            </div>
                            <div>
                                <label-required for="first_name" value="名"/>
                                <Input id="first_name" type="text" class="mt-1 w-full"
                                       v-model="form.first_name" autofocus autocomplete="given-name"/>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label-required for="email" value="メールアドレス"/>
                            <Input id="email" type="email" class="mt-1 w-full" v-model="form.email" autocomplete="email"/>
                        </div>

                        <div class="mt-4">
                            <label-required for="department" value="部署"/>
                            <Select :options="departments" v-model="form.department_id"/>
                        </div>

                        <div class="mt-4 mb-20">
                            <label-required for="authority" value="権限"/>
                            <Select :options="authorities" v-model="form.authority_id"/>
                        </div>


                        <div class="flex items-center justify-center p-6 border-t border-solid border-blueGray-200 rounded-b">
                            <div class="mr-6">
                                <Link :href="route('admin.index')" class="admin-outline-btn">戻る</Link>
                            </div>
                            <regular-button :class="{ 'opacity-25': form.processing }"
                                            :disabled="form.processing">変更する
                            </regular-button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </main-layout>
</template>

<script>
import MainLayout from "@/Layouts/Admins/MainLayout";
import {useForm, Link} from "@inertiajs/inertia-vue3";
import ValidationFlameErrors from "@/Components/Validations/ValidationFlameErrors";
import OutlineButton from "@/Components/Buttons/OutlineButton";
import RegularButton from "@/Components/Buttons/RegularButton";
import LabelRequired from "@/Components/Labels/LabelRequired";
import Input from "@/Components/Forms/Input";
import Select from "@/Components/Forms/Select";

export default {
    name: "Edit",
    components: {
        MainLayout,
        ValidationFlameErrors,
        OutlineButton,
        RegularButton,
        LabelRequired,
        Input,
        Select,
        Link,
    },
    props: {
        admin: Object,
        authorities: Array,
        departments: Array,
    },
    setup(props) {
        const form = useForm({
            staff_number: props.admin.staff_number,
            last_name_kana: props.admin.last_name_kana,
            first_name_kana: props.admin.first_name_kana,
            last_name: props.admin.last_name,
            first_name: props.admin.first_name,
            department_id: String(props.admin.department_id),
            authority_id: String(props.admin.authority_id),
            email: props.admin.email,
        })


        const authorities = props.authorities
        const departments = props.departments
        const admin = props.admin


        const submit = () => {
            form.put(route('admin.update', {'id': admin.id}), {
                onSuccess: () => {
                    form.reset()
                }
            })

        }

        return {
            form,
            submit,
            authorities,
            departments,
        }
    }
}
</script>

<style scoped>

</style>


