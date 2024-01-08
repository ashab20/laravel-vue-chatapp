<script setup>
import { getAllUsers } from '@/lib/users.js';
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref,onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3';
const reciever_id = ref([]);
const message = ref([]);

// onMounted(() => {
//     users = getAllUsers();
//     console.log(users);
// });


defineProps({
    createRoom: {
        type: Boolean,
    },
    closeModal:{
        type:Function
    },
    users:{
        typea:Array
    }
});



const form = useForm({
    message: '',
    reciever_id: ''
});


const submit = () => {
    form.post(route('chats.store'), {
        onFinish: () => form.reset(),
    });
};

</script>
<template lang="">
    <Modal :show="createRoom" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Create New Chat Room
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Please Select an user to create new room
            </p>

            <form class="px-2 w-full justify-center mx-auto" style="bottom: 0;" @submit.prevent="submit">
                        <div class="grid items-center">
                            <select name="" id="" class="mt-4 block w-3/4 p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 "
                            ref="reciever_id"
                            v-model="form.reciever_id"
                            >
                                <option value="">Select a user</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">{{user.name}}</option>
                            </select>
                            <input
                            ref="message"
                            v-model="form.message"
                            type="search" id="search" class="mt-4 block w-3/4 p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 " placeholder="write to your friend" required>

                        </div>


            <div class="mt-6 flex justify-end">
                <DangerButton @click="closeModal"> Cancel </DangerButton>

                <PrimaryButton
                    class="ms-3"
                    :class="{ 'opacity-25': processing }"
                    :disabled="processing"
                    @click="deleteUser"
                >
                    Create
                </PrimaryButton>
            </div>
        </form>
        </div>
    </Modal>
</template>
