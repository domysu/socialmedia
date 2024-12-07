<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import CKEditor from "../CKEditor.vue";
import { isImage } from "../../helpers.js";
import { XMarkIcon, DocumentIcon } from "@heroicons/vue/24/outline";

function onSubmit() {
  newPostForm.post(route("post.create"));
  PostCreating.value = false;

  attachmentFiles.value = [];
}

const attachmentFiles = ref([]);
async function onAttachmentChange($event) {
  console.log($event.target.files);

  for (const file of $event.target.files) {
    const reader = new FileReader();
    const myFile = {
      file,
      url: await readFile(file),
    };
    attachmentFiles.value.push(myFile);
  }
  $event.target.files = null;
  console.log(attachmentFiles.value);
}
async function readFile(file) {
  return new Promise((res, rej) => {
    if (isImage(file)) {
      const reader = new FileReader();
      reader.onload = () => {
        res(reader.result);
      };
      reader.onerror = rej;
      reader.readAsDataURL(file);
    } else {
      res(null);
    }
  });
}

function removeFile(myFile) {
  attachmentFiles.value = attachmentFiles.value.filter((f) => f != myFile);
}

const PostCreating = ref(false);
const newPostForm = useForm({
  body: "",
});
</script>

<template>
  <div
    @click="PostCreating = true"
    v-if="!PostCreating"
    class="p-3 flex justify-center mb-3 border border-gray-400 rounded cursor-pointer hover:bg-gray-200"
  >
    Click me to create new post
  </div>

  <CKEditor v-if="PostCreating" v-model="newPostForm.body"></CKEditor>

  <div class="grid grid-cols-2 gap-3 lg:grid-cols-3 place-items-center">
    <div
      v-for="myFile of attachmentFiles"
      class="w-full object-cover aspect-square relative mt-3"
    >
      <img
        v-if="isImage(myFile.file)"
        :src="myFile.url"
        class="cursor-pointer aspect-square"
      />
      <div
        v-else
        class="aspect-square bg-gray-300 flex flex-col justify-center items-center cursor-pointer"
      >
        <DocumentIcon class="size-6"></DocumentIcon>

        <small class="text-center"> {{ myFile.file.name }}</small>
      </div>
      <button
        @click="removeFile(myFile)"
        class="absolute top-0 right-0 p-2 hover:bg-gray-400"
      >
        <XMarkIcon class="size-5"></XMarkIcon>
      </button>
    </div>
  </div>

  <div v-if="PostCreating" class="gap-3 flex justify-between mt-3">
    <button
      class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 relative p-7"
    >
      Attach Files
      <input
        @change="onAttachmentChange"
        multiple
        type="file"
        class="absolute opacity-0 bottom-0 top-0 right-0 left-0"
      />
    </button>
    <button
      @click="onSubmit"
      type="submit"
      class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
    >
      Submit
    </button>
  </div>
</template>

<style></style>
