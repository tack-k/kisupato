<template>
    <div class="flex relative w-80 items-center">
        <span class="text-center absolute left-4"><Fa :icon="faSearch" /></span>
        <input v-model="keyword" :placeholder="placeholder" @input="emitInputValue" type="text" class="base-form rounded-sm w-full pl-10"/>
    </div>
</template>

<script>
import Fa from "vue-fa";
import {ref} from "vue";
import {faSearch} from "@fortawesome/free-solid-svg-icons";

export default {
    name: "SquareSearch",
    components: {
        Fa
    },
    props: {
        placeholder: String,
        modelValue: String

    },

    setup(props, { emit }) {
        let keyword = ref('')
        const placeholder = props.placeholder

        const emitInputValue = e => emit('update:modelValue', e.target.value)


        return {
            faSearch,
            keyword,
            placeholder,
            emitInputValue,
        }
    }

}
</script>

<style scoped>

</style>
