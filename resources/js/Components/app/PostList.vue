

<script setup>
import { root } from "postcss";
import PostItem from "./PostItem.vue";
import axiosClient from "../../axiosClient";
import { onMounted, onUpdated, ref } from "vue";
import { usePage } from "@inertiajs/vue3";
const props = defineProps({
  posts: Array,
});


const page = usePage();

const allPosts = ref({
data: page.props.posts.data,
next: page.props.posts.links.next,

});

const loadMoreIntersect = ref(null);

function loadMore(){
  console.log("load more posts");

  axiosClient.get(allPosts.value.next)
  .then(({data}) => {
   
      
      allPosts.value.data = [...allPosts.value.data, ...data.data];
      allPosts.value.next = data.links.next;
    
  })
  .catch(err => {
    console.log(err);
  });
}

onMounted(() => {
const observer = new IntersectionObserver((entries) => 
  entries.forEach(entry => entry.isIntersecting && loadMore()), {
   rootMargin: "0px 0px 100px 0px",
    
  });
  observer.observe(loadMoreIntersect.value);

});









</script>


<template>
  <div class="mt-5">
    <PostItem
      v-for="post of allPosts.data"
      :key="post.id"
      :post="post"
    ></PostItem>
    <div class="h-[50px]" ref="loadMoreIntersect"></div>
  </div>
</template>