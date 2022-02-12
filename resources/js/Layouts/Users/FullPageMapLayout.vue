<template>
    <Header class="fixed-header h-16 w-full z-20"/>
    <div class="overflow-y-scroll h-screen w-full">
        <slot name="content"/>
    </div>
</template>

<script>
import Header from "@/Layouts/Users/Header";

export default {
    name: "FullPageMapLayout",
    components: {
        Header,
    }
}
</script>

<style scoped>
.fixed-header {
    position: fixed !important;
}

</style>
