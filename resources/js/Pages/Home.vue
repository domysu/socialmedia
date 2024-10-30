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

    <div class="grid lg:grid-cols-12 gap-3 p-3 lg:order-1">
        <div class="lg:col-span-3">
      <GroupList></GroupList>
        </div>
        <div class="lg:col-span-3 lg:order-3">
        <FollowerList></FollowerList>
        </div>
        <div class="lg:col-span-6 lg:order-2">
            <CreatePost></CreatePost>
            <PostList></PostList>
        </div>
       
    </div>

</template>


<style></style>
