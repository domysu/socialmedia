
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';



const props =  defineProps({
    body: String,

});
</script>
<template>
      <AuthenticatedLayout>
    <div class="flex justify-center mt-64">
  
  
    
    <h1 class="bg-red-500 p-2 text-white text-3xl">{{ props.body }}</h1>
    </div>
    </AuthenticatedLayout>
</template>
<style lang="">
    
</style>