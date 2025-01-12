<template>
  <TransitionRoot appear :show="show" as="template">
    <Dialog as="div" @close="closeModal" class="relative z-10">
      <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
        leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-black/25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
          <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95">
            <div>
              <DialogPanel
                class="sm:w-full min-w-96 max-w-lg transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">

                <button class="absolute right-0 top-0 p-1 mr-0.5" @click="closeModal">
                  <XMarkIcon class="w-6 h-6"></XMarkIcon>

                </button>

                <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">

                  {{ props.post.id ? "Edit Post" : "Create Post" }}
                </DialogTitle>
                <div class="mt-2">
                  <CKEditor :post="props.post" v-model="props.post.body"></CKEditor>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-2">

                  <template v-for="myFile in computedAttachmentFiles" class="relative group object-cover aspect-square">
                    <div
                      class="relative group object-cover aspect-square flex flex-col justify-center items-center bg-gray-200">
                      <img :src="myFile.url" v-if="isImage(myFile.file || myFile)" class="aspect-square" />
                      <template v-else>
                        <small class="text-center">{{ (myFile.file || myFile).name }}</small>
                        <PaperClipIcon class="h-6 w-6"></PaperClipIcon>
                      </template>


                      <button @click="onAttachmentDelete(myFile)"
                        class="absolute right-0 top-0 bg-gray-300 opacity-0 group-hover:opacity-100">
                        <XMarkIcon class="size-6 hover:opacity-50"></XMarkIcon>
                      </button>


                      <div v-if="myFile.deleted"
                        class="absolute bottom-0 bg-gray-700 font-bold text-white p-1 w-full text-base text-center opacity-50 hover:opacity-100 cursor-pointer"
                        @click="undoAttachmentDelete(myFile)">

                        <small>To be deleted</small>
                      </div>
                    </div>
                  </template>
                </div>



                <div class="mt-4 flex justify-between">
                  <button type="button"
                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                    @click="submit()">
                    Submit
                  </button>
                  <button type="button"
                    class=" relative inline-flex justify-center rounded-md border border-transparent bg-gray-300 px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2">
                    <input type="file" class="opacity-0 right-0 top-0 bottom-0 left-0 absolute cursor-pointer"
                      @change="onAttachmentChange" multiple />
                    Attach Files
                  </button>
                </div>
              </DialogPanel>
            </div>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from "@headlessui/vue";
import { useForm, router } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import CKEditor from "./CKEditor.vue";
import { isImage } from "../helpers.js";
import { PaperClipIcon, XMarkIcon, ArrowUturnLeftIcon } from "@heroicons/vue/24/outline";
import { defineProps, defineEmits } from "vue";
const props = defineProps({
  post: {
    type: Object,
    required: true,
  },
  modelValue: Boolean,
});

// merge the attachments from the post object with the attachments from the attachmentFiles array
const computedAttachmentFiles = computed(() => {
  return [...attachmentFiles.value, ...props.post.attachments];
});
const emit = defineEmits(["update:modelValue"]);
const deletedAttachments = ref([]);

function closeModal() {
  show.value = false;
  if (!props.post.id) {
    show.value = false;
    props.post.body = "";
    props.post.attachments = [];
  }
}

const show = computed({
  get: () => props.modelValue,
  set: (value) => {
    emit("update:modelValue", value);
  },
});

function undoAttachmentDelete(attachment) {
  attachment.deleted = false;
  deletedAttachments.value = deletedAttachments.value.filter((a) => a !== attachment.id);
}
function onAttachmentDelete(attachment) {
  if (attachment.id) {
    attachment.deleted = true;
    deletedAttachments.value.push(attachment.id);
  } else {
    attachmentFiles.value = attachmentFiles.value.filter((a) => a !== attachment);
  }
  ;
}

function submit() {
  const form = useForm({
    id: props.post.id,
    body: props.post.body,
    attachments: attachmentFiles.value,
    deletedAttachments: deletedAttachments.value,
    _method: props.post.id ? "put" : "post" // set the method to put if the post has an id, else set it to post. Because HTML forms do not support put method
  });

  if (props.post.id) {
    form.attachments = attachmentFiles.value.map(myFile => myFile.file) // map attachments to the post object
    form.post(route("post.update", props.post.id), {
      onSuccess: () => {
        closeModal();
      }

    });


  } else {

    props.post.attachments = attachmentFiles.value.map(myFile => myFile.file) // map attachments to the post object
    form.post(route("post.create", props.post), {
      onSuccess: () => {
        closeModal();
      }
    });

  }
  props.post.attachments = [];
  props.post.body = "";
  attachmentFiles.value = [];
  deletedAttachments.value = [];
}

const attachmentFiles = ref([]);

async function onAttachmentChange($event) {
  for (const file of $event.target.files) {
    const myFile = {
      file,
      url: await readFile(file),
    };
    attachmentFiles.value.push(myFile);
  }
  $event.target.files = null;
}

async function readFile(file) {
  return new Promise((res, rej) => {
    if (isImage({ mime: file.type })) {
      const reader = new FileReader();
      reader.onload = () => {
        res(reader.result);
      };
      reader.onerror = rej;
      reader.readAsDataURL(file);
    } else {
      console.log("Not an image");
      res(null);
    }
  });
}


</script>

<style></style>
