<template>
    <Header/>
    <div class="overflow-y-scroll h-screen w-full">
        <flash-message/>
        <slot name="content"/>
    </div>
</template>

<script>
import Header from '@/Layouts/Users/Header'
import FlashMessage from "@/Components/Messages/FlashMessage";

export default {
    name: "FullPageLayout",
    components: {
        FlashMessage,
        Header,
    }
}
</script>

<style scoped>

</style>
