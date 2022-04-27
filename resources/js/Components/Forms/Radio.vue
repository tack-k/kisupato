<template>
    <div class="inline-flex items-center">
        <template v-for="(option, key) in options" :key="key">
            <input :value="option.value" @change="updateValue" type="radio" name="radio" class="form-radio h-5 w-5 text-gray-600" :id="option.value" :checked="checked(option.value)"><label :for="option.value" class="ml-2 mr-4 text-gray-700">{{ option.name }}</label>
        </template>
    </div>
</template>

<script>
import { toRefs } from 'vue'

export default {
    name: "Radio",
    props: {
        options: Array,
        modelValue: String,
        checked: {
            type: Function,
            default: null,
        }
    },
    setup(props, { emit }) {
        const { options } = toRefs(props);
        const updateValue = e => emit('update:modelValue', e.target.value)

        return {
            updateValue,
            options,
        }
    }
}
</script>

<style scoped>

</style>
