<template>
    <div>
        <PostItem :post="post1"></PostItem>
    </div>
</template>

<script setup>
import PostItem from './PostItem.vue';

const post1 = {
    user: {
        id: 1,
        avatar: 'https://randomuser.me/api/portraits/men/60.jpg',
        name: 'John Smith'
    },
    group: null,
    body: `<p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio quasi hic sunt odit, 
        similique veniam perspiciatis laborum obcaecati cupiditate, nostrum itaque velit saepe reprehenderit 
        debitis, asperiores quidem tempora voluptatum suscipit!
    </p>`,
    created_at: '2023-11-29 12:00'
};
</script>

<style lang="">
    
</style>
