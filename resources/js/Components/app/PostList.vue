<template>
    <div class="mt-5">
        <PostItem :post="post1"></PostItem>
        <PostItem :post="post2"></PostItem>

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
    attachments: [
        {
            id: 1,
            name: 'test.png',
            url: 'https://picsum.photos/300',
            mime: 'image/png'
        }   ,
        {
            id: 2,
            name: 'test2.png',
            url: 'https://picsum.photos/300',
            mime: 'image/png'
        },
        {
            id: 3,
            name: 'MyDocument.docx',
            url: '#',
            mime: 'application/msword'
        }
    ],
    body: `<p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio quasi hic sunt odit, 
        similique veniam perspiciatis laborum obcaecati cupiditate, nostrum itaque velit saepe reprehenderit 
        debitis, asperiores quidem tempora voluptatum suscipit!
    </p>`,
    created_at: '2023-11-29 12:00'
};

const post2 = {
    user: {
        id: 2,
        avatar: 'https://randomuser.me/api/portraits/men/59.jpg',
        name: 'Andrew Tate'
    },
    group: {
        id: 1,
        name: 'Laravel Developers'
    },
    body: `<p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio quasi hic sunt odit, 
        similique veniam perspiciatis laborum obcaecati cupiditate, nostrum itaque velit saepe reprehenderit 
        debitis, asperiores quidem tempora voluptatum suscipit!
         Lorem ipsum dolor sit amet consectetur adipisicing elit. Distinctio quasi hic sunt odit, 
        similique veniam perspiciatis laborum obcaecati cupiditate, nostrum itaque velit saepe reprehenderit 
        debitis, asperiores quidem tempora voluptatum suscipit!
    </p>`,
 
    created_at: '2023-11-29 14:47'
};
</script>

<style lang="">
    
</style>
