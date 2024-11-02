<template>
  <AuthenticatedLayout>
    <div class="container mx-auto">
      <div class="relative">
        <img
          src="https://images.inc.com/uploaded_files/image/1920x1080/getty_509107562_2000133320009280346_351827.jpg"
          alt=""
          class="w-full h-[200px] object-cover"
        />

        <img
          src="https://w7.pngwing.com/pngs/340/946/png-transparent-avatar-user-computer-icons-software-developer-avatar-child-face-heroes-thumbnail.png"
          alt=""
          class="w-[128px] -bottom-[40px] left-[64px] absolute rounded-full"
        />
      </div>

      <div>
        <TabGroup>
          <TabList class="bg-white pl-[200px] flex">
            <Tab
            
              
              key="posts"
              v-slot="{ selected }"
            >
              <button
                :class="[
                  'px-6 py-2.5 outline-none text-sm',
                  selected
                    ? 'text-blue-700 border-b border-blue-700'
                    : 'text-black',
                ]"
              >
                Posts
              </button>
            </Tab>

            <Tab
            
              
              key="Posts"
              v-slot="{ selected }"
            >
              <button
                :class="[
                  'px-6 py-2.5 text-sm outline-none text-sm',
                  selected
                    ? 'text-blue-700 border-b border-blue-700'
                    : 'text-black',
                ]"
              >
                Followers
              </button>
            </Tab>
          </TabList>
          

          <TabPanels class="mt-2">
            <TabPanel
              key="posts"
              class="px-5"
            >
            Post content
              
            </TabPanel>

            <TabPanel
                key="followers"
                class="px-5"
            >
            Follower content
              
            </TabPanel>
          </TabPanels>
        </TabGroup>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from "@headlessui/vue";
import { usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const user = usePage().props.auth.user;

</script>
<style></style>
