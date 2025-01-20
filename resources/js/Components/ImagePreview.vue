<script setup>
import { defineProps } from "vue";
import { XMarkIcon, ArrowRightIcon, ArrowLeftIcon } from "@heroicons/vue/24/outline";
import { isImage } from "../helpers.js";
import { EmitterMixin } from "ckeditor5";

const props = defineProps({
    attachment: {
        type: Object,
        required: true,
    },
    modelValue: Boolean,
});

function checkImage() {
    console.log(isImage(props.attachment));
}


</script>
<template>


    <div
        class="z-40 flex justify-between  items-center fixed inset-0 p-1 pointer-events-auto bg-gray-900 bg-opacity-95">


        <div>
            <button class="ml-4 p-2 text-white rounded-full" @click="$emit('prev')">
                <ArrowLeftIcon class="h-12 w-12"></ArrowLeftIcon>
            </button>

        </div>
        <div class="relative w-[85%] h-[80%] object-contain">
            <img v-if="isImage(attachment)" :src="attachment.url" class="w-full h-full" />
            <div v-else class="border-2 border-gray-200 bg-gray-700 w-full h-full flex items-center justify-center">
                <h1 class="text-3xl text-gray-200">{{ attachment.name }}</h1>


            </div>


        </div>
        <div>
            <button class="mr-4 p-2 text-white rounded-full" @click="$emit('next')">
                <ArrowRightIcon class="h-12 w-12"></ArrowRightIcon>
            </button>
        </div>
        <button class="absolute right-0 top-0 p-2  text-white rounded-full" @click="$emit('close')">
            <XMarkIcon class="h-8 w-8"></XMarkIcon>

        </button>
    </div>



</template>

<style lang="">

</style>