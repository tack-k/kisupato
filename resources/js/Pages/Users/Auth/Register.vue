<template>
    <breeze-validation-errors class="mb-4" />

    <form @submit.prevent="submit">
        <div class="flex">
            <div class="mr-2">
            <label-required for="last_name_kana" value="姓（カナ）"/>
            <breeze-input id="last_name_kana" type="text" class="mt-1 block w-full" placeholder="ヤマダ" v-model="form.last_name_kana" autofocus />
            </div>
            <div>
            <label-required for="first_name_kana" value="名（カナ）" />
            <breeze-input id="first_name_kana" type="text" class="mt-1 block w-full" placeholder="タロウ" v-model="form.first_name_kana" autofocus />
            </div>
        </div>

        <div class="mt-4 flex">
            <div class="mr-2">
            <label-required for="last_name" value="姓" />
            <breeze-input id="last_name" type="text" class="mt-1 block w-full" placeholder="山田" v-model="form.last_name" autofocus autocoplete="family-name"/>
            </div>
            <div>
                <label-required for="first_name" value="名" />
                <breeze-input id="first_name" type="text" class="mt-1 block w-full" placeholder="太郎" v-model="form.first_name" autofocus autocomplete="given-name" />
            </div>
        </div>

        <div class="mt-4">
            <label-required for="email" value="電話番号" />
            <breeze-input id="tel" type="tel" class="mt-1 block w-full" placeholder="09012341234" v-model="form.tel" autocomplete="tel-national" />
        </div>

        <div class="mt-4">
            <label-required for="postal_code" value="郵便番号" />
            <breeze-input id="postal_code" type="text" class="mt-1 block w-1/3" placeholder="2330987" v-model="form.postal_code" autocomplete="postal_code" />
        </div>

        <div class="mt-4">
            <label-required for="region" value="都道府県" />
            <breeze-input id="region" type="text" class="mt-1 block w-1/3" placeholder="東京都" v-model="form.region" autocomplete="address-level1" />
        </div>

        <div class="mt-4">
            <label-required for="city" value="市区町村" />
            <breeze-input id="city" type="text" class="mt-1 block w-1/3" placeholder="杉並区" v-model="form.city" autocomplete="address-level2" />
        </div>

        <div class="mt-4">
            <label-required for="street" value="番地" />
            <breeze-input id="street" type="text" class="mt-1 block w-full" placeholder="3-55-123" v-model="form.street" autocomplete="address-line1" />
        </div>

        <div class="mt-4">
            <breeze-label for="building" value="建物名" />
            <breeze-input id="building" type="text" class="mt-1 block w-full" placeholder="杉並ビルディング999号室" v-model="form.building" autocomplete="address-line2" />
        </div>

        <div class="mt-4">
            <label-required for="gender" value="性別" />
            <select name="gender" id="gender"  class="block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.gender" >
                <option value="">---</option>
                <option value="0">男性</option>
                <option value="1">女性</option>
                <option value="2">その他</option>
            </select>
        </div>

        <div class="mt-4">
            <label-required for="birthday" value="生年月日" />
            <breeze-input id="birthday" type="date" class="mt-1 block w-1/2" placeholder="taro.yamada@gmail.com" v-model="form.birthday" autocomplete="bday" />
        </div>

        <div class="mt-4">
            <label-required for="email" value="メールアドレス" />
            <breeze-input id="email" type="email" class="mt-1 block w-full" placeholder="taro.yamada@gmail.com" v-model="form.email" autocomplete="email" />
        </div>

        <div class="mt-4">
            <label-required for="password" value="パスワード" />
            <breeze-input id="password" type="password" class="mt-1 block w-full" placeholder="半角英数字８文字以上" v-model="form.password" autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <label-required for="password_confirmation" value="パスワード（確認）" />
            <breeze-input id="password_confirmation" type="password" class="mt-1 block w-full" placeholder="もう一度入力してください" v-model="form.password_confirmation" autocomplete="new-password" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <inertia-link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                登録済みの場合はこちら
            </inertia-link>

            <breeze-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                登録
            </breeze-button>
        </div>
    </form>
</template>

<script>
    import BreezeButton from '@/Components/Button'
    import BreezeGuestLayout from '@/Layouts/Guest'
    import BreezeInput from '@/Components/Forms/Input'
    import BreezeLabel from '@/Components/Labels/Label'
    import BreezeValidationErrors from '@/Components/ValidationErrors'
    import BreezeCheckbox from '@/Components/Forms/Checkbox'
    import LabelRequired from "@/Components/Labels/LabelRequired";


    export default {
        layout: BreezeGuestLayout,

        components: {
            LabelRequired,
            BreezeButton,
            BreezeInput,
            BreezeLabel,
            BreezeValidationErrors,
            BreezeCheckbox,
        },

        data() {
            return {
                form: this.$inertia.form({
                    last_name_kana: '',
                    first_name_kana: '',
                    last_name: '',
                    first_name: '',
                    tel: '',
                    postal_code: '',
                    region: '',
                    city: '',
                    street: '',
                    building: '',
                    gender: '',
                    birthday: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        provide() {
            return {

            }
        },

        methods: {
            submit() {
                this.form.post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
