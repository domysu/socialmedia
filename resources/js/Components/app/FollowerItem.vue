<template>
    <div class="flex items-center gap-2 mb-6 cursor-pointer hover:bg-gray-100">
        <img :src="image" class="w-[48px] rounded-full" /> 
        <div>
            <h3 class="mb-2 text-x font-black">{{ title }}</h3>
        </div>
    </div>
</template>

<script setup>
defineProps({
    image: String,
    title: String,
    description: String
});
</script>

<style>

</style>
