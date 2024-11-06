<template>
  <AuthenticatedLayout>
    <div class="container mx-auto h-full overflow-auto">

      <div class="group relative">
        <img
          :src="coverImageSrc || user.cover_url || '/img/default_cover.jpg'"
          alt=""
          class="w-full h-[200px] object-cover"
        />
        <div v-if="coverImageSrc == null">
          <button
            class="opacity-0 group-hover:opacity-100 flex gap-2 absolute top-2 right-2 p-1 px-2 rounded bg-gray-200 hover:bg-gray-100 transition duration-150 ease-in-out"
            v-if="authUser && authUser.id == user.id"
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
                d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
              />
            </svg>

            Edit Cover
            <input
              type="file"
              class="absolute opacity-0 top-2 right-2 cursor-pointer"
              @change="onCoverChange"
            />
          </button>
        </div>
        <div v-else class="gap-2 flex top-1 right-2 absolute">
          <button
            @click="submitCoverImage"
            class="py-1 px-2 bg-lime-100 rounded flex items-center gap-1 hover:bg-lime-200 transition duration-150 ease-in-out"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="size-4"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="m4.5 12.75 6 6 9-13.5"
              />
            </svg>

            Submit
          </button>
          <button
            @click="cancelCoverImage"
            class="py-1 px-2 bg-stone-200 rounded flex items-center gap-1 hover:bg-stone-400 transition duration-150 ease-in-out"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
              class="size-5"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M6 18 18 6M6 6l12 12"
              />
            </svg>

            Cancel
          </button>
        </div>
        <div class="flex bg-white">
          <img
            src="https://w7.pngwing.com/pngs/340/946/png-transparent-avatar-user-computer-icons-software-developer-avatar-child-face-heroes-thumbnail.png"
            alt=""
            class="w-[128px] -mt-[64px] ml-[64px] rounded-full"
          />

          <div class="p-3 flex flex-1 justify-between items-center">
            <h2 class="font-bold text-lg">{{ user.name }}</h2>

            <PrimaryButton v-if="authUser && authUser.id == user.id" class="gap-2">
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
                  d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
                />
              </svg>

              Edit Profile
            </PrimaryButton>
          </div>
        </div>
      </div>

      <div>
        <TabGroup>
          <TabList class="bg-white border-t">
            <Tab v-if="authUser && authUser.id == user.id" v-slot="{ selected }">
              <button
                :class="[
                  'px-6 py-2.5 outline-none text-sm',
                  selected ? 'text-blue-700 border-b border-blue-700' : 'text-black',
                ]"
              >
                About
              </button>
            </Tab>

            <Tab key="Posts" v-slot="{ selected }">
              <button
                :class="[
                  'px-6 py-2.5 text-sm outline-none text-sm',
                  selected ? 'text-blue-700 border-b border-blue-700' : 'text-black',
                ]"
              >
                Posts
              </button>
            </Tab>

            <Tab key="posts" v-slot="{ selected }">
              <button
                :class="[
                  'px-6 py-2.5 outline-none text-sm',
                  selected ? 'text-blue-700 border-b border-blue-700' : 'text-black',
                ]"
              >
                Following
              </button>
            </Tab>
            <Tab key="posts" v-slot="{ selected }">
              <button
                :class="[
                  'px-6 py-2.5 outline-none text-sm',
                  selected ? 'text-blue-700 border-b border-blue-700' : 'text-black',
                ]"
              >
                Friends
              </button>
            </Tab>
          </TabList>

          <TabPanels class="mt-2">
            <TabPanel v-if="authUser && authUser.id == user.id" key="posts" class="px-5">
              <Edit :must-verify-email="mustVerifyEmail" :status="status"></Edit>
            </TabPanel>

            <TabPanel key="followers" class="px-5"> </TabPanel>
            <TabPanel key="followers" class="px-5"> Follower content </TabPanel>
            <TabPanel key="followers" class="px-5"> Follower content </TabPanel>
          </TabPanels>
        </TabGroup>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import { usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Edit from "./Edit.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";
import { useForm } from '@inertiajs/vue3'
import { router } from "@inertiajs/vue3";

const imagesForm = useForm({
  avatar:  null,
  cover: null,
})

const authUser = usePage().props.auth.user;


const coverImageSrc = ref();
defineProps({

  errors: Object,

  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
  user: {
    type: Object,
  },
});

function onCoverChange(event) {
  console.log(event);
  imagesForm.cover = event.target.files[0];
  if (imagesForm.cover) {
    const reader = new FileReader();
    reader.onload = () => {
      console.log("Onload");
      coverImageSrc.value = reader.result;
    };

    reader.readAsDataURL(imagesForm.cover);
  }
}
function cancelCoverImage()
{
  imagesForm.cover = null;
  coverImageSrc.value = null;
}

function submitCoverImage() {
  imagesForm.post(route('profile.updateCover'));
  return to_route('profile');
}
</script>
<style></style>
