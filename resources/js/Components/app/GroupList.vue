<script setup>
    import GroupItem from '/resources/js/Components/app/GroupItem.vue';
    import TextInput from '/resources/js/Components/TextInput.vue';
</script>

<template>
        <div class="py-4 px-4">
        <h2 class="text-2xl font-bold mb-4">Groups</h2>
            <TextInput :model-value="searchKeyword" placeholder="Type to search"></TextInput>
            <div class="py-9">
                <div v-if="false" class="text-gray-400 flex text-center">
                    You have not joined any groups yet
                </div>
                <div v-else>
                    <GroupItem image="https://picsum.photos/id/237/200/300" title="Laravel developing"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />

                    <GroupItem image="https://picsum.photos/id/237/200/300" title="Laravel developing"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />
                </div>
            </div>
        </div>
</template>



<style lang="scss" scoped>

</style>