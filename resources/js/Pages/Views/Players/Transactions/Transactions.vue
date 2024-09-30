<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import Modal from "@/Components/App/Modal.vue";
import DepositBox from "@/Pages/Views/Players/Components/DepositBox.vue";
import WithdrawalBox from "@/Pages/Views/Players/Components/WithdrawalBox.vue";
import {shallowRef} from "vue";
import NavigationBox from "@/Pages/Views/Players/Components/NavigationBox.vue";


const props = defineProps(['balance', 'transactions'])
const component = shallowRef(DepositBox)
const openModal = (panel) => {
  if (panel === 'deposit')
    component.value = DepositBox
  else if (panel === 'withdraw')
    component.value = WithdrawalBox

  $('#main_modal').fadeIn('fast')
}

const closeModal = () => {
  $('#main_modal').fadeOut('fast')
}

</script>

<template>
  <DashboardLayout>
    <Modal @closeModalTrigger="closeModal">
      <div class=" flex w-full h-full items-center justify-center">
        <component @closePanel="closeModal" :is="component"/>
      </div>
    </Modal>
    <h1 class="font-bold text-[20px] mb-[20px]">Transactions</h1>

    <NavigationBox :active="'Transfers'"/>

    <div class="shadow-lg w-[100%] md:w-[100%] mb-[40px] rounded-[10px] p-[10px] bg-white text-gray-600 mx-auto">
      <div class="font-bold p-[10px] text-[20px] text-right mb-[30px] flex justify-between">
        <p>Balance</p>
        <p>(T) {{ balance }}</p>
      </div>
      <div class=" flex justify-between mb-[0px]">
        <button @click.prevent="openModal('deposit')" class="bg-gray-300 px-[14px] py-[5px] rounded">Deposit
        </button>
        <button @click.prevent="openModal('withdraw')" class="bg-gray-300 px-[14px] py-[5px] rounded">Withdraw
        </button>
      </div>
    </div>

    <h2 class="text-[18px] font-bold">Transfers</h2>
    <template v-if="transactions.data.length > 0">
      <div class="md:hidden shadow-lg mb-[50px] p-[5px] rounded-[10px] overflow-hidden bg-white text-gray-600 mx-auto">
        <div class="mb-[15px] items-center">
          <ul class="px-[20px]">
            <li v-for="transaction in transactions.data">
              <p class="font-bold inline">Transaction ID: {{ transaction.id }}</p>
              <p>You {{ transaction.transaction_type == 'transfer' ? 'received' : 'transferred' }}
                {{ transaction.amount }} Tokens</p>
              <p>Description: {{ transaction.description ?? 'N/A' }}</p>
              <p>Transaction is {{ transaction.status }}</p>
              <p>Date and Time: {{ formatDate(transaction.created_at) }}</p>
              <hr class="my-[10px]">
            </li>
          </ul>
        </div>

        <div class="flex justify-between w-full">
          <Link :href="transactions.links[0].url" v-if="transactions.links[0].url"
                v-html="transactions.links[0].label" class="bg-gray-300 px-[14px] py-[5px] rounded"></Link>
          <Link :href="transactions.links[transactions.links.length - 1].url"
                v-if="transactions.links[transactions.links.length - 1].url"
                v-html="transactions.links[transactions.links.length - 1].label"
                class="bg-gray-300 px-[14px] py-[5px] rounded"></Link>
        </div>
      </div>
      <div
          class="hidden md:block shadow-lg w-[100%] md:w-[100%] mb-[50px] p-[5px] rounded-[10px] overflow-hidden bg-white text-gray-600 mx-auto">
        <div class="flex justify-between mb-[15px] items-center">
          <h2 class="text-[18px]">Transfers</h2>
        </div>
        <table id="leader_board_mobile" class="w-full border mb-[10px]">
          <thead class="bg-black text-white">
            <tr>
              <th class="text-center">ID</th>
              <th>From</th>
              <th>Amount</th>
              <th>Type</th>
              <th class="w-[170px] text-center px-[10px]">Date</th>
              <th>Reference</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in transactions.data">
              <td class="p-[3px] text-center">{{ item.id }}</td>
              <td>{{ item.actor_username }}</td>
              <td>{{ item.amount }}</td>
              <td>{{ item.transaction_type }}</td>
              <td class="text-center px-[30px]">
                {{ (new Date(item.created_at)).toString().split('GMT')[0].trim() }}
              </td>
              <td>{{ item.ref ?? "N/A" }}</td>
              <td>{{ item.status }}</td>
            </tr>
          </tbody>
        </table>
        <div class="flex justify-between w-full">
          <Link :href="transactions.links[0].url" v-if="transactions.links[0].url"
                v-html="transactions.links[0].label" class="bg-gray-300 px-[14px] py-[5px] rounded"></Link>
          <Link :href="transactions.links[transactions.links.length - 1].url"
                v-if="transactions.links[transactions.links.length - 1].url"
                v-html="transactions.links[transactions.links.length - 1].label"
                class="bg-gray-300 px-[14px] py-[5px] rounded"></Link>
        </div>
      </div>
    </template>
    <p v-else class="text-center p-[30px] bg-gray-200 font-bold">No Transfers Made</p>

  </DashboardLayout>
</template>

<style scoped lang="scss">
button {
  &:hover {
    @apply bg-gray-700 text-white;
  }
}

button:active {
  transition: all ease-in-out 0.3ms;
  @apply bg-gray-900 text-white;
}
</style>
