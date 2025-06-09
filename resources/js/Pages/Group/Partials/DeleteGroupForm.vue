<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingGroupDeletion = ref(false);
const passwordInput = ref(null);

const props = defineProps({
    group: Object,
});
const form = useForm({
    password: '',
});

const confirmGroupDeletion = () => {
    confirmingGroupDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteGroup = () => {
    form.delete(route('group.destroy', props.group), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingGroupDeletion.value = false;
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Delete Group
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Once this group is deleted, all of its resources and data will
                be permanently deleted. Before deleting this group, please
                download any data or information that you wish to retain.
            </p>
        </header>

        <DangerButton @click="confirmGroupDeletion">Delete Group</DangerButton>

        <Modal :show="confirmingGroupDeletion" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100"
                >
                    Are you sure you want to delete this group?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Once this group is deleted, all of its resources and data
                    will be permanently deleted. Please enter your password to
                    confirm you would like to permanently delete this group.
                </p>

                <div class="mt-6">
                    <InputLabel
                        for="password"
                        value="Password"
                        class="sr-only"
                    />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Password"
                        @keyup.enter="deleteGroup"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteGroup"
                    >
                        Delete Group
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
