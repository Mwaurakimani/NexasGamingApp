<script setup>

</script>

<template>
    <ul class="flex gap-x-2">
        <li>
            <button>Previous</button>
        </li>
        <li>
            <button class="!px-[9px]">1</button>
        </li>
        <li>
            <button class="!px-[9px]">2</button>
        </li>
        <li>
            <button class="!px-[9px]">3</button>
        </li>
        <li>
            <button class="!px-[9px]">4</button>
        </li>
        <li>
            <button class="!px-[9px]">5</button>
        </li>
        <li>
            <button class="!px-[9px]">6</button>
        </li>
        <li>
            <button class="!px-[9px]">7</button>
        </li>
        <li>
            <button class="!px-[9px]">8</button>
        </li>
        <li>
            <button>Next</button>
        </li>
    </ul>
</template>

<style scoped lang="scss">
button {
    @apply bg-gray-300 px-[30px] py-[5px] rounded;
    &:active {
        transition: all ease-in-out 0.3ms;
        @apply bg-gray-700 text-white;
    }
}
</style>
