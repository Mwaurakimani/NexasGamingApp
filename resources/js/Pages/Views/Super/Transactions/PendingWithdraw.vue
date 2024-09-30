<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import Modal from "@/Components/App/Modal.vue";
import {useForm} from "@inertiajs/vue3";
import InputError from "@/Components/DefaultComponents/InputError.vue";


const props = defineProps(['withdrawals'])

const selectedTransaction = useForm({
    id: "",
    user_id: "",
    amount: "",
    phone_number: "",
    transaction_code: "",
    status: "",
    notes: "",
    account: "",
    type: ""
})


const setSelected = (item) => {
    selectedTransaction.id = item.id
    selectedTransaction.user_id = item.user_id
    selectedTransaction.amount = item.amount
    selectedTransaction.phone_number = item.phone_number
    selectedTransaction.transaction_code = item.transaction_code
    selectedTransaction.status = item.status
    selectedTransaction.notes = item.notes
    selectedTransaction.type = "withdrawal"
}

const openModal = (item) => {
    setSelected(item ?? props.withdrawals.data[0])

    $('#main_modal').fadeIn('fast')
}

const closeModal = () => {
    $('#main_modal').fadeOut('fast')
}

const updateTransaction = () => {
    selectedTransaction.post(route('admin_transactions.updateTransaction'))
}
</script>

<template>
    <DashboardLayout >
        <Modal @closeModalTrigger="closeModal">
            <div class=" flex w-full h-full items-center justify-center">
                <div class="bg-white w-[400px] rounded">
                    <div class="flex items-center justify-between">
                        <h1 class=" text-xl p-[10px] justify-between font-bold">Transactions details</h1>
                        <div @click.prevent="closeModal"
                             class="flex cursor-pointer text-sm rounded-[50%] mr-[10px] items-center justify-center w-[20px] h-[20px] bg-red-400 text-white">
                            X
                        </div>
                    </div>
                    <div class="modal_withdrawals">
                        <div class="flex w-full justify-between px-[20px] mb-[10px]">
                            <label class="w-[150px]">Transaction ID:</label>
                            <p>{{ selectedTransaction.id }}</p>
                        </div>

                        <div class="flex w-full px-[20px] justify-between mb-[10px]">
                            <label class="w-[150px]">Amount:</label>
                            <p>{{ selectedTransaction.amount }}</p>
                        </div>

                        <div class="flex  px-[20px] mb-[10px] justify-between">
                            <label class="w-[150px]">Status</label>
                            <select class="w-[150px] border border-gray-500 p-[3px] px-[20px]"
                                    v-model="selectedTransaction.status">
                                <option value="">Select Status</option>
                                <option value="rejected">Rejected</option>
                                <option value="confirmed">Confirmed</option>
                            </select>
                        </div>
                        <InputError class="mx-[20px]" :message="selectedTransaction.errors.status"></InputError>

                        <div
                            v-if="selectedTransaction.status === 'confirmed' || selectedTransaction.status === 'rejected' "
                            class=" px-[20px]">
                            <label class="w-[150px] block">Note</label>
                            <textarea v-model="selectedTransaction.notes" class="w-full border border-gray-500 rounded"
                                      placeholder="Add any extra information Like transaction code or reason for updating"></textarea>
                        </div>
                        <InputError class="mt-2 mx-[20px]" :message="selectedTransaction.errors.notes"/>


                        <div class="p-[20px] grid place-items-center">
                            <button @click.prevent="updateTransaction" type="button"
                                    class="bg-gray-300 px-[14px] py-[5px] w-full rounded">Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Modal>
        <h1 class="font-bold text-[20px] mb-[20px]">Transactions</h1>
        <div class="flex mb-[10px] gap-1">
            <Link :href="route('transactions.list')" class="bg-gray-300 px-[14px] py-[5px] rounded">Transactions</Link>
        </div>
        <div
            class="shadow-lg w-[100%] md:w-[100%] mb-[50px] p-[5px] rounded-[10px] overflow-hidden bg-white text-gray-600 mx-auto">
            <div class="flex justify-between mb-[15px] items-center">
                <h2 class="text-[18px] px-[20px]">withdrawals</h2>
            </div>
            <table id="leader_board_mobile" class="w-full border mb-[10px]">
                <thead class="bg-black text-white">
                <tr>
                    <th class="text-center">ID</th>
                    <th>Actor</th>
                    <th>Account</th>
                    <th>Tokens</th>
                    <th>Mod Status</th>
                    <th>Status</th>
                    <th>Date Time</th>
                    <th>Updated At</th>
                </tr>
                </thead>
                <tbody>
                <tr @click.prevent="openModal(item)" v-for="(item) in withdrawals.data">
                    <td class="p-[3px] text-center">{{ item.id }}</td>
                    <td>{{ item.processed_by ?? "N/A" }}</td>
                    <td>{{ item.account }}</td>
                    <td>{{ item.amount }}</td>
                    <td>{{ item.moderator_status }}</td>
                    <td>{{ item.status }}</td>
                    <td>{{ (new Date(item.created_at)).toString().split('GMT')[0].trim() }}</td>
                    <td>{{ (new Date(item.updated_at)).toString().split('GMT')[0].trim() }}</td>
                </tr>
                </tbody>
            </table>
            <div class="flex justify-between w-full">
                <Link :href="withdrawals.links[0].url" v-if="withdrawals.links[0].url" v-html="withdrawals.links[0].label"
                      class="bg-gray-300 px-[14px] py-[5px] rounded"></Link>
                <Link :href="withdrawals.links[withdrawals.links.length - 1].url"
                      v-if="withdrawals.links[withdrawals.links.length - 1].url"
                      v-html="withdrawals.links[withdrawals.links.length - 1].label"
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

tr {
    &:hover {
        @apply bg-gray-700 text-white cursor-pointer;
    }
}

.modal_withdrawals {
    & > div {
        @apply mb-[20px];

        select {
            @apply rounded;
        }
    }
}
</style>
