<script setup>
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { XMarkIcon } from "@heroicons/vue/24/outline";
import { computed, defineEmits, defineProps, ref, Text } from "vue";
import TextInput from "./TextInput.vue";
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    modelValue: Boolean,
    group: Object,
});

const emit = defineEmits(["update:modelValue"]);
const show = computed({
    get: () => props.modelValue,
    set: (value) => {
        emit("update:modelValue", value);
    },
});


const formErrors = ref({});

function closeModal() {
    emit("update:modelValue", false);
}

     
    const form = useForm({
    identifier: '',
    })
function submit() {
  form.post(route('group.invite', props.group), {
    onSuccess(response){
        closeModal();
    },
    onError(error){

    }

  });
   
}
</script>
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
                        <DialogPanel
                            class="sm:w-full min-w-96 max-w-lg transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">

                            <button class="absolute right-0 top-0 p-1 mr-0.5" @click="closeModal">
                                <XMarkIcon class="w-6 h-6"></XMarkIcon>
                            </button>

                            <DialogTitle as="h3" class="text-lg font-medium leading-6 text-gray-900">
                                Invite user to group
                            </DialogTitle>

                            <div class="mt-2">
                                <p>
                                Input username or email of user you want to invite
                                </p>
                                <TextInput v-model="form.identifier"></TextInput>
                                <p v-if="form.errors.identifier" class="text-red-500 text-sm">{{ form.errors.identifier }}</p>
                            </div>

                            <div class="mt-4 flex justify-between">
                                <button type="button"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                    @click="submit">
                                    Submit
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>



<style></style>
