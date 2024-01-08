<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref,onMounted,watch } from "vue";
import axios from 'axios'
import { Head ,Link} from '@inertiajs/vue3';
import ChatBoox from './ChatBox.vue';
import NewChatRoom from './NewChatRoom.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';


const createRoom = ref(false);
const messages = ref([]);
const processing = ref(false);

const {rooms,users,room_id} = defineProps({rooms:[],users:[],room_id:''});

// const fetchMessages = async()=> {
// 	    axios.get(`/chat/${room_id}`).then(response => {
// 	        messages.value = response.data;
// 	});

//     // console.log(messages.value);
// }

const newChatRoom = () => {
    createRoom.value = true;

    // nextTick(() => passwordInput.value.focus());
};

const closeModal = () => {
    createRoom.value = false;

    // form.reset();
};
// console.log($page.props.route.params.id );

// Echo.private('chat-app')
//     .listen('SendMessage', (e) => {
//     messages.value.push({
//         message: e.message.message,
// 	    user: e.user
//     });
// })

// watch(()=>{
//     fetchMessages()
// });
// onMounted(()=>{
//     messages.value = dataMessage;
//     fetchMessages()
// });

</script>
<template>
    <Head title="Chat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Chat</h2>
        </template>
        <section class="max-w-7xl mx-auto sm:px-6 lg:px-8  flex">
            <div class="w-2/5 bg-orange-200 h-full border-r-2" style="background-color:rgb(252, 236, 252);width: 30%;height: 85vh;">
                <h4>Chat Room List</h4>
                <ul>
                    <li v-if="rooms.length > 0" v-for="room in rooms" :key="room.id">
                        <ResponsiveNavLink :href="route('chats.ChatBox',{ id: room.id })" class="flex p-4 justify-start items-center cursor-pointer">
                            <img src="https://www.svgrepo.com/show/384674/account-avatar-profile-user-11.svg" alt="ashabuddin" width="50">
                            <h5 class="p-2">{{ $page.props.auth.user.name == room?.sender_name ? room?.receiver_name : room?.sender_name }}</h5>
                            <span class="p-2 rounded-sm bg-red-300">1</span>
                        </ResponsiveNavLink>
                    </li>
                    <li v-else>
                        <a href="" class="flex p-4 justify-start items-center">
                            <span class="p-2 rounded-sm bg-red-300">No Data Found!</span>
                        </a>
                    </li>
                </ul>
            </div>
            <ChatBoox v-if="messages" :room_id="room_id"/>
            <div v-else class="mt-16 p-4 justify-center items-center text-center">
                <h4>
                    Please Create New Chat Room
                </h4>
                <SecondaryButton @click="newChatRoom">Create New Room</SecondaryButton>
                <NewChatRoom :createRoom="createRoom" :closeModal="closeModal" :users="users"/>
            </div>
        </section>
    </AuthenticatedLayout>
</template>

