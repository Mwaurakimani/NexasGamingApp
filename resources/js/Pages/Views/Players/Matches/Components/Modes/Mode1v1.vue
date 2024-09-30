<script setup>
import MarkdownRender from "@/Components/App/MarkdownRender.vue";

const props = defineProps(['match'])
</script>

<template>
  <MarkdownRender class="mb-[40px]" :source="match.notes ?? ''"></MarkdownRender>
</template>

<style scoped lang="scss">

</style>