<template>
    <div class="border bg-white rounded p-4 mb-5">
        <div class="flex gap-3 items-center">
            <a href="javascript:void(0)">
                <img :src="post.user.avatar" class="w-[52px] rounded-full border border-2 hover:border-blue-400">

            </a>
        
            <div class="">
           
            
                <h4 class="font-bold" >
                    <a href="javascript:void(0)" class="hover:underline">{{ post.user.name }} </a>   
                    <template v-if="post.group">
                    >
                      <a href="javascript:void()" class="hover:underline">{{ post.group.name }}</a>
                    </template>
                </h4> 

               <small class="text-gray-400">{{ post.created_at }}</small>
            </div>
        </div>

        <Disclosure v-slot="{ open }">
        <div v-if="!open" class="mt-2" v-html="post.body.substring(0,100)"></div>
        <DisclosurePanel>
        <div class="mt-2" v-html="post.body"/>
        
        </DisclosurePanel>
        
     
        <div class="flex justify-end">
            <DisclosureButton class="text-blue-500 hover:underline">
          {{ open ? 'Read less' : 'Read More' }}
        </DisclosureButton>
        </div>

      </Disclosure>
      <div class="grid grid-cols-2 lg:grid-cols-3 place-items-center">
        <div v-for="attachment of post.attachments" class="w-full object-cover aspect-square">

        <img v-if="isImage(attachment)":src="attachment.url" class="cursor-pointer aspect-square">
        <div v-else class="aspect-square bg-gray-100 flex flex-col justify-center items-center cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
</svg>


        {{ attachment.name }}
        </div>
        
        
        </div>
      </div>

      <div>
      <button>

        Like
      </button>

      <button>
        Comment
      </button>
      </div> 
        
        
    </div>
</template>
<script setup>

import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
    defineProps({
            post: Object   
    })


function isImage(attachment)
{
    const mime = attachment.mime.split('/');


    return mime[0].toLowerCase() == 'image';

}
</script>
<style lang="">
    
</style>