<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import Modal from "@/Components/App/Modal.vue";
import DepositBox from "@/Pages/Views/Players/Components/DepositBox.vue";
import WithdrawalBox from "@/Pages/Views/Players/Components/WithdrawalBox.vue";
import {shallowRef} from "vue";


const props = defineProps(['balance', 'transactions', 'deposits', 'withdrawals'])
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
                <component  @closePanel="closeModal" :is="component"/>
            </div>
        </Modal>
        <h1 class="font-bold text-[20px] mb-[20px]">Transactions</h1>
        <div class="shadow-lg w-[100%] md:w-[100%] mb-[50px] rounded-[10px] p-[10px] bg-white text-gray-600 mx-auto">
            <div class="font-bold p-[10px] text-[20px] text-right mb-[30px] flex justify-between">
                <p>Balance</p>
                <p>(T) {{ balance }}</p>
            </div>
            <div class="px-[20px] flex justify-between mb-[0px]">
                <button @click.prevent="openModal('deposit')" class="bg-gray-300 px-[14px] py-[5px] rounded">Deposit
                </button>
                <button @click.prevent="openModal('withdraw')" class="bg-gray-300 px-[14px] py-[5px] rounded">Withdraw
                </button>
            </div>
        </div>
        <div
            class="shadow-lg w-[100%] md:w-[100%] mb-[50px] p-[5px] rounded-[10px] overflow-hidden bg-white text-gray-600 mx-auto">
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
        <div class="flex gap-3">
            <div
                class="shadow-lg w-[100%] md:w-[100%] mb-[50px] p-[5px] rounded-[10px] overflow-hidden bg-white text-gray-600 mx-auto">
                <div class="flex justify-between mb-[15px] items-center">
                    <h2 class="text-[18px]">Deposits</h2>
                </div>
                <table id="leader_board_mobile" class="w-full border mb-[10px]">
                    <thead class="bg-black text-white">
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Amount</th>
                        <th>Ref</th>
                        <th class="text-center px-[10px]">Date</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in deposits.data">
                        <td class="p-[3px] text-center">{{ item.id }}</td>
                        <td>{{ item.amount }}</td>
                        <td>{{ item.transaction_code }}</td>
                        <td class="text-center">
                            {{ (new Date(item.created_at)).toString().split('GMT')[0].trim() }}
                        </td>
                        <td>{{ item.status }}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="flex justify-between w-full">
                    <Link :href="deposits.links[0].url" v-if="deposits.links[0].url" v-html="deposits.links[0].label"
                          class="bg-gray-300 px-[14px] py-[5px] rounded"></Link>
                    <Link :href="deposits.links[deposits.links.length - 1].url"
                          v-if="deposits.links[deposits.links.length - 1].url"
                          v-html="deposits.links[deposits.links.length - 1].label"
                          class="bg-gray-300 px-[14px] py-[5px] rounded"></Link>
                </div>
            </div>
            <div
                class="shadow-lg w-[100%] md:w-[100%] mb-[50px] p-[5px] rounded-[10px] overflow-hidden bg-white text-gray-600 mx-auto">
                <div class="flex justify-between mb-[15px] items-center">
                    <h2 class="text-[18px]">Withdrawals</h2>
                </div>
                <table id="leader_board_mobile" class="w-full border mb-[10px]">
                    <thead class="bg-black text-white">
                    <tr>
                        <th class="text-center">ID</th>
                        <th>Amount</th>
                        <th>Ref</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in withdrawals.data">
                        <td class="p-[3px] text-center">{{ item.id }}</td>
                        <td>{{ item.amount }}</td>
                        <td>{{ item.transaction_code ?? "N/A" }}</td>
                        <td>
                            {{ (new Date(item.created_at)).toString().split('GMT')[0].trim() }}
                        </td>
                        <td>{{ item.status }}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="flex justify-between w-full">
                    <Link :href="withdrawals.links[0].url" v-if="withdrawals.links[0].url"
                          v-html="withdrawals.links[0].label" class="bg-gray-300 px-[14px] py-[5px] rounded"></Link>
                    <Link :href="withdrawals.links[withdrawals.links.length - 1].url"
                          v-if="withdrawals.links[withdrawals.links.length - 1].url"
                          v-html="withdrawals.links[withdrawals.links.length - 1].label"
                          class="bg-gray-300 px-[14px] py-[5px] rounded"></Link>
                </div>
            </div>
        </div>

    </DashboardLayout>
</template>

<style scoped lang="scss">
button:active {
    transition: all ease-in-out 0.3ms;
    @apply bg-gray-700 text-white;
}
</style>
