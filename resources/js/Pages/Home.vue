<script setup>
import { Head, Link } from '@inertiajs/vue3';
import GroupList from '/resources/js/Components/app/GroupList.vue';
import GroupItem from '/resources/js/Components/app/GroupItem.vue';
import TextInput from '/resources/js/Components/TextInput.vue';
import FollowerList from '@/Components/app/FollowerList.vue';
import PostList from '@/Components/app/PostList.vue'
import CreatePost from '@/Components/app/CreatePost.vue';

defineProps({

});


</script>

<template>

    <Head title="Home page" />

    <div class="grid grid-cols-12 gap-3">
        <div class="col-span-3 min-h-44 py-6 px-3">
      <GroupList></GroupList>
        </div>
        <div class="col-span-6">
            <CreatePost></CreatePost>
            <PostList></PostList>
        </div>
        <div class="col-span-3 py-9 flex justify-start ml-5">
        <FollowerList></FollowerList>
        </div>
    </div>

</template>


<style></style>
