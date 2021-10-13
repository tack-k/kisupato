<template>
    <my-page-layout>
        <template #content>
            <section>
                <h2 class="base-font-m">プロフィールを編集する</h2>
                <div>
                    <img src="" alt="">
                    <div>
                        <p>ニックネーム</p>
                        <p>テキスト テキスト テキスト テキスト テキスト テキスト </p>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="base-font-m">◯◯様へのお知らせ</h2>
                <ul>
                    <li>2021/10/03 テキスト テキスト テキスト テキスト テキスト テキスト</li>
                    <li>2021/10/02 テキスト テキスト テキスト テキスト テキスト テキスト</li>
                    <li>2021/10/01 テキスト テキスト テキスト テキスト テキスト テキスト</li>
                </ul>
            </section>

            <section>
                <h2 class="base-font-m">おなたにおすすめの人材</h2>

            </section>
        </template>
    </my-page-layout>
</template>

<script>
import MyPageLayout from "@/Layouts/Experts/MyPageLayout";

export default {
    name: "Top",
    components: {MyPageLayout}
}
</script>

<style scoped>

</style>
