<template>

    <div class="text-center m-12">
        <p class="base-font-s">初期パスワードを変更してください</p>
    </div>

    <ValidationErrors class="mb-4" />

    <form @submit.prevent="submit">
        <div>
            <Label for="current_password" value="現在のパスワード" />
            <Input id="current_password" type="password" class="mt-1 block w-full" v-model="form.current_password" required autofocus autocomplete="username" />
        </div>

        <div class="mt-4">
            <Label for="password" value="パスワード" />
            <Input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <Label for="password_confirmation" value="パスワード（確認）" />
            <Input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <Button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                送信
            </Button>
        </div>
    </form>
</template>

<script>
import Guest from "@/Layouts/Guest";
import ValidationErrors from "@/Components/Validations/ValidationErrors";
import Label from "@/Components/Labels/Label";
import Input from "@/Components/Forms/Input";
import Button from "@/Components/Button";
import { useForm } from "@inertiajs/inertia-vue3";
export default {
    name: "InputInitPassword",
    layout: Guest,
    components: {
        Label,
        Input,
        Button,
        ValidationErrors,
    },

    setup() {

        const form = useForm({
            current_password: '',
            password: '',
            password_confirmation: '',
        })

        const submit = () => {
            form.post(route('admin.initializePassword'), {
                onFinish: () => form.reset()
            })
            }


        return {
            form,
            submit,
        }
    }
}
</script>

<style scoped>

</style>
