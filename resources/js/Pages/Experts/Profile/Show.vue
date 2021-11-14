<template>
    <my-page-layout>
        <template #content>
            <section class="mb-10">
                <div class="flex mb-4">
                    <h2 class="base-font-m base-font-bold mr-10">【公開中】</h2>
                    <regular-button class="expert-bg-active">編集する</regular-button>
                </div>
                <div class="flex flex-col items-center md:flex-row">
                    <div class="flex flex-col items-center mb-8 md:mb-0">
                        <div class="mb-3">
                            <img
                                class="w-auto mx-auto rounded-full"
                                src="https://i.pravatar.cc/150?img=31"
                                alt=""
                            />
                        </div>
                        <p>ニックネーム</p>
                    </div>
                    <p class="md:ml-8">自己紹介文 テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト</p>
                </div>
            </section>

            <section class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">活動タイトル</h2>
                <p>テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト</p>
            </section>

            <section class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">活動写真</h2>
                <div class="w-full flex">
                    <!-- main -->
                    <main class="w-full">
                        <div class="grid grid-cols-4 gap-4">
                            <div v-for="image in 10" :key="image"
                                 class="col-span-4 sm:col-span-4 md:col-span-2 lg:col-span-1 xl:col-span-1 flex flex-col items-center">
                                <div class="bg-white rounded-lg mt-5">
                                    <img :src="'/images/sample-image1.jpeg'" class="rounded-md" alt=""/>
                                </div>
                            </div>
                            <!-- end cols -->
                        </div>
                    </main>
                </div>
            </section>

            <section class="mb-10">
                <h2 class="base-font-m base-font-bold mb-4">提供技術</h2>
                <div v-for="skill in 3" :key="skill" class="mb-6">
                    <div class="mb-4">
                        <h3 class="base-font-s base-font-bold mb-2">タイトル</h3>
                        <p>テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト</p>
                    </div>
                    <div>
                        <h3 class="base-font-s base-font-bold mb-2">内容</h3>
                        <p>テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト
                            テキスト
                            テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト テキスト</p>
                    </div>
                </div>

            </section>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from "@/Layouts/Experts/MyPageLayout";
import {Link} from "@inertiajs/inertia-vue3";
import RegularButton from "@/Components/Buttons/RegularButton";

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
        console.log(props.profile)
        return {

        }
    }
}
</script>

<style scoped>

</style>
