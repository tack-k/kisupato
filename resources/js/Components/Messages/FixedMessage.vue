<template>
    <div class="text-red-500 border border-gray-200 px-6 py-4 rounded relative mb-4 admin-bg-white">
      <span class="text-xl inline-block mr-5 align-middle">
        <Fa :icon="faInfoCircle"/>
      </span>
        <p class="inline-block align-middle mr-8 base-font-bold mt-1.5">
            <slot></slot>
        </p>
    </div>
</template>

<script>
import Fa from 'vue-fa';
import { faInfoCircle } from '@fortawesome/free-solid-svg-icons';

export default {
    name: "FixedMessage",
    components: {
        Fa
    },
    setup() {

        return {
            faInfoCircle
        }
    }
}
</script>

<style scoped>

</style>
