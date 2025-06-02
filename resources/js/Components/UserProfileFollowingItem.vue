
<script setup>
import FollowingItem from './app/FollowingItem.vue';

const props = defineProps({
    following: Object
})
</script>
<template lang="">
    <div>
    
       <FollowingItem :userfollower="following"></FollowingItem>
    </div>
</template>

<style lang="">
    
</style>