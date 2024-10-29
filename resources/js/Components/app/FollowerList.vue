<script setup>
    import FollowerItem from './FollowerItem.vue';
    import TextInput from '/resources/js/Components/TextInput.vue';
</script>

<template>
        <div class="px-4">
        <h2 class="text-2xl font-bold mb-4">Followers</h2>
            <TextInput :model-value="searchKeyword" placeholder="Type to search"></TextInput>
            <div class="py-9">
                <div v-if="false" class="text-gray-400 flex text-center">
                    There is nothing to show here
                </div>
                <div v-else>
                    <FollowerItem image="https://picsum.photos/id/200/100/100" title="Petras Grietininis"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />

                    <FollowerItem image="https://picsum.photos/id/200/100/100" title="Paulius Jadvyga"
                        description="Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit" />
                </div>
            </div>
        </div>
</template>



<style lang="scss" scoped>

</style>