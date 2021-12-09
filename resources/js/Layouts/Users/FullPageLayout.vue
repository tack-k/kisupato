<template>
    <Header/>
    <div class="overflow-y-scroll h-screen w-full">
        <slot name="content"/>
    </div>
</template>

<script>
import Header from '@/Layouts/Users/Header'

export default {
    name: "FullPageLayout",
    components: {
        Header,
    }
}
</script>

<style scoped>

</style>
