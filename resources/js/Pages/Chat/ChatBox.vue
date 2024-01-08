<script setup>
import { ref,onMounted } from 'vue';
import { useForm,usePage} from '@inertiajs/vue3';
const message = ref('');

const { room_id } = defineProps(['room_id']);
const messages = ref([]);
const roomId = ref(room_id || '');



const fetchMessages = async()=> {
	   const response = await axios.get(`/chat-message/${roomId.value}`);
            // console.log(response.data)
            messages.value = response.data.messages;


}

const form = useForm({
    message: '',
    room_id: roomId.value
});

onMounted(() => {
    roomId.value = room_id
    if(roomId.value){
        fetchMessages();

    }
    console.log(messages.value);
});


const addMessage = async()=> {
    axios.post('/send-message', form).then(response => {
        messages.value.push(response.daat);
        message.value = ''
        console.log(response.data);
    });
    form.reset()
}

// const submit = () => {
//     form.post(route('send.msg'), {
//         onFinish: () => form.reset(),
//     });
// };

</script>

<template>
     <div class="w-full bg-green-100 h-full" style="background-color: rgb(213, 244, 234);">
                <div class="items-end relative" style="height: 85vh;">
                    <div class="bg-green-900 w-full p-3 flex items-center" style="background-color: burlywood;">
                        <img class="py-3" src="https://www.svgrepo.com/show/384674/account-avatar-profile-user-11.svg" alt="ashabuddin" width="50">
                        <h4 class="px-3">Ashab Uddin</h4>
                    </div>
                    <ul  class="flex overflow-y-scroll" style="height: 70vh;flex-direction: column-reverse;">
                        <li :class="{'justify-end': msg?.sender_id == $page.props.auth.user.id }" class=" w-full my-2 flex items-center justify-start" v-for="msg in messages" :key="msg?.id">
                            <img src="https://www.svgrepo.com/show/384674/account-avatar-profile-user-11.svg" alt="ashabuddin" width="50">
                            <p class="px-3 dark:bg-yello-500" :class="{'dark:bg-green-300':msg?.sender_id == $page.props.auth.user.id }" > {{ msg?.message }}</p>
                        </li>
                    </ul>
                    <form class="px-2 absolute w-full" style="bottom: 0;" @submit.prevent="submit">
                        <div class="flex items-center">
                            <!-- <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div> -->
                            <input
                            ref="message"
                            v-model="form.message"
                            type="search" id="search" class="block w-3/4 p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 " placeholder="write to your friend" required>
                            <button type="button" class="w-1/4 text-dark end-2.5 bottom-2.5 dark:bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2"  @click="addMessage">Send</button>
                        </div>
                    </form>
                </div>
            </div>
</template>
