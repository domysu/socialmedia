<script setup>
import FollowerItem from "./FollowerItem.vue";
import TextInput from "/resources/js/Components/TextInput.vue";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
</script>

<template>

    <div class="lg:block hidden h-full">
  <div class="border bg-white p-3 h-[400px] lg:h-full flex flex-col">
    <h2 class="text-2xl font-bold mb-4">Followers</h2>
    <TextInput
      :model-value="searchKeyword"
      placeholder="Type to search"
      class="w-full"
    ></TextInput>
    <div class="mt-3 flex-1 overflow-auto">
      <div v-if="false" class="text-gray-400 flex text-center">
        There is nothing to show here
      </div>
      <div v-else>
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Petras Grietininis"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />

        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
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
   
    <TextInput
      :model-value="searchKeyword"
      placeholder="Type to search"
      class="w-full"
    ></TextInput>
    <div class="mt-3 flex-1 overflow-auto">
      <div v-if="false" class="text-gray-400 flex text-center">
        There is nothing to show here
      </div>
      <div v-else>
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Petras Grietininis"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />

        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
        <FollowerItem
          image="https://picsum.photos/id/200/100/100"
          title="Paulius Jadvyga"
          description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
        />
      </div>
    </div>
  </div>
      
      </DisclosurePanel>
      
 

    </Disclosure>
  </div>
</template>

<style lang="scss" scoped></style>
