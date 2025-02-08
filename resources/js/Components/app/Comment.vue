<script setup>
import { ref } from 'vue';
import TextAreaInput from '../TextAreaInput.vue';
import axiosClient from '../../axiosClient';
import { router } from "@inertiajs/vue3";
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { EllipsisVerticalIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/outline';
import dayjs from 'dayjs';




const props = defineProps({
    post: Object,
});

const comment = ref('');
const editingCommentId = ref(null);
const editedComment = ref('');
function addComment() {
    axiosClient.post(route('post.comment', props.post), {
        comment: comment.value,
    }).then(response => {

        props.post.latest5Comments.unshift(response.data);
        props.post.comment.length++;
        console.log(response.data);
        comment.value = '';
    }).catch(error => {
        console.log(error.response.data);
    });
}
function onCommentEdit(commentObj) {
    editingCommentId.value = commentObj.id;
    editedComment.value = commentObj.comment;


}

function saveEdit() {

    axiosClient.put(route('comment.update', editingCommentId.value), {
        comment: editedComment.value,
    }).then(({ data }) => {

        props.post.latest5Comments = props.post.latest5Comments.map((c) => {
            return c.id === data.id ? data : c;
        });
        
    }).catch(error => {
        console.log(error.response);
    });
    editingCommentId.value = null;
  
}

function onCommentDelete(comment) {
    axiosClient.delete(route('comment.delete', comment.id))
    .then(() => {
        props.post.latest5Comments = props.post.latest5Comments.filter(c => c.id !== comment.id);
        props.post.comment.length--;
    
    });
  
}

function ToProfile(user) {
    router.get(route('profile', user));
}

</script>
<template>


    <input class="rounded border-blue-200" placeholder="input your comment" type="text" v-model="comment" />
    <button class="bg-blue-400 hover:bg-blue-500 p-2 rounded-md ml-2" @click="addComment">Add Comment</button>

    <div class="bg-gray-50 rounded border-none" v-for="comment in props.post.latest5Comments" :key="comment.id">
   
        <div class="mt-3 border-none p-3 rounded">
            <div class="flex items-center gap-3 relative">

                <a href="#" @click="ToProfile(comment.user)" class="rounded-full">
                    <img :src="comment.user.avatar_url || '/img/default_avatar.png'"
                        @error="comment.user.avatar_url = '/img/default_avatar.png'"
                        class="w-[48px] h-[48px] rounded-full border-2 hover:border-blue-400" />
                </a>

                <h3 class="font-bold">
                    <a href="#" @click="ToProfile(comment.user)" class="hover:underline">{{ comment.user.name }}</a>
                </h3>
                <Menu as="div" class="inline-block text-left">
                    <div>
                        <MenuButton class="absolute right-1 top-1">
                            <EllipsisVerticalIcon class="size-5"></EllipsisVerticalIcon>
                        </MenuButton>
                    </div>

                    <transition enter-active-class="transition duration-100 ease-out"
                        enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
                        leave-active-class="transition duration-75 ease-in"
                        leave-from-class="transform scale-100 opacity-100"
                        leave-to-class="transform scale-95 opacity-0">
                        <MenuItems
                            class="absolute right-1 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
                            <MenuItem v-slot="{ active }">
                            <button @click="onCommentEdit(comment)" :class="[
                                active ? 'bg-gray-300 text-white gap-2' : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm gap-2',
                            ]">
                                <PencilIcon class="size-5"></PencilIcon>
                                Edit
                            </button>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                           
                            <button @click="onCommentDelete(comment)" :class="[
                                active ? 'bg-red-500 text-white gap-2' : 'text-gray-900 gap-2',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                            ]">
                                <TrashIcon class="size-5"></TrashIcon>
                                Delete
                            </button>
                            </MenuItem>
                        </MenuItems>
                    </transition>



                </Menu>

            </div>
            <small class="text-gray-400">{{ dayjs(comment.updated_at).format('MMMM D, YYYY h:mm A') }}</small>

            <Disclosure v-if="editingCommentId !== comment.id" v-slot="{ open }">
                <div v-if="!open" class="mt-2" v-html="comment.comment.substring(0, 200)"></div>
                <DisclosurePanel>
                    
                    <div class="mt-2" v-html="comment.comment" />
                </DisclosurePanel>
                <template v-if="comment.comment.length > 200">
                    <div class="flex justify-end">
                        <DisclosureButton class="text-blue-500 hover:underline">
                            {{ open ? "Read less" : "Read More" }}
                        </DisclosureButton>
                    </div>
                </template>
            </Disclosure>
            <div v-else>
                <TextAreaInput v-model="editedComment"></TextAreaInput>
                <div class="flex justify-end gap-3">
                    <button class="p-2 bg-green-500 rounded hover:bg-green-600 mt-2 min-w-[66px]" @click="saveEdit">
                        Edit </button>
                    <button class="p-2 bg-slate-200 rounded hover:bg-slate-300 mt-2 min-w-[66px]"
                        @click="editingCommentId = null">
                        Cancel </button>
                </div>
            </div>

        </div>
    </div>




</template>