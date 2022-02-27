<template>
    <textarea @input="emitInputValue" class="base-form rounded-sm" :value="modelValue"></textarea>
</template>

<script>
import {vu} from 'vue'

export default {
    name: "TextArea",
    props: {
        modelValue: String,
    },
    emits: ['update:modelValue'],
    setup(props, {emit}) {

        const emitInputValue = e => emit('update:modelValue', e.target.value)


        return {
            emitInputValue,
        }
    }
}
</script>

<style scoped>

</style>
