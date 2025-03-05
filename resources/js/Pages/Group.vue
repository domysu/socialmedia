
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { defineProps, ref } from "vue";

const isInGroup = ref(true);
const props = defineProps({
    group: Object,
})

function joinGroup(){
    isInGroup.value = true;
}
function leaveGroup(){
    isInGroup.value = false;
}

</script>
<template>
    
    <AuthenticatedLayout>
        <Head title="Group" />
        <div class="mx-12 mt-5">
        <div class="bg-white rounded shadow-lg"> 
        <img class="w-full h-40 rounded" src="https://picsum.photos/2000/300"></img>
        <div class="flex items-center gap-3 p-3">
            <div class="w-24 h-24 rounded-full overflow-hidden">
                <img class="w-full h-full object-cover" src="https://picsum.photos/600"> </img>
            </div>
            <div>
                <h3 class="mb-2 text-xl font-black">Group name</h3>
                <div class="text-xs text-gray-500">Group description</div>
            </div>
            </div>
            <div class="flex p-2 gap-2 justify-between">
            <div class="flex gap-2" v-if="isInGroup">
                <button class="bg-gray-200 hover:bg-gray-300 p-2">Users</button>
                <button class="bg-gray-200 hover:bg-gray-300 p-2">Menu Item 2</button>
                <button class="bg-gray-200 hover:bg-gray-300 p-2">Menu Item 3</button>
            </div>
            <div v-else>
              
            </div>
            <div>
                <button class="bg-emerald-300 hover:bg-emerald-400 p-2" @click="joinGroup" v-if="!isInGroup">Join</button> 
                <button class="bg-red-500 hover:bg-red-600 p-2" @click="leaveGroup"v-if="isInGroup">Leave</button>
            </div>
            </div>
        </div>
        </div>
    </AuthenticatedLayout>
</template>

<style lang="">
    
</style>