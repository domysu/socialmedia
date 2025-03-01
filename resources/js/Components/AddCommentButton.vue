
<script setup>
import axiosClient from '../axiosClient';
import { defineEmits, ref } from 'vue';
const comment = ref('');
const emit = defineEmits(['add-comment']);

</script>
<template>

<input class="rounded border-blue-200" placeholder="input your comment" type="text" v-model="comment" />
<button class="bg-blue-400 hover:bg-blue-500 p-2 rounded-md ml-2" @click="emit('add-comment', comment)">Add Comment</button>

</template>

<style lang="">
    
</style>