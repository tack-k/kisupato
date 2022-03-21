<template>
    <button class="bg-yellow-500 text-white active:bg-yellow-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-lg outline-none focus:outline-none ease-linear transition-all duration-150" :type="type">
        <slot>ボタン</slot>
    </button>
</template>

<script>
export default {
    name: "RegularButton",
    props: {
        type: {
            type: String,
            default: 'submit',
        }
    },

    setup(props) {
        const type = props.type

        return {
            type
        }
    }

}
</script>

<style scoped>

</style>
