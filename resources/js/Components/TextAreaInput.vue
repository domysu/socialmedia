
<template>
        <textarea class="w-full overflow-hidden resize-none rounded" @input="onInputChange"></textarea>
    
</template>
<script setup>
import { defineEmits } from 'vue';


const emit = defineEmits(['update:modelValue'])

function onInputChange($event){
    emit('update:modelValue', $event.target.value)

    const textarea = event.target;
  textarea.style.height = "auto";
  textarea.style.height = `${textarea.scrollHeight}px`;

}

</script>
<style>
    
</style>