<script setup>

</script>

<template>
  <div v-if="results" class="border-1 border-gray-200 p-[10px] rounded mb-[30px]">
    <ul class="">
      <li class="flex py-[10px] border-b-2 justify-between">
        <p>Score</p>
        <strong>5</strong>
      </li>
      <li class="flex py-[10px] border-b-2 justify-between">
        <p>Winning</p>
        <strong>
          <div class="flex justify-center items-center mb-[10px]">
            <img class="w-[20px]" src="/storage/system/Coin%20Dark.png">
            <p class="text-center mx-[5px]">50</p>
          </div>
        </strong>
      </li>
      <li class="flex py-[10px] border-b-2 justify-between">
        <p>Date:</p>
        <strong>
          <div class="flex justify-center items-center mb-[10px]">
            <img class="w-[20px]" src="/storage/system/Coin%20Dark.png">
            <p class="text-center mx-[5px]">50 (-10%)</p>
          </div>
        </strong>
      </li>
      <li class="flex py-[10px]  justify-between">
        <p>Payout</p>
        <strong>
          <div class="flex justify-center items-center mb-[10px]">
            <img class="w-[20px]" src="/storage/system/Coin%20Dark.png">
            <p class="text-center mx-[5px]">50</p>
          </div>
        </strong>
      </li>
    </ul>
  </div>
</template>

<style scoped lang="scss">

</style>