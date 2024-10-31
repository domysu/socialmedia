<script setup>
    import GroupItem from '/resources/js/Components/app/GroupItem.vue';
    import TextInput from '/resources/js/Components/TextInput.vue';
</script>

<template>
        <div class="border bg-white p-3 lg:h-full h-[400px] flex flex-col">
        <h2 class="text-2xl font-bold mb-4">Groups</h2>
            <TextInput :model-value="searchKeyword" placeholder="Type to search" class="w-full"></TextInput>
            <div class=" mt-3 flex-1  overflow-auto">
                <div v-if="false" class="text-gray-400 flex text-center">
                    You have not joined any groups yet
                </div>
                <div v-else>
                    <GroupItem image="https://picsum.photos/id/237/200/300" title="Laravel developing"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />

                    <GroupItem image="https://picsum.photos/id/237/200/300" title="Laravel developing"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />

                        
                    <GroupItem image="https://picsum.photos/id/237/200/300" title="Laravel developing"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />
                        
                        
                    <GroupItem image="https://picsum.photos/id/237/200/300" title="Laravel developing"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />
                        
                    <GroupItem image="https://picsum.photos/id/237/200/300" title="Laravel developing"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />
                        
                    <GroupItem image="https://picsum.photos/id/237/200/300" title="Laravel developing"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />
                        
                    <GroupItem image="https://picsum.photos/id/237/200/300" title="Laravel developing"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />
                        
                    <GroupItem image="https://picsum.photos/id/237/200/300" title="Laravel developing"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />
                        
                    <GroupItem image="https://picsum.photos/id/237/200/300" title="Laravel developing"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />
                        
                    <GroupItem image="https://picsum.photos/id/237/200/300" title="Laravel developing"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />
                        
                    <GroupItem image="https://picsum.photos/id/237/200/300" title="Laravel developing"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />
                        
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