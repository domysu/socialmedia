<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import CKEditor from '../CKEditor.vue'



function onSubmit() {
    console.log("body: ", newPostForm.body)
    newPostForm.post(route('post.create'));
 
    PostCreating.value = false;
}

const PostCreating = ref(false);
const newPostForm = useForm({
    body: ''

})


</script>

<template>
  <div class="">
    <div
      @click="PostCreating = true"
      v-if="!PostCreating"
      class="p-3 flex justify-center mb-3 border border-gray-400 rounded cursor-pointer hover:bg-gray-200 "
    >
      Click me to create new post
    </div>

    <CKEditor v-if="PostCreating" v-model="newPostForm.body"></CKEditor>
 
  

    <div v-if="PostCreating" class="gap-3 flex justify-between mt-3">
      <button
        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 relative p-7"
      >
        Attach Files
        <input type="file" class="absolute opacity-0 bottom-0 top-0 right-0 left-0" />
      </button>
      <button
        @click="onSubmit"
        type="submit"
        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
      >
        Submit
      </button>
    </div>
  </div>
</template>

<style></style>
