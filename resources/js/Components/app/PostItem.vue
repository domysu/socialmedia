<template>
    <div>
        <div class="flex gap-3 items-center">
            <a href="javascript:void(0)">
                <img :src="post.user.avatar" class="w-[52px] rounded-full">

            </a>
            <div class="">
            <a href="javascript:void(0)">
            
                <h4 class="font-bold" >{{ post.user.name }}</h4>
            </a>
               <small class="text-gray-400">{{ post.created_at }}</small>
            </div>
        </div>
        <div class="mt-2" v-html="post.body">
        
        </div>
    </div>
</template>
<script setup>
    defineProps({
            post: Object   
    })
</script>
<style lang="">
    
</style>