
<script setup>
import { defineProps} from "vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { EmitterMixin } from "ckeditor5";

const props = defineProps({
    attachment: {
        type: Object,
        required: true,
    },
    modelValue: Boolean,
});




</script>
<template>
   
    
    <div class="z-40 flex justify-center items-center fixed inset-0 p-1 pointer-events-auto bg-gray-900 bg-opacity-95">
    <div class="relative w-[85%] h-[80%] object-contain">
        <img :src="attachment.url" class="w-full h-full" />

       
    </div>
    <button class="absolute right-0 top-0 p-2  text-white rounded-full" @click="$emit('close')">
            <XMarkIcon class="h-8 w-8"></XMarkIcon>
        
        </button>
     </div>
    
    
</template>

<style lang="">
    
</style>