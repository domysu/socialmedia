<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { router } from "@inertiajs/vue3";
const props = defineProps({

    groups: Object,

})

function toGroup(group) {
    router.get(route('group', group));
}
</script>

<template lang="">
    <AuthenticatedLayout>
        <div class="grid grid-cols-12">
        <div class="col-start-4 col-span-6 mt-2">
            
    <div v-for="group in props.groups.data" class="bg-white hover:bg-slate-200 cursor-pointer" @click="toGroup(group)">
    
    <div class="flex items-center mb-2 p-2">
    <img :src="group.thumbnail_path" @error="group.thumbnail_path = 'https://picsum.photos/100'" 
    class="w-[64px] h-[64px] rounded-full object-cover"
    >
    <p class="font-bold ml-2">{{group.name}}</p>
    
     </div>
    
    </div>
    </div>
</div>
    </AuthenticatedLayout>
</template>
