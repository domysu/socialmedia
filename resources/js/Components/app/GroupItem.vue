<template>
    <div class="flex items-center gap-3 mb-3 cursor-pointer hover:bg-gray-100">
        <img :src="image" class="w-[48px] rounded" /> 
        <div>
            <h3 class="mb-2 text-xl font-black">{{ title }}</h3>
            <div class="text-xs text-gray-500">{{ description }}</div>
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
