<template>
    <my-page-layout>
        <template #content>
            <form @submit.prevent="submit">
                <div class="flex">
                    <div class="mr-2">
                        <LabelRequired for="last_name_kana" value="姓（カナ）"/>
                        <Input id="last_name_kana" type="text" class="mt-1 block w-full" placeholder="ヤマダ" v-model="form.last_name_kana" autofocus />
                    </div>
                    <div>
                        <LabelRequired for="first_name_kana" value="名（カナ）" />
                        <Input id="first_name_kana" type="text" class="mt-1 block w-full" placeholder="タロウ" v-model="form.first_name_kana" autofocus />
                    </div>
                </div>

                <div class="mt-4 flex">
                    <div class="mr-2">
                        <LabelRequired for="last_name" value="姓" />
                        <Input id="last_name" type="text" class="mt-1 block w-full" placeholder="山田" v-model="form.last_name" autofocus autocoplete="family-name"/>
                    </div>
                    <div>
                        <LabelRequired for="first_name" value="名" />
                        <Input id="first_name" type="text" class="mt-1 block w-full" placeholder="太郎" v-model="form.first_name" autofocus autocomplete="given-name" />
                    </div>
                </div>

                <div class="mt-4">
                    <LabelRequired for="email" value="電話番号" />
                    <Input id="tel" type="tel" class="mt-1 block w-full sm:w-1/3" placeholder="09012341234" v-model="form.tel" autocomplete="tel-national" />
                </div>

                <div class="mt-4">
                    <LabelRequired for="postal_code" value="郵便番号" />
                    <Input id="postal_code" type="text" class="mt-1 block w-1/3" placeholder="2330987" v-model="form.postal_code" autocomplete="postal_code" />
                </div>

                <div class="mt-4">
                    <LabelRequired for="region" value="都道府県" />
                    <Input id="region" type="text" class="mt-1 block w-1/3" placeholder="東京都" v-model="form.region" autocomplete="address-level1" />
                </div>

                <div class="mt-4">
                    <LabelRequired for="city" value="市区町村" />
                    <Input id="city" type="text" class="mt-1 block w-1/3" placeholder="杉並区" v-model="form.city" autocomplete="address-level2" />
                </div>

                <div class="mt-4">
                    <LabelRequired for="street" value="番地" />
                    <Input id="street" type="text" class="mt-1 block w-full sm:w-1/2" placeholder="3-55-123" v-model="form.street" autocomplete="address-line1" />
                </div>

                <div class="mt-4">
                    <Label for="building" value="建物名" />
                    <Input id="building" type="text" class="mt-1 block w-full sm:w-1/2" placeholder="杉並ビルディング999号室" v-model="form.building" autocomplete="address-line2" />
                </div>

                <div class="mt-4">
                    <LabelRequired for="gender" value="性別" />
                    <select name="gender" id="gender"  class="block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.gender" >
                        <option value="">---</option>
                        <option value="0">男性</option>
                        <option value="1">女性</option>
                        <option value="2">その他</option>
                    </select>
                </div>

                <div class="mt-4">
                    <LabelRequired for="birthday" value="生年月日" />
                    <Input id="birthday" type="date" class="mt-1 block w-1/3" placeholder="taro.yamada@gmail.com" v-model="form.birthday" autocomplete="bday" />
                </div>

                <div class="mt-4">
                    <LabelRequired for="email" value="メールアドレス" />
                    <Input id="email" type="email" class="mt-1 block w-full sm:w-1/3" placeholder="taro.yamada@gmail.com" v-model="form.email" autocomplete="email" />
                </div>

                <div class="mt-4 text-blue-400 base-font-bold user-hover">
                    <p @click="changePassword" v-if="isPasswordChange">パスワードを変更しない</p>
                    <p @click="changePassword" v-else>パスワードを変更する</p>
                </div>

                <div v-if="isPasswordChange">
                    <div class="mt-4">
                        <LabelRequired for="current-password" value="現在のパスワード" />
                        <Input id="current-password" type="password" class="mt-1 block w-full sm:w-1/3" placeholder="半角英数字８文字以上" v-model="form.current_password" autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <LabelRequired for="password" value="新しいパスワード" />
                        <Input id="password" type="password" class="mt-1 block w-full sm:w-1/3" placeholder="半角英数字８文字以上" v-model="form.password" autocomplete="new-password" />
                    </div>

                    <div class="mt-4">
                        <LabelRequired for="password_confirmation" value="新しいパスワード（確認）" />
                        <Input id="password_confirmation" type="password" class="mt-1 block w-full sm:w-1/3" placeholder="もう一度入力してください" v-model="form.password_confirmation" autocomplete="new-password" />
                    </div>
                </div>

                <div class="flex justify-center mt-4">
                    <button class="expert-regular-btn mr-20">変更する</button>
                    <Link :href="route('profile.show')" class="expert-outline-btn">戻る</Link>
                </div>
            </form>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Users/MyPageLayout'
import Input from '@/Components/Forms/Input'
import Label from '@/Components/Labels/Label'
import LabelRequired from '@/Components/Labels/LabelRequired'
import { usePage, Link, useForm } from '@inertiajs/inertia-vue3'
import { computed, ref } from 'vue'
import { commonConst } from '@/Consts/commonConst'

export default {
    name: "Edit",
    components: {
        MyPageLayout,
        Link,
        Input,
        Label,
        LabelRequired,
    },
    setup() {
        const user = computed(() => usePage().props.value.auth.user)
        const {
            MEN,
            WOMEN,
            OTHER_GENDER
        } = commonConst;

        switch (user.value.gender) {
            case MEN:
                user.value.genderName = '男性'
                break
            case WOMEN:
                user.value.genderName = '女性'
                break
            case OTHER_GENDER:
                user.value.genderName = 'その他'
                break
        }

        const isPasswordChange = ref(false);
        const changePassword = () => isPasswordChange.value = !isPasswordChange.value
        const isPasswordChangeForm = computed(() => isPasswordChange.value)

        const form = useForm({
            last_name_kana: user.value.last_name_kana,
            first_name_kana: user.value.first_name_kana,
            last_name: user.value.last_name,
            first_name: user.value.first_name,
            tel: user.value.tel,
            postal_code: user.value.postal_code,
            region: user.value.city,
            city: user.value.region,
            street: user.value.street,
            building: user.value.building,
            gender: user.value.gender,
            birthday: user.value.birthday,
            email: user.value.email,
            current_password: '',
            password: '',
            password_confirmation: '',
            is_password_change: isPasswordChangeForm,
        })

        const submit = () => {
            form.post(route('account.update'), {
                onFinish: () => form.reset('current_password', 'password', 'password_confirmation')
            })
        }


        return {
            user,
            form,
            submit,
            isPasswordChange,
            changePassword,
        }
    }
}
</script>

<style scoped>

</style>
