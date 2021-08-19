<template>
    <select v-model="modelValue" class="block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" @change="updateValue" >
        <option v-for="(option, index) in options" :value="option.id" :selected="modelValue === '2'" :key="index" >{{ option.name }}</option>
    </select>
</template>

<script>

import { ref } from "vue";

export default {
    name: "Select",
    props: {
        options: Array,
        modelValue: String
    },

    setup(props, { emit }) {

        const options = [{id: '', name: '選択してください'}, ...props.options]
        const modelValue = ref(props.modelValue)
        const updateValue = e => emit('update:modelValue', e.target.value)

      return {
          options,
          updateValue,
          modelValue,
      }
    },

}
</script>

<style scoped>

</style>
