<template>

    <a :href="route('profile', {username:props.userfollower.follower.username})">
   
    <div class="flex items-center gap-2 mb-6 cursor-pointer hover:bg-gray-100 p-1 rounded-md ">
        <img :src="userfollower.follower.avatar_url" class="w-[52px] h-[52px] object-cover rounded-full" /> 
        <div>
            <h3 class="text-x font-black ">{{ userfollower.follower.name }}</h3>
        </div>
    </div>
    </a>
</template>

<script setup>
const props = defineProps({
   
    userfollower: Object,
});
</script>

<style>

</style>
