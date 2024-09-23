<script setup>

</script>

<template>
    <section class="pt-[20px]">
        <div class="flex justify-between mb-[20px]">
            <input type="file" class="">
            <button class="w-[100px] rounded">Upload</button>
        </div>
        <div>
            <ul class="w-full flex flex-wrap gap-1 justify-evenly">
                <li v-for="i in 8" class="w-[160px] h-[120px] bg-green-500"></li>
            </ul>
        </div>
    </section>
</template>

<style scoped lang="scss">
button {
    @apply bg-gray-300 ;

    &:hover {
        @apply bg-gray-400 text-white;
    }

    &:active {
        transition: all ease-in-out 0.3ms;
        @apply bg-gray-700 text-white;
    }
}

</style>
