<script setup>
import GroupItem from "/resources/js/Components/app/GroupItem.vue";
import TextInput from "/resources/js/Components/TextInput.vue";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
</script>

<template>
  <div class="lg:hidden block">
    <Disclosure v-slot="{ open }">
      <DisclosureButton>
        <h2 class="text-2xl font-bold mb-4">Groups</h2>
      </DisclosureButton>
      <DisclosurePanel>
        <div class="border bg-white p-3 lg:h-full h-[400px] flex flex-col">
          <!-- <TextInput
            :model-value="searchKeyword"
            placeholder="Type to search"
            class="w-full"
          ></TextInput> -->
          <div class="mt-3 flex-1 overflow-auto">
            <div v-if="false" class="text-gray-400 flex text-center">
              You have not joined any groups yet
            </div>
            <div v-else>
              <GroupItem
                image="https://picsum.photos/id/237/200/300"
                title="Laravel developing"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
              />

              <GroupItem
                image="https://picsum.photos/id/237/200/300"
                title="Laravel developing"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
              />

              <GroupItem
                image="https://picsum.photos/id/237/200/300"
                title="Laravel developing"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
              />

              <GroupItem
                image="https://picsum.photos/id/237/200/300"
                title="Laravel developing"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
              />

              <GroupItem
                image="https://picsum.photos/id/237/200/300"
                title="Laravel developing"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
              />

              <GroupItem
                image="https://picsum.photos/id/237/200/300"
                title="Laravel developing"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
              />

              <GroupItem
                image="https://picsum.photos/id/237/200/300"
                title="Laravel developing"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
              />

              <GroupItem
                image="https://picsum.photos/id/237/200/300"
                title="Laravel developing"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
              />

              <GroupItem
                image="https://picsum.photos/id/237/200/300"
                title="Laravel developing"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
              />

              <GroupItem
                image="https://picsum.photos/id/237/200/300"
                title="Laravel developing"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
              />

              <GroupItem
                image="https://picsum.photos/id/237/200/300"
                title="Laravel developing"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
              />

              <GroupItem
                image="https://picsum.photos/id/237/200/300"
                title="Laravel developing"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
              />

              <GroupItem
                image="https://picsum.photos/id/237/200/300"
                title="Laravel developing"
                description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
              />
            </div>
          </div>
        </div>
      </DisclosurePanel>
    </Disclosure>
  </div>

  <div class="lg:block hidden h-full">
    <div class="border bg-white p-3 h-full flex flex-col">
      <h2 class="text-2xl font-bold mb-4">Groups</h2>
      <!-- <TextInput
        :model-value="searchKeyword"
        placeholder="Type to search"
        class="w-full"
      ></TextInput> -->
      <div class="mt-3 flex-1 overflow-auto">
        <div v-if="false" class="text-gray-400 flex text-center">
          You have not joined any groups yet
        </div>
        <div v-else>
          <GroupItem
            image="https://picsum.photos/id/237/200/300"
            title="Laravel developing"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
          />

          <GroupItem
            image="https://picsum.photos/id/237/200/300"
            title="Laravel developing"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
          />

          <GroupItem
            image="https://picsum.photos/id/237/200/300"
            title="Laravel developing"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
          />

          <GroupItem
            image="https://picsum.photos/id/237/200/300"
            title="Laravel developing"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
          />

          <GroupItem
            image="https://picsum.photos/id/237/200/300"
            title="Laravel developing"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
          />

          <GroupItem
            image="https://picsum.photos/id/237/200/300"
            title="Laravel developing"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
          />

          <GroupItem
            image="https://picsum.photos/id/237/200/300"
            title="Laravel developing"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
          />

          <GroupItem
            image="https://picsum.photos/id/237/200/300"
            title="Laravel developing"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
          />

          <GroupItem
            image="https://picsum.photos/id/237/200/300"
            title="Laravel developing"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
          />

          <GroupItem
            image="https://picsum.photos/id/237/200/300"
            title="Laravel developing"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
          />

          <GroupItem
            image="https://picsum.photos/id/237/200/300"
            title="Laravel developing"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
          />

          <GroupItem
            image="https://picsum.photos/id/237/200/300"
            title="Laravel developing"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
          />

          <GroupItem
            image="https://picsum.photos/id/237/200/300"
            title="Laravel developing"
            description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<style lang="scss" scoped></style>
