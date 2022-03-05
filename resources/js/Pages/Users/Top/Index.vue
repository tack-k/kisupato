<template>
    <full-page-layout>
        <template #content>
            <div class="top-image flex items-center justify-center flex-col">
                <h1 class="text-6xl expert-text-white mb-10 base-font-bold">新たな出会いはいつもここから</h1>
                <Link :href="route('resource.index')" class="user-bg rounded mb-12 hover:cursor-pointer">
                    <Fa :icon="faMapMarkedAlt" class="text-9xl text-white p-4"/>
                    <p class="text-center text-white font-bold">地図から探す</p>
                </Link>
                <div class="flex items-center">
                    <div class="flex border-1 rounded-full bg-white border-gray-100">
                        <SearchPlaceModal v-model:checked="form.checked" :areas="areas"/>
                        <div class="relative">
                            <div
                                class="before:h-10 before:w-0.5 before:bg-gray-100 before:absolute before:top-1/2 before:-translate-y-1/2 after:h-10 after:w-0.5 after:bg-gray-100 after:absolute after:top-1/2 after:-translate-y-1/2">
                                <input
                                    class="rounded-full border-0 hover:bg-gray-100 focus:ring-0 py-4 hover:cursor-pointer"
                                    type="text"
                                    @click="toggleTagsOpen" v-model="displayTag" placeholder="タグから探す">
                            </div>
                            <ul v-if="isTagsOpen" v-click-away="onClickOutsideTag"
                                class="border rounded shadow-lg user-bg-white overflow-y-scroll absolute fixed z-50 w-full">
                                <li v-for="(tag, index) in searchTags.value" :key="tag" @click="getSelectedTag"
                                    class="px-2 py-0.5 hover:bg-blue-500 hover:text-white hover:cursor-pointer">{{
                                        tag.name
                                    }}
                                </li>
                            </ul>
                        </div>
                        <div class="flex items-center relative">
                            <div class="">
                                <input
                                    class="rounded-full border-0 hover:bg-gray-100 focus:ring-0 py-4 pr-16 hover:cursor-pointer"
                                    type="text"
                                    v-model="form.keyword" placeholder="キーワード検索">
                            </div>
                            <div class="p-4 bg-red-400 rounded-full absolute right-0.5 hover:cursor-pointer">
                                <Fa :icon="faSearch" class="text-lg text-white"/>
                            </div>
                        </div>
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
                        <template v-for="(profile, key) in profiles" :key="key">
                            <VerticalCard @emitFavorite="handleFavorite" :profile="profile" :isFavorite="isFavorites[profile.expert_id]"/>
                        </template>
                    </div>
                    <div class="mt-16 text-center">
                        <Link href="/" v-if="profiles.length >= MAX_PROFILE_COUNT"
                              class="text-xl base-font-bold user-bg user-text-white px-4 py-2 rounded-full">もっとみる
                        </Link>
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
import { faSearch, faMapMarkedAlt } from "@fortawesome/free-solid-svg-icons"
import Fa from 'vue-fa';
import { useForm, Link } from "@inertiajs/inertia-vue3";
import { computed, ref, toRefs } from "vue";
import { directive } from "vue3-click-away";
import { commonConst } from "@/Consts/commonConst"
import VerticalCard from "@/Components/Cards/VerticalCard";
import { useFavoriteAction } from '@/Composables/useFavoriteAction'

export default {
    name: "Index",
    components: {
        VerticalCard,
        FullPageLayout,
        SearchPlaceModal,
        RegularButton,
        Fa,
        Link,
    },
    props: {
        areas: Object,
        tags: Array,
        profiles: Object,
    },
    directives: {
        ClickAway: directive
    },
    setup(props) {
        const NO_RESULTS = -1
        const MAX_PROFILE_COUNT = 6;
        const { areas, tags, profiles } = toRefs(props);

        const form = useForm({
            checked: [],
            tag: '',
            keyword: '',

        })


        const displayTag = ref("")

        const isTagsOpen = ref(false)
        const toggleTagsOpen = () => {
            isTagsOpen.value = !isTagsOpen.value
        }

        const closeTags = () => isTagsOpen.value = false

        const getSelectedTag = e => {

            if (isNoTag.value) {
                return
            }

            tags.forEach(tag => {
                if (tag.name.indexOf(e.target.innerText) !== NO_RESULTS) {
                    form.tag = tag.id;
                    displayTag.value = tag.name;
                }
            })

            closeTags()
        }


        const searchTags = computed(() => {
            const filteredTags = ref([])

            if (isNoTag.value) {
                isNoTag.value = false;
            }

            tags.forEach(tag => {
                if (tag.name.indexOf(displayTag.value) !== NO_RESULTS) {
                    filteredTags.value.push(tag)
                }
            })

            if (filteredTags.value.length === 0) {
                filteredTags.value.push({
                    'id': '',
                    'name': '該当項目がありません'
                })
                isNoTag.value = true
            }

            return filteredTags
        })

        const isNoTag = ref(false)

        const onClickOutsideTag = () => {
            form.tag = '';
            displayTag.value = '';
            closeTags();
        }

        //お気に入り登録
        let isFavorites = ref([]);
        const { handleFavorite, setIsFavorites } = useFavoriteAction(profiles, isFavorites)
        setIsFavorites()

        return {
            form,
            tags,
            isTagsOpen,
            toggleTagsOpen,
            closeTags,
            getSelectedTag,
            searchTags,
            isNoTag,
            faSearch,
            faMapMarkedAlt,
            areas,
            displayTag,
            onClickOutsideTag,
            profiles,
            MAX_PROFILE_COUNT,
            handleFavorite,
            isFavorites,
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
