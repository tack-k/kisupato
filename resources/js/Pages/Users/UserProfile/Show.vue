<template>
    <my-page-layout>
        <template #content>
            <div class="flex h-screen w-full justify-center">

                <div class="w-full mt-4">
                    <div class="bg-gray-50 shadow-xl rounded-lg py-12 max-w-2xl mx-auto">
                        <div class="photo-wrapper p-2">
                            <img class="w-32 h-32 rounded-full mx-auto" :src="displayedProfilePath + profile.profile_image" alt="">
                        </div>
                        <h3 class="my-2 text-center text-xl text-gray-900 font-medium leading-8">{{ profile.nickname }}</h3>
                        <div class="p-8">
                            <h3 class="mb-2 text-gray-500 base-font-bold">自己紹介</h3>
                            <p :class="{'text-red-400': isNoInput.self_introduction}">{{ profile.self_introduction }}</p>
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
import { Link } from "@inertiajs/inertia-vue3";
import RegularButton from '@/Components/Buttons/RegularButton';
import { commonConst } from '@/Consts/commonConst'
import { reactive, toRefs } from 'vue'
import { messageConst } from '@/Consts/messageConst'
import useCommonAction from '@/Composables/useCommonAction'


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
        const { DEFAULT_PROFILE } = commonConst;
        const { INPUT_SELF_INTRODUCTION } = messageConst;
        const { setDisplayedProfilePath } = useCommonAction();

        let displayedProfilePath = setDisplayedProfilePath(profile.value.profile_image);

        const isNoInput = reactive({
            self_introduction: false,
        })

        if (profile.value.self_introduction === null) {
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
