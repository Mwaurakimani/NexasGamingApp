<script setup>
import {usePage} from "@inertiajs/vue3";

const props = defineProps(['account'])
const page = usePage()
</script>

<template>
  <div class="mb-[30px] md:mb-[50px] md:w-1/2 md:px-[10px]">
    <h2 class="text-[18px] mb-[5px]">Credits</h2>
    <div class="shadow w-full md:items-stretch rounded-[10px] p-[5px] bg-white text-gray-600 h-[100%]">
      <h1 class="font-bold py-[10px] mb-[20px] text-[20px] text-right flex justify-between">
        <span>Balance</span>
        <span class="flex gap-[10px]">
          <img class="w-[20px]" src="/storage/system/Coin%20Dark.png" alt="coins">
          <span>{{ account.balance }}</span>
        </span>
      </h1>

      <div class="flex justify-between mb-[20px]" v-if="page.props.auth.user.role_name">
        <button @click.prevent="openModal('deposit')" class="bg-gray-300 px-[14px] py-[5px] rounded">
          Deposit
        </button>
        <button @click.prevent="openModal('withdraw')" class="bg-gray-300 px-[14px] py-[5px] rounded">
          Withdraw
        </button>
      </div>

      <div v-if="account.transactions.length > 0" class="rounded">
        <table id="leader_board_mobile" class="w-full rounded overflow-hidden">
          <thead class="bg-black text-white">
            <tr>
              <th>ID</th>
              <th>Amount</th>
              <th>Type</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item,idx) in account.transactions">
              <td class="p-[3px]">{{ item.id }}</td>
              <td>{{ item.amount }}</td>
              <td>{{ item.type }}</td>
              <td>{{ item.status }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <p v-else class="text-center p-[30px] bg-gray-200 font-bold">
        No Transactions Available<br>Please Deposit
        to continue...
      </p>

    </div>
  </div>
</template>

<style scoped lang="scss">

</style>