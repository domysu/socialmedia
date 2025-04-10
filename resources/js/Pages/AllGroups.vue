<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
const props = defineProps({

groups: Object,

})
</script>

<template lang="">
    <AuthenticatedLayout>

    <div v-for="group in props.groups.data" class="bg-white">
    <div class="flex items-center mb-2 p-2">
    <img :src="group.thumbnail_path" @error="group.thumbnail_path = 'https://picsum.photos/100'" 
    class="w-[64px] h-[64px] rounded-full object-cover"
    >
    <p class="font-bold ml-2">{{group.name}}</p>
     </div>
    </div>
    </AuthenticatedLayout>
</template>

