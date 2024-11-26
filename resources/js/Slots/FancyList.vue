<script setup>
const  props = defineProps(['listItem'])
</script>

<template>
  <li class="mb-[20px]">
    <slot name="listItem" :listItem="listItem"></slot>
    <slot name="divider">

    </slot>
  </li>
</template>

<style scoped lang="scss">
li{
  @apply bg-gray-700 text-white p-[10px] text-sm rounded;
}
</style>