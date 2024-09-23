<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import Modal from "@/Components/App/Modal.vue";
import GenerationBox from "@/Pages/Views/Super/Transactions/Conponents/GenerationBox.vue";
import BurningBox from "@/Pages/Views/Super/Transactions/Conponents/BurningBox.vue";
import TransferBox from "@/Pages/Views/Super/Transactions/Conponents/TransferBox.vue";
import {shallowRef} from "vue";


const props = defineProps(['balance', 'transactions'])

const component = shallowRef(GenerationBox)
const openModal = (panel) => {
    if (panel === 'GenerationBox')
        component.value = GenerationBox
    else if (panel === 'BurningBox')
        component.value = BurningBox
    else if (panel === 'TransferBox')
        component.value = TransferBox

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
        <div class="shadow-lg w-[100%] md:w-[100%] mb-[50px] rounded-[10px] p-[10px] bg-white text-gray-600 mx-auto">
            <div class="font-bold p-[10px] text-[20px] text-right mb-[30px] flex justify-between">
                <p>Balance</p>
                <p>(T) {{ balance }}</p>
            </div>
            <div class="px-[20px] flex mb-[10px] gap-1">
                <button @click.prevent="openModal('GenerationBox')" class="bg-gray-300 px-[14px] py-[5px] rounded">
                    Generate Tokens
                </button>
                <button @click.prevent="openModal('BurningBox')" class="bg-gray-300 px-[14px] py-[5px] rounded">Seize
                    Tokens
                </button>
                <button @click.prevent="openModal('TransferBox')" class="bg-gray-300 px-[14px] py-[5px] rounded">
                    Transfer Tokens
                </button>
            </div>
        </div>
        <div
            class="shadow-lg w-[100%] md:w-[100%] mb-[50px] p-[5px] rounded-[10px] overflow-hidden bg-white text-gray-600 mx-auto">
            <div class="flex justify-between mb-[15px] items-center">
                <h2 class="text-[18px]">Wallet Transactions</h2>
                <select class="border-gray-500 h-[30px] w-[150px] px-[10px] py-0 rounded">
                    <option value="Daily">Daily</option>
                    <option value="Weekly">Weekly</option>
                    <option value="Monthly">Monthly</option>
                </select>
            </div>
            <table id="leader_board_mobile" class="w-full border mb-[10px]">
                <thead class="bg-black text-white">
                <tr>
                    <th class="text-center">ID</th>
                    <th>Actor</th>
                    <th>Account</th>
                    <th>Tokens</th>
                    <th>Date Time</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item) in transactions.data">
                    <td class="p-[3px] text-center">{{ item.id }}</td>
                    <td>{{ item.actor_username }}</td>
                    <td>{{ item.account }}</td>
                    <td>{{ item.tokens }}</td>
                    <td>{{ (new Date(item.created_at)).toString().split('GMT')[0].trim() }}</td>
                </tr>
                </tbody>
            </table>
            <div class="flex w-full gap-1">
                <Link :href="transactions.links[0].url" v-if="transactions.links[0].url" v-html="transactions.links[0].label" class="bg-gray-300 px-[14px] py-[5px] rounded"></Link>
                <Link :href="transactions.links[transactions.links.length - 1].url" v-if="transactions.links[transactions.links.length - 1].url" v-html="transactions.links[transactions.links.length - 1].label"
                        class="bg-gray-300 px-[14px] py-[5px] rounded"></Link>
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
