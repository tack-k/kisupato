<template>
    <div class="container mx-auto shadow-lg rounded-lg max-w-md hover:shadow-2xl transition duration-300 p-4">
        <div class="flex items-center mb-5">
            <div class="w-1/2">
                <img :src="'/images/users/profile.png'" alt="" class="rounded-full w-20 h-20">
            </div>
            <div class="w-1/2">
                <p class="mb-2">山田　次郎</p>
                <p class="mb-2">2020.01.23</p>
                <p>★★★★☆</p>
            </div>
        </div>
        <div>
            <p>レビュー レビュー レビュー レビュー レビュー レビュー レビュー レビュー レビュー レビュー レビュー レビュー レビュー レビュー レビュー レビュー レビュー レビュー レビュー レビュー レビュー...</p>
        </div>
        <div class="text-right">
            <span class="text-blue-300 user-hover">続きを読む</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "ReviewCard"
}
</script>

<style scoped>

</style>
