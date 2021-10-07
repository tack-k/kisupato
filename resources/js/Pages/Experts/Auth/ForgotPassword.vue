<template>
    <div class="mb-4 text-sm text-gray-600">
        パスワードをお忘れの方は、以下の項目を入力してください。<br>
        登録されているメールアドレスにパスワード再設定のリンクURLを送信します。
    </div>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <breeze-validation-errors class="mb-4" />

    <form @submit.prevent="submit">
        <div class="mb-3">
            <breeze-label for="birthday" value="生年月日" />
            <breeze-input id="birthday" type="date" class="mt-1 block w-1/2" v-model="form.birthday" required autofocus />
        </div>
        <div>
            <breeze-label for="email" value="Email" />
            <breeze-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <breeze-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                送信
            </breeze-button>
        </div>
    </form>
</template>

<script>
    import BreezeButton from '@/Components/Button'
    import BreezeGuestLayout from "@/Layouts/Guest"
    import BreezeInput from '@/Components/Forms/Input'
    import BreezeLabel from '@/Components/Labels/Label'
    import BreezeValidationErrors from '@/Components/Validations/ValidationErrors'

    export default {
        layout: BreezeGuestLayout,

        components: {
            BreezeButton,
            BreezeInput,
            BreezeLabel,
            BreezeValidationErrors,
        },

        props: {
            status: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    birthday: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('expert.password.email'))
            }
        }
    }
</script>
