
<script setup>


const props = defineProps({
    group: Object,
});


</script>
<template>
    <a :href="route('group', {slug:props.group.slug})">
    <div class="flex items-center gap-3 mb-3 cursor-pointer hover:bg-gray-100 border-b">
        <img :src="'/img/default_avatar.png'" class="w-[48px] rounded" />
        <div>
            <h3 class="mb-2 text-xl font-black">{{ props.group.name }}</h3>
            <div class="text-xs text-gray-500">{{ props.group.name }}</div>
        </div>
    </div>
</a>
</template>


