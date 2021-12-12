<template>
    <full-page-layout>
        <template #content>
            <div class="top-image flex items-center justify-center flex-col">
                <h1 class="text-6xl expert-text-white mb-10 base-font-bold">新たな出会いはいつもここから</h1>
                <div>
                    <SearchPlaceModal v-model:checked="form.checked"/>
                    <input type="text">
                    <input type="text">
                    <input type="text">
                </div>
            </div>
            <div class="w-full bg-white p-12 pt-40">
                <div class="flex justify-center items-center flex-col mb-40">
                    <p class="pl-4 mb-6">お知らせ</p>
                    <table class="table-auto">
                        <tbody>
                        <tr v-for="value in 3" key="value" class="user-hover">
                            <td class="px-4 py-0.5">2022/01/01</td>
                            <td class="px-4 py-0.5">サービス一時停止のお知らせ</td>
                            <td class="px-4 py-0.5">日曜日の午前１時から午前３時までの間はサービスを停止いたします。ご不便をおかけ・・・</td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mb-40">
                    <div class="header flex items-end justify-between my-4">
                        <h2 class="text-4xl font-bold text-gray-800">
                            新着の人材
                        </h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-12">
                        <div class="overflow-hidden shadow-lg rounded-lg h-90 w-60 md:w-80 cursor-pointer m-auto"
                             v-for="value in 4" key="value">
                            <a href="#" class="w-full block h-full">
                                <img alt="blog photo" :src="'/images/users/activity.jpeg'"
                                     class="max-h-40 w-full object-cover"/>
                                <div class="bg-white dark:bg-gray-800 w-full p-4">
                                    <p class="text-indigo-500 text-md font-medium">
                                        Video
                                    </p>
                                    <p class="text-gray-800 dark:text-white text-xl font-medium mb-2">
                                        Work at home
                                    </p>
                                    <p class="text-gray-400 dark:text-gray-300 font-light text-md">
                                        Work at home, remote, is the new age of the job, every person can work at
                                        home....
                                    </p>
                                    <div class="flex items-center mt-4">
                                        <a href="#" class="block relative">
                                            <img alt="profil" :src="'/images/users/profile.png'"
                                                 class="mx-auto object-cover rounded-full h-10 w-10 "/>
                                        </a>
                                        <div class="flex flex-col justify-between ml-4 text-sm">
                                            <p class="text-gray-800 dark:text-white">
                                                Jean Jacques
                                            </p>
                                            <p class="text-gray-400 dark:text-gray-300">
                                                20 mars 2029 - 6 min read
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="header flex items-end justify-between my-4">
                        <h2 class="text-4xl font-bold text-gray-800 ">
                            新着イベント
                        </h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-12">
                        <div class="overflow-hidden shadow-lg rounded-lg h-90 w-60 md:w-80 cursor-pointer m-auto"
                             v-for="value in 4" :key="value">
                            <a href="#" class="w-full block h-full">
                                <div class="relative">
                                    <Fa :icon="faHeart" class="text-lg absolute right-2 top-2 text-red-400"/>
                                    <img alt="blog photo" :src="'/images/users/activity.jpeg'"
                                         class="max-h-40 w-full object-cover"/>
                                </div>
                                <div class="bg-white dark:bg-gray-800 w-full p-4">
                                    <p class="text-indigo-500 text-md font-medium">
                                        Video
                                    </p>
                                    <p class="text-gray-800 dark:text-white text-xl font-medium mb-2">
                                        Work at home
                                    </p>
                                    <p class="text-gray-400 dark:text-gray-300 font-light text-md">
                                        Work at home, remote, is the new age of the job, every person can work at
                                        home....
                                    </p>
                                    <div class="flex items-center mt-4">
                                        <a href="#" class="block relative">
                                            <img alt="profil" :src="'/images/users/profile.png'"
                                                 class="mx-auto object-cover rounded-full h-10 w-10 "/>
                                        </a>
                                        <div class="flex flex-col justify-between ml-4 text-sm">
                                            <p class="text-gray-800 dark:text-white">
                                                Jean Jacques
                                            </p>
                                            <p class="text-gray-400 dark:text-gray-300">
                                                20 mars 2029 - 6 min read
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </template>
    </full-page-layout>
</template>

<script>
import FullPageLayout from "@/Layouts/Users/FullPageLayout";
import SearchPlaceModal from "@/Layouts/Users/SearchPlaceModal";
import {faHeart} from "@fortawesome/free-solid-svg-icons"
import Fa from 'vue-fa';
import {useForm} from "@inertiajs/inertia-vue3";

export default {
    name: "Index",
    components: {
        FullPageLayout,
        SearchPlaceModal,
        Fa,
    },
    setup() {

        let form = useForm({
          checked : []
        })


        return {
            faHeart,
            form,
        }
    }
}
</script>

<style scoped lang="scss">
.top-image {
    background-image: url('/images/users/top.jpg');
    background-size: cover;
    height: 800px;
}
</style>
