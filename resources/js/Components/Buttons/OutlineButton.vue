<template>
    <button class="text-yellow-500 bg-transparent border border-solid border-yellow-500 hover:border-gray-500 hover:text-gray-500 hover:shadow-md active:bg-gray-600 font-bold uppercase text-xs px-4 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">
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
