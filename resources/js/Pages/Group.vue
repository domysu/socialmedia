<script setup>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { defineProps, ref, computed } from "vue";
import { usePage, router, useForm } from "@inertiajs/vue3";
import axiosClient from "../axiosClient"
import { CubeIcon } from "@heroicons/vue/24/outline";
import axios, { isAxiosError } from "axios";

const authUser = usePage().props.auth.user;

const imagesForm = useForm({
  avatar: null,
  cover: null,
});

const isEditing = computed(() => {

    return coverImageSrc.value || avatarImageSrc.value;
})
const coverImageSrc = ref();
const avatarImageSrc = ref();

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

function toProfile(user){
    router.get(route('profile', user))
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

function onCoverChange(event)
{
    imagesForm.cover = event.target.files[0];
    if(imagesForm.cover)
    {
        const reader = new FileReader();
        reader.onload = () => {
            coverImageSrc.value = reader.result;
        };
        reader.readAsDataURL(imagesForm.cover);
    }
}
function cancelEdit()
{
    imagesForm.cover = null;
    imagesForm.avatar = null;
    coverImageSrc.value = null;
    avatarImageSrc.value = null;
}
function saveEdit()
{
    if(coverImageSrc)
    {
        imagesForm.post(route('group.cover.save', props.group));
    }
    else imagesForm.post(route('group.avatar.save', props.group));
}





function onAvatarChange(event)
{
imagesForm.avatar = event.target.files[0];
if(imagesForm.avatar)
{
    const reader = new FileReader();
    reader.onload = () => {
        avatarImageSrc.value = reader.result
    };
    reader.readAsDataURL(imagesForm.avatar);
}
}
</script>
<template>

    <AuthenticatedLayout>

        <div class="mx-12 mt-5">
            <TabGroup>
            <div class="bg-white rounded shadow-lg">
                <div class="relative group/cover">
                <img class="w-full h-40 rounded relative" @error="props.group.cover_path = 'https://picsum.photos/2000/300'" :src="coverImageSrc || props.group.cover_path || 'https://picsum.photos/2000/300'"></img>
                <div v-if="isEditing" class="absolute right-2 top-2">
                    <button @click="saveEdit" class="p-1 px-2 bg-green-500 rounded-sm mr-2 text-white opacity-50 hover:opacity-100">Save</button>
                    <button @click="cancelEdit" class="p-1 px-2 text-white bg-red-600 rounded-sm opacity-50 hover:opacity-100"> Cancel </button>
                    
                </div> 
                <div v-else class="absolute right-2 top-2">
                <button class="p-1 px-2 bg-teal-400 rounded-sm text-white invisible opacity-50 hover:opacity-100 group-hover/cover:visible">
                <input @change="onCoverChange" class="absolute opacity-0 cursor-pointer left-0 right-0 top-0 bottom-0" type="file">
                Change
                </button>
                </div>
            </div>
                <div class="flex items-center gap-3 p-3">
                    <div class="w-24 h-24 rounded-full overflow-hidden relative">
                        <img class="w-full h-full object-cover" @error="props.group.thumbnail_path = 'https://picsum.photos/600'" :src="avatarImageSrc || props.group.thumbnail_path || 'https://picsum.photos/600'"></img>
                        <div class="absolute top-0 bottom-0 right-0 left-0 group/avatar cursor-pointer">
                        <CubeIcon class="opacity-70 invisible group-hover/avatar:visible"></CubeIcon>
                        <input @change="onAvatarChange" class="absolute right-0 bottom-0 left-0 top-0 opacity-0 cursor-pointer" type="file">
                        </div>
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
            <b @click="toProfile(user)" class="ml-2 cursor-pointer hover:underline">{{ user.name }}</b>
            
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