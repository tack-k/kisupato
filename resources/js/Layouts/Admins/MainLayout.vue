<template>
    <Header/>
    <div class="flex">
        <sideBar />
        <div class="container p-4 lg:p-40">

            <FlashMessage />

            <div class="container mx-auto pt-4 py-16 ">

                <slot name="content" />

            </div>
        </div>
    </div>
</template>

<script>
import Header from "@/Layouts/Admins/Header";
import SideBar from "@/Layouts/Admins/SideBar";
import FlashMessage from "@/Components/Messages/FlashMessage";

export default {
    name: "MainLayout",
    components: {
        Header,
        SideBar,
        FlashMessage,
    },
    setup() {

        return {

        }
    }
}
</script>

<style scoped>

</style>
