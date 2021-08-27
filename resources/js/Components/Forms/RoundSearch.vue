<template>
    <div class="flex relative w-80 items-center mb-3 ml-auto">
        <button type="submit" class="text-center absolute left-4 hover:cursor-pointer"><Fa :icon="faSearch" /></button>
        <input v-model="keyword" :placeholder="placeholder" @input="emitInputValue" type="text" class="base-form rounded-full w-full pl-10"/>
    </div>
</template>

<script>
import Fa from "vue-fa";
import { faSearch } from "@fortawesome/free-solid-svg-icons";
import { ref } from "vue";
import Button from "@/Components/Button";

export default {
    name: "SearchInput",
    components: {
        Button,
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
