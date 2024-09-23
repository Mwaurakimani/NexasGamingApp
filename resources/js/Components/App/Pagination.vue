<script setup>
const props = defineProps(['payload'])
</script>

<template>
    <ul v-if="payload && payload.links.length > 3" class="flex gap-x-2 overflow-auto">
        <li v-for="item in payload.links">
            {{}}
            <Link v-html="item.label" v-if="item.url != null" as="button" :href="item.url??'#'" class="!px-[9px]" :class="[item.active ?'active':'']"></Link>
        </li>
    </ul>
</template>

<style scoped lang="scss">
button {
    @apply bg-gray-300 px-[30px] py-[5px] rounded;

    &:hover{
        transition: all ease-in-out 0.3ms;
        @apply bg-gray-500 text-white;
    }

    &:active {
        transition: all ease-in-out 0.3ms;
        @apply bg-gray-700 text-white;
    }
}

button.active{
    @apply bg-gray-700 text-white;
}
</style>
