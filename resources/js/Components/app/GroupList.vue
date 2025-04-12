<script setup>
import GroupItem from "/resources/js/Components/app/GroupItem.vue";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import GroupModal from "./GroupModal.vue";
import { ref, defineProps } from "vue";
import { usePage } from "@inertiajs/vue3";


const authUser = usePage().props.auth.user;
const isGroupCreateModalOpen = ref(false);




const props = defineProps({
  groups: Array,

});
const groupArray = props.groups.filter(group =>
  group.users.some(c => c.user_id === authUser.id)
);

</script>

<template>
  <div class="lg:hidden block">
    <Disclosure v-slot="{ open }">
      <DisclosureButton>
        <h2 class="text-2xl font-bold mb-4">Groups</h2>

      </DisclosureButton>
      <DisclosurePanel>

        <div class="border bg-white p-3 lg:h-full h-[400px] flex flex-col">
          <div>
            <button @click="isGroupCreateModalOpen = true" class="bg-cyan-500 p-2 text-sm rounded-md"> Create group
            </button>
          </div>
          <GroupModal v-model="isGroupCreateModalOpen"></GroupModal>

          <div class="mt-3 flex-1 overflow-auto">
        
            <div v-if="!props.groups" class="text-gray-400 flex text-center">
              You have not joined any groups yet
            </div>
            <div v-else>

              <GroupItem v-for="group of groupArray" :key="group.id" :group="group"></GroupItem>
            </div>
          </div>
        </div>
      </DisclosurePanel>
    </Disclosure>
  </div>

  <div class="lg:block hidden h-full group/list">
    <div class="border bg-white p-3 h-full flex flex-col ">
      <div class="justify-between flex items-center p-2">
        <h2 class="text-2xl font-bold">Groups</h2>
        <div>

          <button @click="isGroupCreateModalOpen = true" class="bg-cyan-500 hover:bg-cyan-300 hover p-2 text-sm rounded-md opacity-0 group-hover/list:opacity-100 text-white"> 
          Create group
          </button>

        </div>
      </div>
      <GroupModal v-model="isGroupCreateModalOpen"></GroupModal>
      <div class="mt-3 flex-1 overflow-auto">
      
        <div v-if="groupArray === ' '" class="text-gray-400 flex text-center">
          You have not joined any groups yet
        </div>
        <div v-else>

          <GroupItem v-for="group of groupArray" :key="group.id" :group="group"></GroupItem>
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped></style>
