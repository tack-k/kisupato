<template>
    <li class="py-3 sm:py-4 px-1 sm:px-12 hover:bg-gray-50 hover:cursor-pointer">
        <div class="flex items-center space-x-3">
            <div class="w-2/12">
                <img class="w-8 h-8 rounded-full" :src="displayProfilePath + chatroom.profile_image" alt="Neil image">
            </div>
            <p class="w-4/12 break-words items-center font-bold text-base font-semibold text-gray-900 dark:text-white">
                {{ chatroom.nickname }}
            </p>
            <div class="w-3/12">
                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                    依頼完了日
                </p>
                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                    {{ chatroom.request_finished_at }}
                </p>
            </div>
            <div class="w-3/12">
                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                    レビュー可能日
                </p>
                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                    {{ chatroom.request_enable_day }}
                </p>
            </div>
        </div>
    </li>
</template>

<script>
import { toRefs } from 'vue'
import { commonConst } from '@/Consts/commonConst';


export default {
    name: "ReviewYetCard",
    props: {
        chatroom: Object,
        displayProfilePath: String,
    },
    setup(props) {

        const { chatroom, displayProfilePath } = toRefs(props);



        return {
            chatroom,
            displayProfilePath,
        }
    }
}
</script>

<style scoped>

</style>
