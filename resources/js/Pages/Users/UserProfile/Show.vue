<template>
    <my-page-layout>
        <template #content>
            <div class="flex h-screen w-full justify-center">

                <div class="w-full mt-4">
                    <div class="bg-gray-50 shadow-xl rounded-lg py-3">
                        <div class="photo-wrapper p-2">
                            <img class="w-32 h-32 rounded-full mx-auto" :src="displayedProfilePath + profile.profile_image" alt="">
                        </div>
                        <div class="p-2">
                            <h3 class="text-center text-xl text-gray-900 font-medium leading-8">{{ profile.nickname }}</h3>
                            <table class="my-3">
                                <tbody>
                                <tr class="text-lg">
                                    <td class="px-2 py-2 text-gray-500 base-font-bold">自己紹介</td>
                                    <td class="px-2 py-2" :class="{'text-red-400': isNoInput.self_introduction}">{{ profile.self_introduction }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="my-5 text-center">
                            <Link :href="route('profile.input')" as="button" type="button" class="expert-regular-btn">
                                プロフィール編集
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from '@/Layouts/Users/MyPageLayout'
import { Link, useForm } from "@inertiajs/inertia-vue3";
import RegularButton from '@/Components/Buttons/RegularButton';
import { commonConst } from '@/Consts/commonConst'
import { reactive, toRefs } from 'vue'
import { messageConst } from '@/Consts/messageConst'


export default {
    name: "Show",
    components: {
        RegularButton,
        MyPageLayout,
        Link,
    },
    props: {
        profile: Object,
    },
    setup(props) {
        const { profile } = toRefs(props);
        const { USER_PROFILE_PATH, DEFAULT_PROFILE, COMMON_PATH } = commonConst;
        const { INPUT_NICKNAME, INPUT_SELF_INTRODUCTION } = messageConst;
        let displayedProfilePath = profile.value.profile_image === DEFAULT_PROFILE ? COMMON_PATH : USER_PROFILE_PATH;

        const isNoInput = reactive({
            self_introduction: false,
        })

        if(profile.value.self_introduction === null) {
            profile.value.self_introduction = INPUT_SELF_INTRODUCTION;
            isNoInput.self_introduction = true;
        }

        return {
            profile,
            DEFAULT_PROFILE,
            displayedProfilePath,
            isNoInput,
        }
    }
}
</script>

<style scoped>

</style>
