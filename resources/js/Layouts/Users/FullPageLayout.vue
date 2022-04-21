<template>
    <Header/>
    <div class="w-full bg-white">
        <flash-message/>
        <slot name="content"/>
    </div>
    <Footer/>
</template>

<script>
import Header from '@/Layouts/Users/Header'
import FlashMessage from "@/Components/Messages/FlashMessage";
import Footer from "@/Layouts/Users/Footer";

export default {
    name: "FullPageLayout",
    components: {
        Footer,
        FlashMessage,
        Header,
    }
}
</script>

<style scoped>

</style>
