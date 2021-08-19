<template>
    <button class="text-pink-500 bg-transparent border border-solid border-pink-500 hover:bg-pink-500 hover:text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">
        <slot>ボタン</slot>
    </button>

</template>

<script>
export default {
    name: "OutlineButton"
}
</script>

<style scoped>

</style>
