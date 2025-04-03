<script setup>
import { Head, Link } from "@inertiajs/vue3";
import GroupList from "/resources/js/Components/app/GroupList.vue";
import FollowerList from "@/Components/app/FollowerList.vue";
import PostList from "@/Components/app/PostList.vue";
import CreatePost from "@/Components/app/CreatePost.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { defineProps, ref } from "vue";

defineProps({
  posts: Object,
  groups: Object,
  followers: Object,
});


</script>

<template>
  <AuthenticatedLayout>


      
    <Head title="Home" />
    <div class="grid lg:grid-cols-12 gap-3 p-3 lg:order-1 h-full">
      <div class="lg:col-span-3 h-full overflow-hidden">
        <GroupList :groups="groups.data"></GroupList>
      </div>
      <div class="lg:col-span-3 lg:order-3 h-full overflow-hidden">
        <FollowerList></FollowerList>
      </div>
      <div class="lg:col-span-6 lg:order-2 h-full overflow-auto">
        <CreatePost></CreatePost>
        <PostList :posts="posts.data"></PostList>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<style></style>
