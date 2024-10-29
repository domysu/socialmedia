<script setup>
import { ref } from "vue";


const PostCreating = ref(false);

</script>

<template>
  <div>
    <div @click="PostCreating = true" class="py-2 px-2 mt-3 mb-3 border border-gray-400 rounded cursor-pointer">
      Click me to create new post
    </div>

    <div v-if="PostCreating" class="gap-3 flex justify-between">
      <button
        type="submit"
        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm 
               hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 
               focus-visible:outline-indigo-600 relative"
      >
        Attach Files
        <input type="file" class="absolute opacity-0 bottom-0 top-0 right-0 left-0" />
      </button>
      <button
        type="submit"
        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 
               focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
      >
        Submit
      </button>
    </div>
  </div>
</template>

<style>
/* Add styles here if needed */
</style>
