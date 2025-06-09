<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import UpdateGroupInformationForm from './Partials/UpdateGroupInformationForm.vue';
import UpdateGroupAboutForm from './Partials/UpdateGroupAboutForm.vue';
import DeleteGroupForm from './Partials/DeleteGroupForm.vue';


const props = defineProps({

    group: Object,

});

</script>

    
    
<template>
  
    <AuthenticatedLayout>
   
  <template>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200 h-full"
            >
                Group
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <div>
                   <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
                >
                    <UpdateGroupInformationForm :group="props.group"></UpdateGroupInformationForm>
                </div>
                
                
                </div>
                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
                >
                <UpdateGroupAboutForm :group="props.group"></UpdateGroupAboutForm>
                </div>

                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
                >
                <DeleteGroupForm :group="props.group"></DeleteGroupForm>
                </div>

                <div
                    class="bg-white p-4 shadow sm:rounded-lg sm:p-8 dark:bg-gray-800"
                >
                    
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

