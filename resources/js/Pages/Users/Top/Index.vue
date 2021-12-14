<template>
    <full-page-layout>
        <template #content>
            <div class="top-image flex items-center justify-center flex-col" @click.self="closeTagsOpen">
                <h1 class="text-6xl expert-text-white mb-10 base-font-bold">新たな出会いはいつもここから</h1>
                <div class="flex items-center">
                    <div class="flex border-1 rounded-full bg-white border-gray-100">
                        <SearchPlaceModal v-model:checked="form.checked"/>
                        <div class="relative">
                            <input type="text" @click="toggleTagsOpen" v-model="form.tag" placeholder="タグを選ぶ">
                            <ul v-if="isTagsOpen" @click.self="closeTagsOpen"
                                class="border rounded shadow-lg user-bg-white overflow-y-scroll absolute fixed z-50 w-full">
                                <li v-for="(tag, index) in searchTags.value" :key="tag" @click="getSelectedTag(index)"
                                    class="px-2 py-0.5 hover:bg-blue-500 hover:text-white hover:cursor-pointer">{{ tag }}
                                </li>
                            </ul>
                        </div>
                        <div class="">
                            <input class="rounded-r-full" type="text" v-model="form.keyword" placeholder="キーワード検索">
                        </div>
                    </div>
                    <div class="ml-10">
                        <regular-button>検索</regular-button>
                    </div>
                </div>
            </div>
            <div class="w-full bg-white p-12 pt-40">
                <div class="flex justify-center items-center flex-col mb-40">
                    <p class="pl-4 mb-6">お知らせ</p>
                    <table class="table-auto">
                        <tbody>
                        <tr v-for="value in 3" :key="value" class="user-hover">
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
                                            <img alt="profile" :src="'/images/users/profile.png'"
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
import RegularButton from "@/Components/Buttons/RegularButton";
import {faHeart} from "@fortawesome/free-solid-svg-icons"
import Fa from 'vue-fa';
import {useForm} from "@inertiajs/inertia-vue3";
import {computed, ref} from "vue";

export default {
    name: "Index",
    components: {
        FullPageLayout,
        SearchPlaceModal,
        RegularButton,
        Fa,
    },
    setup() {
        const NO_RESULTS = -1

        let form = useForm({
            checked: [],
            tag: '',
            keyword: '',

        })

        const tags = ref(['農業', '地域づくり', '林業士', '建築士'])
        const isTagsOpen = ref(false)
        const toggleTagsOpen = () => {
            isTagsOpen.value = !isTagsOpen.value
        }

        const closeTagsOpen = () => isTagsOpen.value = false

        const getSelectedTag = (index) => {
            form.tag = tags.value[index]
            closeTagsOpen()
        }


        const searchTags = computed(() => {
            const filteredTags = ref([])

            tags.value.forEach(tag => {
                if (tag.indexOf(form.tag) !== NO_RESULTS) {
                    filteredTags.value.push(tag)
                }
            })

            if (filteredTags.value.length === 0) {
                filteredTags.value.push('該当項目がありません')
                isNoTag.value = true
            }

            return filteredTags
        })

        const isNoTag = ref(false)


        return {
            faHeart,
            form,
            tags,
            isTagsOpen,
            toggleTagsOpen,
            closeTagsOpen,
            getSelectedTag,
            searchTags,
            isNoTag,
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
