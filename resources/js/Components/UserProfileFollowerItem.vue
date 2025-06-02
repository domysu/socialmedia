
<script setup>
import FollowerItem from './app/FollowerItem.vue';

const props = defineProps({
    follower: Object
})
</script>
<template lang="">
    <div>
    
       <FollowerItem :userfollower="follower"></FollowerItem>
    </div>
</template>

<style lang="">
    
</style>