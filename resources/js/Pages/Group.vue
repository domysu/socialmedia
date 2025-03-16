<script setup>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { defineProps, ref, computed } from "vue";
import { usePage, router } from "@inertiajs/vue3";
import axiosClient from "../axiosClient"
import { isAxiosError } from "axios";

const authUser = usePage().props.auth.user;



const props = defineProps({
    group: Object,
})

const isInGroup = computed(() => {
    return props.group.users.some(c => c.user_id == authUser.id);
});
const groupUsers = ref([]);
function joinGroup() {
    axiosClient.post(route('group.join', props.group.id))
        .then(response => {
            props.group.users.unshift(response.data.GroupUser);
        })
        .catch(error => {
            console.error('Error joining the group:', error.response.data.message);
        });
}
function leaveGroup() {
    axiosClient.delete(route('group.leave', props.group.id))
        .then(response => {
            props.group.users = props.group.users.filter(c => c.GroupUser === response.data.GroupUser);

        })
        .catch(error => {
            console.error('Error leaving the group:', error.response.data.message);
        });
}
function fetchUsers(){

    axiosClient.get(route('group.users', props.group))
    .then(response => {
    groupUsers.value = response.data.data;
    console.log(groupUsers);

    })
    .catch(error => {
        console.error(error.response.data.message);

    })
}

</script>
<template>

    <AuthenticatedLayout>

        <Head title="Group" />
        <div class="mx-12 mt-5">
            <TabGroup>
            <div class="bg-white rounded shadow-lg">
                <img class="w-full h-40 rounded" src="https://picsum.photos/2000/300"></img>
                <div class="flex items-center gap-3 p-3">
                    <div class="w-24 h-24 rounded-full overflow-hidden">
                        <img class="w-full h-full object-cover" src="https://picsum.photos/600"> </img>
                    </div>
                    <div>
                        <h3 class="mb-2 text-xl font-black">{{ props.group.name }}</h3>
                        <div class="text-xs text-gray-500">
                            <p>{{ props.group.about }}</p>

                        </div>
                    </div>
                </div>
                <div class="flex p-2 gap-2 justify-between">
                    <div class="flex gap-2" v-if="isInGroup">
                        
                            <TabList>
                                <Tab key="users" v-slot="{ selected }">
                                    <button :class="['bg-gray-200 hover:bg-gray-500 p-2 mr-2',
                                        selected ? 'bg-gray-500' : 'text-black']">Posts</button>

                                </Tab>
                                <Tab key="posts" v-slot="{ selected }">
                                    <button @click="fetchUsers" :class="['bg-gray-200 hover:bg-gray-500 p-2 mr-2',
                                        selected ? 'bg-gray-500' : 'text-black']">Users</button>

                                </Tab>
                                <Tab key="item3" v-slot="{ selected }">
                                    <button :class="['bg-gray-200 hover:bg-gray-500 p-2 mr-2',
                                        selected ? 'bg-gray-500' : 'text-black']">Item 3</button>

                                </Tab>
                                
                            </TabList>
                            
                       
                  
                    
                    </div>
                    <div v-else>
                      
                    </div>

                    <div>
                        <button class="bg-emerald-300 hover:bg-emerald-400 p-2" @click="joinGroup"
                            v-if="!isInGroup">Join</button>
                        <button class="bg-red-500 hover:bg-red-600 p-2" @click="leaveGroup"
                            v-if="isInGroup">Leave</button>
                    </div>
                    
                </div>
            </div>
            <TabPanels class="mt-5" v-if="isInGroup">
        <TabPanel >
         Group posts goes here...
        </TabPanel>
        <TabPanel>
        <div class="grid lg:grid-cols-3 gap-4">
            <div v-for="user of groupUsers">
            <div class="rounded-md shadow-xl bg-slate-50 p-4 mt-2 hover:shadow-2xl">
            <div class="flex items-center">
            <img :src="'/storage/' + user.avatar_path" @error="user.avatar_path = 'img/default_avatar.png'" alt="avatar" class="h-[52px] w-[52px] object-cover rounded-full">
            <b class="ml-2 cursor-pointer hover:underline">{{ user.name }}</b>
            </div>
            
            </div>
          </div>
          </div> 
        </TabPanel>
        <TabPanel>
          <p>Content for Item 3</p>
        </TabPanel>
      </TabPanels>
      </TabGroup>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="">

</style>