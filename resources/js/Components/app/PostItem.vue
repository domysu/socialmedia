<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { router, usePage } from "@inertiajs/vue3";
import { isImage } from "../../helpers.js";
import PostModal from "../PostModal.vue";
import Comment from "./Comment.vue";
import ImagePreview from "../ImagePreview.vue";
import { DocumentIcon,HandThumbUpIcon, ChatBubbleBottomCenterTextIcon, ArrowDownTrayIcon, EllipsisVerticalIcon, PencilIcon, TrashIcon } from "@heroicons/vue/24/outline";
import { computed, defineProps, ref } from "vue";
import axiosClient from "../../axiosClient";

const authUser = usePage().props.auth.user;

const isCommentModalOpen = ref(false);
const isLiked = ref(false);
const isEditModalOpen = ref(false);
const showAttachment = ref(false);
const selectedAttachment = ref(null);
const isEdited = computed(() => {

  return props.post.created_at != props.post.updated_at;
});

function nextAttachment() {
  const index = props.post.attachments.indexOf(selectedAttachment.value);
  if (index < props.post.attachments.length - 1) {
    selectedAttachment.value = props.post.attachments[index + 1];
  }
}

function previousAttachment() {
  const index = props.post.attachments.indexOf(selectedAttachment.value);
  if (index > 0) {
    selectedAttachment.value = props.post.attachments[index - 1];
  }


}
function onPostDelete(postId) {
  if (confirm("Are you sure you want to delete this post?")) {
    router.delete(route("post.delete", postId), {
      onSuccess: () => {
        router.visit(window.location.pathname);
      },
      onError: (error) => {

        console.error("Error deleting post:", error);
      }
    });

    };
  
  }

function handleDownload(attachment) {
  if (!attachment.url) {
    console.error("Invalid attachment URL.");
    return;
  }

  // Create a temporary anchor element
  const link = document.createElement("a");
  link.href = attachment.url;

  // Set the download attribute with the filename
  const filename = attachment.name 
  link.setAttribute("download", filename);

  // Append the link to the document, trigger the click, and remove it
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}
function previewAttachment(attachment) {
  showAttachment.value = true;
  selectedAttachment.value = attachment;
}
const props = defineProps({
  post: {
    type: Object,
  },

});

function ToProfile() {
  router.get(route("profile", props.post.user));
}

function sendReaction() {
  axiosClient.post(route("post.reaction", props.post.id), {
    reaction: "like",
  })
  .then(() => {
    props.post.has_reacted = !props.post.has_reacted;
    props.post.has_reacted ? props.post.reactions++ : props.post.reactions--;

  })
  .catch((error) => {
    console.log(error);
  });
}



