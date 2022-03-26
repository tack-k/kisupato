<template>
    <div class="flex text-red-500 border border-gray-200 px-6 py-4 rounded relative mb-4 admin-bg-white">
        <div>
          <span class="text-xl inline-block mr-5 align-middle">
            <Fa :icon="faInfoCircle"/>
          </span>
        </div>
        <ul>
            <li v-for="(message, key) in messages" :key="key" class="align-middle mr-8 base-font-bold mb-1.5">{{ message }}</li>
        </ul>
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
    props: {
        messages: Array,
    },
    setup(props) {

        const { messages } = props;

        return {
            faInfoCircle,
            messages,
        }
    }
}
</script>

<style scoped>

</style>
