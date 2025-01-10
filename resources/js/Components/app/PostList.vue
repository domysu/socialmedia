<template>
  <div class="mt-5">
    <PostItem
      v-for="post of posts"
      :key="post.id"
      :post="post"
      :isButtonPressed="isButtonPressed"
    ></PostItem>
  </div>
</template>

<script setup>
import PostItem from "./PostItem.vue";

defineProps({
  isButtonPressed: Boolean,
  posts: Array,
});
</script>
