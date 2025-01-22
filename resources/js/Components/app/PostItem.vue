<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { router, usePage } from "@inertiajs/vue3";
import { isImage } from "../../helpers.js";
import PostModal from "../PostModal.vue";
import ImagePreview from "../ImagePreview.vue";
import { DocumentIcon,HandThumbUpIcon, ChatBubbleBottomCenterTextIcon, ArrowDownTrayIcon } from "@heroicons/vue/24/outline";
import { defineProps, ref } from "vue";
import { indexOf } from "ckeditor5";

const authUser = usePage().props.auth.user;

const isEditModalOpen = ref(false);
const showAttachment = ref(false);
const selectedAttachment = ref(null);

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
    router.delete(route("post.delete", postId));
  }
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



</script>
<template>
  <div class="border bg-white rounded p-4 mb-5">

    <div class="flex gap-3 items-center relative">

      <Menu as="div" class="inline-block text-left">
        <div>
          <MenuButton class="absolute right-1 top-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
            </svg>
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
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
              </svg>

              Edit
            </button>
            </MenuItem>
            <MenuItem v-slot="{ active }">
            <button @click="onPostDelete(post.id)" :class="[
              active ? 'bg-red-500 text-white gap-2' : 'text-gray-900 gap-2',
              'group flex w-full items-center rounded-md px-2 py-2 text-sm',
            ]">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
              </svg>

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
        class="mr-2 inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
        
        <HandThumbUpIcon class="h-5 w-5 mr-2"></HandThumbUpIcon>
        Like
      </button>

      <button
        class="inline-flex rounded-md bg-black/20 px-3 py-1.5 text-sm font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75">
        <ChatBubbleBottomCenterTextIcon class="h-5 w-5 mr-2"></ChatBubbleBottomCenterTextIcon>

        Comment
      </button>
    </div>
  </div>
</template>



<style lang=""></style>
