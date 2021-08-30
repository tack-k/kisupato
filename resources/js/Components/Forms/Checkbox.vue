<template>
    <input type="checkbox" :value="value" v-model="proxyChecked"
           class="rounded-sm border-gray-400 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
</template>

<script>
import {computed, ref} from "vue";

export default {
     emits: ['update:checked'],

    props: {
        checked: {
            type: [Array, Boolean],
            default: false,
        },
        value: {
            default: null,
        },
    },
    // setup(props, { emit }) {
    //     const value = props.value
    //
    //     const proxyChecked = computed({
    //         get: () => props.checked,
    //         set: val => {
    //             emit('update:checked', val)
    //         }
    //
    //     })
    //
    //     return {
    //         value,
    //         proxyChecked,
    //     }
    // },

    computed: {
        proxyChecked: {
            get() {
                return this.checked;
            },

            set(val) {
                this.$emit("update:checked", val);
            },
        },
    },
}
</script>
