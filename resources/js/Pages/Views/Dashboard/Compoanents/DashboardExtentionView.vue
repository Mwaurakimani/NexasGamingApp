<script setup>
const active_moderator = null;
</script>

<template>
  <section class="w-[600px] h-[300px] hidden xl:block">
    <div class="w-full px-[5px] justify-between mx-auto rounded-md">
      <h2 class="text-[18px] mb-[5px]">Moderator</h2>
      <div v-if="active_moderator" class="w-[100%] h-[370px] bg-red-400 rounded shadow-lg">

      </div>
      <div v-else class="w-full">
        <p class="text-center p-[30px] bg-gray-200 font-bold">No Moderator details to display</p>
      </div>
    </div>
  </section>
</template>

<style scoped lang="scss">

</style>