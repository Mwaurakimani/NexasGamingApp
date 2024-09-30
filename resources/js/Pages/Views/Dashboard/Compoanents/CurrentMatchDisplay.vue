<script setup>
import MatchCard from "@/Components/App/MatchCard.vue";

const props = defineProps(['currentMatch','view'])
</script>

<template>
  <div  class="mb-[30px] md:mb-[50px] md:w-1/2 md:px-[10px]">
    <h2 class="text-[18px] mb-[5px]">Current Matches</h2>
    <MatchCard v-if="currentMatch" :match="currentMatch" :view="view" class="shadow lg:max-w-[600px]"></MatchCard>
    <div v-else class="w-full h-full">
      <p class="text-center p-[30px] bg-gray-200 md:h-full font-bold">There is currently no active match to
        display</p>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>