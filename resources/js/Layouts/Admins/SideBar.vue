<template>
    <div class="bg-gray-200 font-sans">
            <div class="w-64 h-screen bg-white">
                <div class="flex items-center justify-center pt-10">
                    <img class="h-6" src="https://premium-tailwindcomponents.netlify.app/assets/svg/tailwindcomponent-dark.svg">
                </div>
                <nav class="mt-10">
                    <div x-data="{ open: false }" v-for="sideBarList in sideBarLists" key="sideBarList.title">
                        <button @click="open[sideBarList.id] = !open[sideBarList.id]" class="w-full flex justify-between items-center py-3 px-6 text-gray-600 cursor-pointer hover:bg-gray-100 hover:text-gray-700 focus:outline-none">
                        <span class="flex items-center">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 11H5M19 11C20.1046 11 21 11.8954 21 13V19C21 20.1046 20.1046 21 19 21H5C3.89543 21 3 20.1046 3 19V13C3 11.8954 3.89543 11 5 11M19 11V9C19 7.89543 18.1046 7 17 7M5 11V9C5 7.89543 5.89543 7 7 7M7 7V5C7 3.89543 7.89543 3 9 3H15C16.1046 3 17 3.89543 17 5V7M7 7H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>

                            <span class="mx-4 font-medium">{{sideBarList.title}}</span>
                        </span>

                            <span>

                            <svg v-if="sideBarList.subtitle !== null" class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path v-show="!open[sideBarList.id]" d="M9 5L16 12L9 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path v-show="open[sideBarList.id]" d="M19 9L12 16L5 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                        </span>
                        </button>

                        <div v-show="open[sideBarList.id]" class="bg-gray-100" v-for="item in sideBarList.subtitle">
                            <a class="py-2 px-16 block text-sm text-gray-600 hover:bg-blue-500 hover:text-white" href="#">{{item}}</a>
                        </div>
                    </div>
                </nav>

                <div class="absolute bottom-0 my-8">
                    <a class="flex items-center py-2 px-8 text-gray-700 hover:text-gray-600" href="#">
                        <img class="h-6 w-6 rounded-full mr-3 object-cover" src="https://lh3.googleusercontent.com/a-/AOh14Gi0DgItGDTATTFV6lPiVrqtja6RZ_qrY91zg42o-g" alt="avatar">
                        <span>Khatabwedaa</span>
                    </a>
                </div>
            </div>
        </div>
</template>

<script>
export default {
    name: "SideBar",

    data() {
        return {
            open: [],
        }
    },

    props: {
        sideBarLists: Object,
    },

    computed: {
        setOpen() {
            for (const sideBarList in this.sideBarLists) {
                this.open.push(false);
            }
            return console.log(this.open)
        }
    }

}


</script>

<style scoped>

</style>