</script>
<template>
  
  <div class="border bg-white rounded p-4 mb-5">

    <div class="flex gap-3 items-center relative">

      <Menu as="div" class="inline-block text-left">
        <div>
          <MenuButton class="absolute right-1 top-1">
            <EllipsisVerticalIcon class="size-6"></EllipsisVerticalIcon>
          </MenuButton>
        </div>
  
        <transition enter-active-class="transition duration-100 ease-out"
          enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100"
          leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100"
          leave-to-class="transform scale-95 opacity-0">
          <MenuItems
            class="absolute right-1 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none">
            <MenuItem v-slot="{ active }">
            <button @click="isEditModalOpen = true" :class="[
              active ? 'bg-gray-300 text-white gap-2' : 'text-gray-900',
              'group flex w-full items-center rounded-md px-2 py-2 text-sm gap-2',
            ]">
              <PencilIcon class="size-5"></PencilIcon>
              Edit
            </button>
            </MenuItem>
            <MenuItem v-slot="{ active }">
            <button @click="onPostDelete(post.id)" :class="[
              active ? 'bg-red-500 text-white gap-2' : 'text-gray-900 gap-2',
              'group flex w-full items-center rounded-md px-2 py-2 text-sm',
            ]">
            <TrashIcon class="size-5"></TrashIcon>
              Delete
            </button>
            </MenuItem>
          </MenuItems>
        </transition>


        <PostModal :post="props.post" v-model="isEditModalOpen"></PostModal>
      </Menu>
      <a href="#" @click="ToProfile()" class="rounded-full">
        <img :src="post.user.avatar_url || '/img/default_avatar.png'"
          @error="post.user.avatar_url = '/img/default_avatar.png'"
          class="w-[52px] h-[52px] rounded-full border-2 hover:border-blue-400" />
      </a>
      <div class="">
        <h4 class="font-bold">
          <a href="#" @click="ToProfile()" class="hover:underline">{{ post.user.name }}
          </a>
          <template v-if="post.group">
            <a href="javascript:void()" class="hover:underline">{{ post.group.name }}</a>
          </template>
        </h4>

        <small class="text-gray-400">{{ post.created_at }}</small>
        <p v-if="isEdited" class="text-gray-500 text-xs">Edited</p>
      </div>

      <div class="right-2 top-1 absolute">
        <PostModal :post="post" v-if="authUser && authUser.id == post.user.id"></PostModal>
      </div>
    </div>

    <Disclosure v-slot="{ open }">
      <div v-if="!open" class="mt-2" v-html="post.body.substring(0, 200)"></div>
      <DisclosurePanel>
        <div class="mt-2" v-html="post.body" />
      </DisclosurePanel>
      <template v-if="post.body.length > 200">
        <div class="flex justify-end">
          <DisclosureButton class="text-blue-500 hover:underline">
            {{ open ? "Read less" : "Read More" }}
          </DisclosureButton>
        </div>
      </template>
    </Disclosure>
    <div class="grid grid-cols-2 gap-3 lg:grid-cols-3 place-items-center">
      <div v-for="attachment of post.attachments" class="group/attachments relative w-full object-cover aspect-square">
  
        <button class="absolute right-0 top-0 p-2 m-1 group-hover/attachments:opacity-100 opacity-0 hover:bg-gray-400 rounded-md z-30" @click="handleDownload(attachment)" >  
          <ArrowDownTrayIcon class="h-5 w-5"></ArrowDownTrayIcon>
        </button>
        <ImagePreview :attachment="selectedAttachment" v-if="showAttachment" @close="showAttachment = false"
          @next="nextAttachment" @prev="previousAttachment"></ImagePreview>

        <img v-if="isImage(attachment)" :src="attachment.url" class="cursor-pointer aspect-square"
          @click="previewAttachment(attachment)" />

        <div v-else class=" aspect-square bg-gray-200 flex flex-col justify-center items-center cursor-pointer" @click="previewAttachment(attachment)">
       
          <ImagePreview :attachment="selectedAttachment" v-if="showAttachment" @close="showAttachment = false"
          @next="nextAttachment" @prev="previousAttachment"></ImagePreview>
          <DocumentIcon class="size-6"></DocumentIcon>

          <small class="text-center">{{ attachment.name }}</small>
        </div>
      </div>
    </div>
    
    <div class="py-3 flex justify-start items-center">
      <button
        @click="sendReaction"
        class="mr-2 inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
        :class="props.post.has_reacted ? 'bg-blue-400 hover:bg-blue-300' : ''"
        >
        
        <span v-if="props.post.reactions > 0" class="h-5 w-5">   {{ props.post.reactions }}</span> 
        <HandThumbUpIcon class="h-5 w-5 mr-2"></HandThumbUpIcon>
        
        {{ props.post.has_reacted ? 'Unlike' : 'Like' }}
      </button>
    
        
      <button
        class="inline-flex rounded-md bg-black/20 px-4 py-2 text-sm font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
        @click="isCommentModalOpen = !isCommentModalOpen"
        >
        <span v-if="props.post.comment.length > 0" class="h-5 w-5 mr-1"> {{ props.post.num_of_comments}} </span>
        <ChatBubbleBottomCenterTextIcon class="h-5 w-5 mr-2"></ChatBubbleBottomCenterTextIcon>

        Comments
      </button>
    </div>
    
    <div class="overflow-auto max-h-[350px]">
    <Comment v-if="isCommentModalOpen" :post="props.post" :data="{comment: props.post.comment}"></Comment>
    </div>
  </div>
</template>



<style lang=""></style>
