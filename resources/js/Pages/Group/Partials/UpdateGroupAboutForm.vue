<script setup>
import CKEditor from '@/Components/CKEditor.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { usePage, useForm } from '@inertiajs/vue3';
import { ref, watchEffect } from 'vue';


const props = defineProps({
    group: Object
})

const user = usePage().props.auth.user;
const form = useForm({
    about: props.group.about,
    name: props.group.name,
    slug: props.group.slug
});


</script>
<template lang="">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                About group
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Edit about group field
            </p>
        </header>
            <form
            @submit.prevent="form.patch(route('group.update', props.group))"
            class="mt-6 space-y-6"
            >
        <div class="w-full">
            <CKEditor :output="props.group.about"  v-model="form.about"></CKEditor>
            
           
             <InputError class="mt-2" :message="form.errors.about" />
        </div>
        
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
            </form>

</template>

<style lang="">
    
</style>