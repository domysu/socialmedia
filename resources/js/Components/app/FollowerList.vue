<script setup>
import { computed } from "vue";
import FollowerItem from "./FollowerItem.vue";
import TextInput from "/resources/js/Components/TextInput.vue";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import { usePage } from "@inertiajs/vue3";


const authUser = usePage().props.auth.user;
const props = defineProps({
  followers: Object,

});

const userFollowers = computed(() => {
  return props.followers.filter(c => c.user.id == authUser.id);
 });


</script>

<template>

    <div class="lg:block hidden h-full">
  <div class="border bg-white p-3 h-[400px] lg:h-full flex flex-col">
    <h2 class="text-2xl font-bold mb-4">Followers</h2>
    <!-- <TextInput
      :model-value="searchKeyword"
      placeholder="Type to search"
      class="w-full"
    ></TextInput> -->
    <div class="mt-3 flex-1 overflow-auto">
      <div v-if="false" class="text-gray-400 flex text-center">
        There is nothing to show here
      </div>
      <div v-else>
        <div v-for="userfollower in userFollowers" :key="userfollower.id">
        <FollowerItem :userfollower="userfollower"></FollowerItem>

        </div>
      </div>
    </div>
  </div>
</div>

  <div class="lg:hidden block h-full">
    <Disclosure v-slot="{ open }">
      <DisclosureButton> 
        <h2 class="text-2xl font-bold mb-4">Followers</h2>
      </DisclosureButton>
 


      <DisclosurePanel>


        <div class="border bg-white p-3 h-[400px]  flex flex-col">
   
    <!-- <TextInput
      :model-value="searchKeyword"
      placeholder="Type to search"
      class="w-full"
    ></TextInput> -->
    <div class="mt-3 flex-1 overflow-auto">
      <div v-if="false" class="text-gray-400 flex text-center">
        There is nothing to show here
      </div>
      <div v-else>
        <div>{{ userFollowers }}</div>
      </div>
    </div>
  </div>
      
      </DisclosurePanel>
      
 

    </Disclosure>
  </div>
</template>

<style lang="scss" scoped></style>
