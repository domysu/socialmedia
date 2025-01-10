<script setup>
import PostModal from "../PostModal.vue";
import { ref } from "vue";
const OpenModal = ref(false); // This is the state that will be used to open the modal

function createPost() {
  OpenModal.value = true;
}


const newPostForm = ref({
  body: "",
  attachments: [],
});
</script>

<template>
  <div
    class="p-3 flex justify-center mb-3 border border-gray-400 rounded cursor-pointer hover:bg-gray-200"
    @click="createPost"
  >
    Click me to create new post
  </div>

  <PostModal :post="newPostForm" v-model="OpenModal"></PostModal>
</template>

<style></style>
