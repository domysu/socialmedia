<script setup>
import { ref } from "vue";
import TextAreaInput from '@/Components/TextAreaInput.vue'
import { useForm } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";


function onSubmit() {

    newPostForm.post(route('post.create'));
    PostCreating.value = false;
}

const PostCreating = ref(false);
const newPostForm = useForm({
    body: ''

})


</script>

<template>
  <div>
    <div
      @click="PostCreating = true"
      v-if="!PostCreating"
      class="p-3 flex justify-center mb-3 border border-gray-400 rounded cursor-pointer hover:bg-gray-200"
    >
      Click me to create new post
    </div>

    <TextAreaInput v-if="PostCreating" v-model="newPostForm.body"></TextAreaInput>
  

    <div v-if="PostCreating" class="gap-3 flex justify-between">
      <button
        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 relative"
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
