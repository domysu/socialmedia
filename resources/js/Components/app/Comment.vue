<script setup>
import { ref } from 'vue';
import axiosClient from '../../axiosClient';
import { router } from "@inertiajs/vue3";
import dayjs from 'dayjs';


const props = defineProps({
    post: Object,
})

const comment = ref('');
function addComment() {
    axiosClient.post(route('post.comment', props.post), {
        comment: comment.value,
    }).then(response => {
        props.post.comment.push(response.data);
        console.log(response.data);
        comment.value = '';
    }).catch(error => {
        console.log(error.response.data);
    });
}

function ToProfile(user) {
    router.get(route('profile', user));
}

</script>
<template>


    <input class="rounded border-blue-200" placeholder="input your comment" type="text" v-model="comment" />
    <button class="bg-blue-400 hover:bg-blue-500 p-2 rounded-md ml-2" @click="addComment">Add Comment</button>
    <div class="bg-gray-50 rounded border-none" v-for="comment in props.post.comment" :key="comment.id">
        <div class="mt-3 border-none p-3 rounded">
            <div class="flex items-center gap-3">
                <a href="#" @click="ToProfile(comment.user)" class="rounded-full">
                    <img :src="comment.user.avatar_url || '/img/default_avatar.png'"
                        @error="comment.user.avatar_url = '/img/default_avatar.png'"
                        class="w-[48px] h-[48px] rounded-full border-2 hover:border-blue-400" />
                </a>


                <h3 class="font-bold">
                    <a href="#" @click="ToProfile(comment.user)" class="hover:underline">{{ comment.user.name }}</a>
                </h3>

            </div>
            <small class="text-gray-400">{{ dayjs(comment.created_at).format('MMMM D, YYYY h:mm A') }}</small>

            <p>{{ comment.comment }}</p>

        </div>
    </div>




</template>