<script setup>
import { TabGroup, TabList, Tab, TabPanels, TabPanel, Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { defineProps, ref, computed } from "vue";
import { usePage, router, useForm } from "@inertiajs/vue3";
import axiosClient from "../axiosClient"
import { CubeIcon, EllipsisVerticalIcon } from "@heroicons/vue/24/outline";

const authUser = usePage().props.auth.user;
const props = defineProps({
    errors: Object,
    group: Object,
    status: String,
})


const groupEditForm = useForm({
    name: props.group.name,
    about: props.group.about,
})
const imagesForm = useForm({
    avatar: null,
    cover: null,
});

const coverImageSrc = ref();
const avatarImageSrc = ref();
const showNotification = ref(true);
const groupUsers = ref([]);
const isInGroupEdit = ref(false);

const isEditing = computed(() => {
    return coverImageSrc.value || avatarImageSrc.value;
})

const isInGroup = computed(() => {
    return props.group.users.some(c => c.user_id == authUser.id);
});


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

function toProfile(user) {
    router.get(route('profile', user))
}
function fetchUsers() {

    axiosClient.get(route('group.users', props.group))
        .then(response => {
            groupUsers.value = response.data.data;
        })
        .catch(error => {
            console.error(error.response.data.message);

        })
}


function cancelEdit() {
    imagesForm.cover = null;
    imagesForm.avatar = null;
    coverImageSrc.value = null;
    avatarImageSrc.value = null;
}
function saveEdit() {
    coverImageSrc ? imagesForm.post(route('group.cover.save', props.group)) :
        imagesForm.post(route('group.avatar.save', props.group));

    cancelEdit();
    setTimeout(() => {
        showNotification.value = false;
    }, 3000);

}
function saveGroupEdit(){
    groupEditForm.put(route('group.update', props.group), {
        onSuccess: () => {
            isInGroupEdit.value = false;
        },
    

    });

}




function onCoverChange(event) {
    imagesForm.cover = event.target.files[0];
    if (imagesForm.cover) {
        const reader = new FileReader();
        reader.onload = () => {
            coverImageSrc.value = reader.result;
        };
        reader.readAsDataURL(imagesForm.cover);
    }
}

function onAvatarChange(event) {
    imagesForm.avatar = event.target.files[0];
    if (imagesForm.avatar) {
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

                <div v-if="props.status && showNotification"
                    class="bg-green-400 opacity-80 p-1 text-center align-center mb-1">
                    {{ status }}
                </div>

                <div v-if="(props.errors.cover || props.errors.avatar) && showNotification"
                    class="bg-red-400 p-1 opacity-80 text-center align-center mb-1">
                    {{ props.errors.cover || props.errors.avatar }}
                </div>
                <div class="bg-white rounded shadow-lg">

                    <div class="relative group/cover">
                        <img class="w-full h-40 rounded relative object-cover"
                            @error="props.group.cover_path = 'https://picsum.photos/2000/300'"
                            :src="coverImageSrc || props.group.cover_path || 'https://picsum.photos/2000/300'"></img>
                        <div v-if="isEditing" class="absolute right-2 top-2">
                            <button @click="saveEdit"
                                class="p-1 px-2 bg-green-500 rounded-sm mr-2 text-white opacity-50 hover:opacity-100">Save</button>
                            <button @click="cancelEdit"
                                class="p-1 px-2 text-white bg-red-600 rounded-sm opacity-50 hover:opacity-100"> Cancel
                            </button>

                        </div>
                        <div v-else class="absolute right-2 top-2">
                            <button
                                class="p-1 px-2 bg-teal-400 rounded-sm text-white invisible opacity-50 hover:opacity-100 group-hover/cover:visible">
                                <input @change="onCoverChange"
                                    class="absolute opacity-0 cursor-pointer left-0 right-0 top-0 bottom-0" type="file">
                                Change
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 p-3 relative">
                        <div class="w-24 h-24 rounded-full overflow-hidden relative">
                            <img class="w-full h-full object-cover"
                                @error="props.group.thumbnail_path = 'https://picsum.photos/600'"
                                :src="avatarImageSrc || props.group.thumbnail_path || 'https://picsum.photos/600'"></img>
                            <div class="absolute top-0 bottom-0 right-0 left-0 group/avatar cursor-pointer">
                                <CubeIcon class="opacity-70 invisible group-hover/avatar:visible"></CubeIcon>
                                <input @change="onAvatarChange"
                                    class="absolute right-0 bottom-0 left-0 top-0 opacity-0 cursor-pointer" type="file">
                            </div>
                        </div>
                        <div v-if="!isInGroupEdit">
                            <h3 class="mb-2 text-xl font-black">{{ props.group.name }}</h3>
                            <div class="text-xs text-gray-500">
                                <p>{{ props.group.about }}</p>

                            </div>
                        </div>
                        <div v-else>
                            <input class="mb-1 font-black border-none" type="text"
                                :placeholder="props.group.name" v-model="groupEditForm.name">
                              
                            <div>

                                <input class="text-gray-500 border-none" type="text" :placeholder="props.group.about" v-model="groupEditForm.about">
                            </div>

                        </div>
                        <div class="absolute right-2 top-2">
                            <Menu as="div" class="relative inline-block text-left" v-if="!isInGroupEdit">
                                <div>
                                    <MenuButton class="">
                                        <EllipsisVerticalIcon class="size-7"></EllipsisVerticalIcon>
                                    </MenuButton>
                                </div>

                                <transition enter-active-class="transition duration-100 ease-out"
                                    enter-from-class="transform scale-95 opacity-0"
                                    enter-to-class="transform scale-100 opacity-100"
                                    leave-active-class="transition duration-75 ease-in"
                                    leave-from-class="transform scale-100 opacity-100"
                                    leave-to-class="transform scale-95 opacity-0">
                                    <MenuItems
                                        class="absolute right-0 mt-2 w-24 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                                        <div class="px-1 py-1">
                                            <MenuItem v-slot="{ active }">
                                            <button :class="[
                                                active ? 'bg-violet-500 text-white' : 'text-gray-900',
                                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                            ]" @click="isInGroupEdit = !isInGroupEdit">
                                                Edit
                                            </button>
                                            </MenuItem>
                                        </div>
                                    </MenuItems>
                                </transition>
                            </Menu>
                            <div v-else>
                                <button @click="saveGroupEdit" class="bg-emerald-300 hover:bg-emerald-400 p-2">Update</button>
                                <button class="p-2 bg-red-500 rounded-sm text-white hover:bg-red-600 hover:font-medium"
                                    @click="isInGroupEdit = !isInGroupEdit"> Cancel </button>
                                
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
                            <button class="bg-red-500 hover:bg-red-600 p-2 text-white rounded-sm" @click="leaveGroup"
                                v-if="isInGroup">Leave</button>
                        </div>

                    </div>
                </div>
                <TabPanels class="mt-5" v-if="isInGroup">
                    <TabPanel>
                        Group posts goes here...
                    </TabPanel>
                    <TabPanel>
                        <div class="grid lg:grid-cols-3 gap-4">
                            <div v-for="user of groupUsers">
                                <div class="rounded-md shadow-xl bg-slate-50 p-4 mt-2 hover:shadow-2xl">
                                    <div class="flex items-center">
                                        <img :src="'/storage/' + user.avatar_path"
                                            @error="user.avatar_path = 'img/default_avatar.png'" alt="avatar"
                                            class="h-[52px] w-[52px] object-cover rounded-full">
                                        <b @click="toProfile(user)" class="ml-2 cursor-pointer hover:underline">{{
                                            user.name }}</b>

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