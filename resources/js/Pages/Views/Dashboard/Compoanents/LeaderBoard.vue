<script setup>
const leaderBoard = null;
</script>

<template>
  <div v-if="leaderBoard" class="bg-white md:p-[5px] rounded md:w-full">
    <div class="flex justify-between items-center mb-[10px]">
      <h2 class="text-[18px] mb-[5px]">Leader Board</h2>
      <div>
        <select class="border-gray-500 rounded">
          <option value="Daily">Daily</option>
          <option value="Weekly">Weekly</option>
          <option value="Monthly">Monthly</option>
        </select>
      </div>
    </div>
    <div class="shadow-lg p-[5px] rounded-lg">
      <table id="leader_board_mobile" class="w-full overflow-hidden">
        <thead class="bg-black text-white">
          <tr>
            <th>Position</th>
            <th>Username</th>
            <th>Score</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(idx,item) in 10">
            <td class="p-[10px]">{{ idx }}</td>
            <td>Mwaurakimani</td>
            <td>100</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div v-else class="w-full">
    <h2 class="text-[18px] mb-[5px]">Leader Board</h2>
    <p class="text-center p-[30px] bg-gray-200 font-bold">Leaders Board is empty</p>
  </div>
</template>

<style scoped lang="scss">

</style>