<script setup>

import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import { usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { computed, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import axiosClient from "../../axiosClient"
import { PencilSquareIcon } from "@heroicons/vue/24/outline";
import UserProfileFollowerItem from "@/Components/UserProfileFollowerItem.vue";
import PostList from "@/Components/app/PostList.vue";
import UserProfileFollowingItem from "@/Components/UserProfileFollowingItem.vue";

const imagesForm = useForm({
  avatar: null,
  cover: null,
});


const authUser = usePage().props.auth.user;
let showNotification = ref(true);
const isEditingImage = computed(() => !avatarImagesrc.value && !coverImageSrc.value);

const avatarImagesrc = ref();
const coverImageSrc = ref();

const props = defineProps({
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
  posts: {
    type: Object,
  },
  followers: {
    type: Object,
  },
  followings: {
    type: Object,
  }
});
function onAvatarChange(event) {
  imagesForm.avatar = event.target.files[0];

  if (imagesForm.avatar) {
    imagesForm.cover = null;
    coverImageSrc.value = null;
    const reader = new FileReader();
    reader.onload = () => {
      avatarImagesrc.value = reader.result;
    };
    reader.readAsDataURL(imagesForm.avatar);
  }
}

function onCoverChange(event) {
  imagesForm.cover = event.target.files[0];
  if (imagesForm.cover) {
    imagesForm.avatar = null;
    avatarImagesrc.value = null;
    const reader = new FileReader();
    reader.onload = () => {
      coverImageSrc.value = reader.result;
    };

    reader.readAsDataURL(imagesForm.cover);
  }
}
function cancelCoverImage() {  imagesForm.cover = null;
  coverImageSrc.value = null;

  avatarImagesrc.value = null;
  imagesForm.avatar = null;
}

function submitCoverImage() {
  if (coverImageSrc.value) {
    imagesForm.post(route("profile.updateCover"));
  } else {
    imagesForm.post(route("profile.updateAvatar"));
  }

  cancelCoverImage();
  setTimeout(() => {
    showNotification.value = false;
  }, 3000);
}

function followUser(user) {



  axiosClient.post(route('user.follow'), {
    user_id: props.user.id

  }).then(response => {
    
    if (isFollowing.value) {
      localFollowers.value = localFollowers.value.filter(f =>
        !(f.follower_id === authUser.id && f.user_id === props.user.id)
      );
    }
    else {
     localFollowers.value.push({
    follower_id: authUser.id,
    user_id: props.user.id,
    follower: response.data.follower
    });
    console.log(localFollowers);
    }

  }).catch(error => {

    console.log(error);
  });
}

const localFollowers = ref([...props.followers.data]);
const isFollowing = computed(() => {
  return localFollowers.value.some(f =>
    f.follower_id === authUser.id && f.user_id === props.user.id
  );
});

const followerCount = computed(() => localFollowers.value.length);
</script>

<template>
  <AuthenticatedLayout>

    <div class="container mx-auto h-full overflow-none">
      <div v-if="showNotification && props.status" class="bg-emerald-300 font-medium text-white p-2">
        {{ props.status }}
      </div>
      <div v-if="showNotification && props.errors.cover" class="bg-red-400 font-300 text-white p-2">
        {{ props.errors.cover }}
      </div>
      <div class="group/cover relative">
        <img :src="coverImageSrc || user.cover_url || '/img/default_cover.jpg'" alt=""
          class="w-full h-[200px] object-cover" @error="user.cover_url = '/img/default_cover.jpg'" />
        <div v-if="isEditingImage">
          <button
            class="opacity-0 group-hover/cover:opacity-100 flex gap-2 absolute top-2 right-2 p-1 px-2 rounded bg-gray-200 hover:bg-gray-100 transition duration-150 ease-in-out"
            v-if="authUser && authUser.id == props.user.id">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-6">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>

            Edit Cover
            <input type="file" class="absolute opacity-0 top-2 right-2 cursor-pointer" @change="onCoverChange" />
          </button>
        </div>
        <div v-else class="gap-2 flex top-1 right-2 absolute">
          <button @click="submitCoverImage"
            class="py-1 px-2 bg-lime-100 rounded flex items-center gap-1 hover:bg-lime-200 transition duration-150 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
            </svg>

            Submit
          </button>
          <button @click="cancelCoverImage"
            class="py-1 px-2 bg-stone-200 rounded flex items-center gap-1 hover:bg-stone-400 transition duration-150 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
              stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>

            Cancel
          </button>
        </div>

        <!-- Avatar -->
      
        <div class="flex bg-white relative p-2">
          <div
            class="items-center justify-center flex -mt-[64px] ml-[64px] relative group/avatar rounded-full w-[128px] h-[128px]">
            <img :src="avatarImagesrc || user.avatar_url || '/img/default_avatar.png'" alt=""
              class="h-full w-full rounded-full object-cover" @error="user.avatar_url = '/img/default_avatar.png'" />
            <button v-if="isEditingImage && authUser && authUser.id == props.user.id"
              class="cursor-pointer absolute text-black flex items-center justify-center bottom-0 top-0 right-0 left-0 opacity-0 group-hover/avatar:opacity-100">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-12">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
              </svg>
              <input @change="onAvatarChange" type="file"
                class="w-[128px] h-[128px] left-0 right-0 bottom-0 top-0 absolute rounded-full cursor-pointer opacity-0" />
            </button>
            <div v-else class="absolute top-2"></div>
          </div>
          <div class="p-3 flex flex-1 lg:relative items-center" >
            <h2 class="font-bold text-lg sm:mr-3">{{ props.user.name }}</h2>

            <a :href="route('profile.updateIndex')">
              <PrimaryButton v-if="authUser && authUser.id == props.user.id" class="gap-2 lg:absolute right-1 bottom-3 ">
                <PencilSquareIcon class="size-6"></PencilSquareIcon>
                Edit Profile
              </PrimaryButton>
            </a>
            <div>
              <button v-if="props.user.id != authUser.id" @click="followUser(user)"
                class="bg-blue-600 text-sm px-2 py-1 text-white rounded-md hover:bg-blue-700 hover:text-neutral-100"
                :class="isFollowing ? 'bg-blue-500' : ''">{{ isFollowing ? 'Unfollow' : 'Follow' }}</button>
            </div>
          </div>
        
        </div>
        
      </div>

      <div>
        <TabGroup>
          <TabList class="bg-white border-t">
            <Tab key="about" v-slot="{ selected }">
              <button :class="[
                'px-6 py-2.5 outline-none text-sm',
                selected ? 'text-blue-700 border-b border-blue-700' : 'text-black',
              ]">
                About
              </button>
            </Tab>

            <Tab key="posts" v-slot="{ selected }">
              <button :class="[
                'px-6 py-2.5 text-sm outline-none',
                selected ? 'text-blue-700 border-b border-blue-700' : 'text-black',
              ]">
                Posts
              </button>
            </Tab>

            <Tab key="following" v-slot="{ selected }">
              <button :class="[
                'px-6 py-2.5 outline-none text-sm',
                selected ? 'text-blue-700 border-b border-blue-700' : 'text-black',
              ]">
               {{props.followings.data.length}} Followings
              </button>
            </Tab>
            <Tab key="followers" v-slot="{ selected }">
              <button :class="[
                'px-6 py-2.5 outline-none text-sm',
                selected ? 'text-blue-700 border-b border-blue-700' : 'text-black',
              ]">
                {{followerCount}} Followers
              </button>
            </Tab>
          </TabList>

          <TabPanels class="mt-2">
            <TabPanel key="about" class="px-5" v-html="props.user.about">  </TabPanel>
            <TabPanel key="posts" class="px-5"> <PostList :posts="posts.data"></PostList> </TabPanel>
            <TabPanel key="following" class="px-5"> <UserProfileFollowingItem v-for="following of props.followings.data" :following="following"></UserProfileFollowingItem> </TabPanel>
            <TabPanel key="followers" class="px-5"> <UserProfileFollowerItem v-for="follower of localFollowers" 
                                                                            :follower="follower"></UserProfileFollowerItem> </TabPanel>
          </TabPanels>
        </TabGroup>
      </div>
    </div>
  </AuthenticatedLayout>
</template>


<style></style>
