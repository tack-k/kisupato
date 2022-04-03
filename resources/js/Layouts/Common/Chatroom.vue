<template>
        <div class="flex sm:items-center justify-between py-3 border-b-2 border-gray-200">
            <div class="flex items-center space-x-4">
                <img :src="profilePath + profile.profile_image" alt="" class="w-10 sm:w-16 h-10 sm:h-16 rounded-full">
                <div class="flex flex-col leading-tight">
                    <div class="text-2xl mt-1 flex items-center">
                        <span class="text-gray-700 mr-3">{{ profile.nickname }}</span>
                        <span class="text-green-500">
                                  <svg width="10" height="10">
                                     <circle cx="5" cy="5" r="5" fill="currentColor"></circle>
                                  </svg>
                               </span>
                    </div>
                    <span class="text-lg text-gray-600">{{ profile.self_introduction }}</span>
                </div>
            </div>
        </div>
        <div id="messages" class="flex flex-col space-y-4 p-3 overflow-y-scroll scrolling-touch h-screen" ref="messageRef">
            <div class="chat-message" v-for="(message, index) in messages" :key="index">
                <div class="flex items-end" :class="{'justify-end': isLogin(message)}">
                    <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start" :class="{'user-right': isLogin(message)}">
                        <div>
                            <span class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600" :class="{'user-message': isLogin(message)}">{{ message.message }}</span>
                        </div>
                    </div>
                    <img v-if="!isLogin(message)" :src="profilePath + profile.profile_image" alt="My profile" class="w-6 h-6 rounded-full order-1">
                </div>
            </div>
        </div>
        <div v-show="canMessage" class="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0">
            <div class="relative flex">
                <input v-model="newMessage" type="text" class="w-full px-6 border-gray-300 border-2 focus:border-gray-300 text-gray-600 bg-gray-200 rounded-full py-3">
                <button v-show="isInput" @click="submit" type="button" class="inline-flex items-center justify-center rounded-full h-12 w-12 -ml-4 transition duration-500 ease-in-out text-white bg-blue-500 hover:bg-blue-400 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 transform rotate-90">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
                    </svg>
                </button>
            </div>
        </div>
</template>

<script>
import { computed, nextTick, onMounted, ref, toRefs, watch } from 'vue'
import { usePage } from '@inertiajs/inertia-vue3'
import { commonConst } from '@/Consts/commonConst'

export default {
    name: "Chatroom",
    props: {
        messages: Object,
        chatroom: Object,
        profile: Object,

    },
    setup(props) {
        const user = computed(() => usePage().props?.value.auth.user);
        const expert = computed(() => usePage().props?.value.auth.expert);
        const { messages, chatroom, profile } = toRefs(props);

        const {
            PROFILE_PATH,
            REQUEST_FINISHED,
            USER_PROFILE_PATH,
            REQUEST_CANCELED,
            DEFAULT_PROFILE,
            COMMON_PATH,
        } = commonConst;

        let profilePath = ''
        if(expert.value === null) {
            profilePath = PROFILE_PATH
        } else {
            if(profile.value.profile_image === DEFAULT_PROFILE) {
                profilePath = COMMON_PATH
            } else {
                profilePath = USER_PROFILE_PATH
            }
        }

        const newMessage = ref('')

        //ブロードキャスト受信設定
        const channel = Echo.channel('message-channel.' + chatroom.value.id);
        channel.listen('.message-event', function (data) {
            console.log(data)
            messages.value.push(data.message);
        });

        //メッセージの送信
        const submit = () => {
            const params = {
                chatroom_id: chatroom.value.id,
                message: newMessage.value,
                user_id: user.value?.id,
                expert_id: expert.value?.id
            }

            const url = expert.value === null ? 'message.update' : 'expert.message.update';

            axios.post(
                route(url),
                params
            ).then(res => {
                messages.value.push(res.data)

            }).catch(res => {
                alert('データの登録に失敗しました。時間をおいてから再度お試しください')
            })
            newMessage.value = '';
        }

        //メッセージ入力時送信ボタンを表示
        const isInput = ref(false);
        watch(newMessage, () => {
            isInput.value = newMessage.value.length !== 0;
        })

        //メッセージがログイン中の人物かを判定
        const isLogin = (message) => {
            //ログインがユーザーの場合
            if (expert.value === null) {
                return message?.user_id !== null;
                //ログインが専門人材の場合
            } else if (user.value === null) {
                return message?.expert_id !== null;
            }
        }

        //メッセージ下部にスクロール
        const messageRef = ref(null);
        onMounted(() => {
            const target = messageRef.value;
            target.scrollTop = target.scrollHeight

            watch(messages.value, () => {
                nextTick(() => target.scrollTop = target.scrollHeight)
            })

        })

        //メッセージ送信可否
        const canMessage = ref(true);
        if (chatroom.value.request_status === REQUEST_CANCELED || chatroom.value.request_status === REQUEST_FINISHED) {
            canMessage.value = false;
        }

        return {
            newMessage,
            messages,
            submit,
            isLogin,
            messageRef,
            profile,
            profilePath,
            canMessage,
            isInput,
        }
    }

}
</script>

<style scoped lang="scss">
.user-right {
    @apply items-end order-1
}

.user-message {
    @apply bg-blue-600 text-white rounded-lg rounded-br-none
}

input:focus {
    outline: none;
    box-shadow: none;
}
</style>
