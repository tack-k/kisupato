<template>
    <label class="font-medium text-sm text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
        <span class="text-red-500 required-dot pl-1" >*</span>
    </label>
</template>

<script>
    export default {
        props: ['value'],
        name: 'LabelRequired'
    }
</script>
