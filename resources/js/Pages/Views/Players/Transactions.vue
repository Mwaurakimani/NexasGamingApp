<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import Modal from "@/Components/App/Modal.vue";
import DepositBox from "@/Components/App/DepositBox.vue";
import WithdrawalBox from "@/Components/App/WithdrawalBox.vue";
import {shallowRef} from "vue";

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
                <component :is="component"/>
            </div>
        </Modal>
        <h1 class="font-bold text-[20px] mb-[20px]">Transactions</h1>
        <div class="shadow-lg w-[100%] md:w-[100%] mb-[50px] rounded-[10px] p-[10px] bg-white text-gray-600 mx-auto">
            <div class="font-bold p-[10px] text-[20px] text-right mb-[30px] flex justify-between">
                <p>Balance</p>
                <p>Ksh 5,000</p>
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
                <h2 class="text-[18px]  lg:text-white">Current Matches</h2>
                <select class="border-gray-500 h-[30px] rounded">
                    <option value="Daily">Daily</option>
                    <option value="Weekly">Weekly</option>
                    <option value="Monthly">Monthly</option>
                </select>
            </div>
            <table id="leader_board_mobile" class="w-full border mb-[10px]">
                <thead class="bg-black text-white">
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Type</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(idx,item) in 5">
                    <td class="p-[3px]">{{ idx }}</td>
                    <td>Mwaurakimani</td>
                    <td>100</td>
                    <td>Deposit</td>
                </tr>
                </tbody>
            </table>
            <div class="flex justify-between w-full">
                <button class="bg-gray-300 px-[14px] py-[5px] rounded">Previous</button>
                <button class="bg-gray-300 px-[14px] py-[5px] rounded">Next</button>
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
