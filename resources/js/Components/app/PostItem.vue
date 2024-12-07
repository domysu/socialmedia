<template>
  <div class="border bg-white rounded p-4 mb-5">
    <div class="flex gap-3 items-center relative">
      <a href="#" @click="ToProfile()" class="rounded-full">
        <img
          :src="post.user.avatar_url || '/img/default_avatar.png'"
          @error="post.user.avatar_url = '/img/default_avatar.png'"
          class="w-[52px] h-[52px] rounded-full border border-2 hover:border-blue-400"
        />
      </a>

      <div class="">
        <h4 class="font-bold">
          <a href="#" @click="ToProfile()" class="hover:underline"
            >{{ post.user.name }}
          </a>
          <template v-if="post.group">
            <a href="javascript:void()" class="hover:underline">{{ post.group.name }}</a>
          </template>
        </h4>

        <small class="text-gray-400">{{ post.created_at }}</small>
      </div>

      <div class="right-2 top-1 absolute">
        <DiscloserButton
          :post="post"
          v-if="authUser && authUser.id == post.user.id"
        ></DiscloserButton>
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
      <div
        v-for="attachment of post.attachments"
        class="w-full object-cover aspect-square"
      >
        <img
          v-if="isImage(attachment)"
          :src="attachment.url"
          class="cursor-pointer aspect-square"
        />
        <div
          v-else
          class="aspect-square bg-gray-100 flex flex-col justify-center items-center cursor-pointer"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="size-6"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"
            />
          </svg>

          {{ attachment.name }}
        </div>
      </div>
    </div>

    <div class="py-3 flex justify-start items-center">
      <button
        class="mr-2 inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="currentColor"
          class="size-5 mr-2 flex align-center"
        >
          <path
            d="M7.493 18.5c-.425 0-.82-.236-.975-.632A7.48 7.48 0 0 1 6 15.125c0-1.75.599-3.358 1.602-4.634.151-.192.373-.309.6-.397.473-.183.89-.514 1.212-.924a9.042 9.042 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75A.75.75 0 0 1 15 2a2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H14.23c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23h-.777ZM2.331 10.727a11.969 11.969 0 0 0-.831 4.398 12 12 0 0 0 .52 3.507C2.28 19.482 3.105 20 3.994 20H4.9c.445 0 .72-.498.523-.898a8.963 8.963 0 0 1-.924-3.977c0-1.708.476-3.305 1.302-4.666.245-.403-.028-.959-.5-.959H4.25c-.832 0-1.612.453-1.918 1.227Z"
          />
        </svg>

        Like
      </button>

      <button
        class="inline-flex rounded-md bg-black/20 px-3 py-1.5 text-sm font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="size-6 mr-2"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 0 1 1.037-.443 48.282 48.282 0 0 0 5.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"
          />
        </svg>

        Comment
      </button>
    </div>
  </div>
</template>

<script setup>
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import DiscloserButton from "../DiscloserButton.vue";
import { isImage } from "../../helpers.js";

const authUser = usePage().props.auth.user;

const props = defineProps({
  post: {
    type: Object,
  },
});

function ToProfile() {
  router.get(route("profile", props.post.user));
}
</script>

<style lang=""></style>
