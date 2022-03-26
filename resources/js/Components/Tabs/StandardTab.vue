<template>
    <div style='border-bottom: 2px solid #eaeaea'>
        <div class='flex cursor-pointer'>
            <Link :href="route(tab.url)" v-for="(tab, key) in tabs" :key="key" :class="{'bg-gray-200': currentTab === key}" @click="currentTab = key" class='py-2 px-6 bg-white rounded-t-lg hover:bg-gray-100'>{{ tab.title }}</Link>
        </div>
    </div>
</template>

<script>
import { ref, toRefs } from 'vue'
import { Link } from '@inertiajs/inertia-vue3';

export default {
    name: "StandardTab",
    components: {
        Link
    },
    props: {
        tabs: Object,
        active: String,
    },
    setup(props) {

        const { tabs, active } = toRefs(props);

        const currentTab = active.value;

        return {
            tabs,
            currentTab,
        }
    }
}
</script>

<style scoped>

</style>
