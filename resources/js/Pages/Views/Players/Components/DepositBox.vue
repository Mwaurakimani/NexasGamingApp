<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/DefaultComponents/InputError.vue";

const emit = defineEmits(['closePanel'])
const page = usePage()
const depositForm = useForm({
    tokens:"",
    phone_number : "",
    transaction_code : "",
})

const clearForm = () => {
    depositForm.reset();
    emit('closePanel')
}

const submitForm = () => {
    depositForm.post(route('transactions.deposit'),{
        onSuccess: () => {
            alert(page.props.success_message)
            clearForm()
            window.location.reload()
        }
    })
}
</script>

<template>
    <div class="p-[10px] bg-white rounded max-w-[350px]">
        <div class="">
            <h2 class="text-[20px] mb-[10px] font-bold">Deposit</h2>
            <form class="mb-[20px] px-[20px]">
                <div class="mb-[5px]">
                    <label class="block">Amount</label>
                    <input v-model="depositForm.tokens" class="rounded border-gray-300 w-[300px]" type="number" min="0">
                    <InputError :message="depositForm.errors.tokens"></InputError>
                </div>
                <div class="mb-[15px]">
                    <label class="block">Your Phone Number</label>
                    <input v-model="depositForm.phone_number" class="rounded border-gray-300 w-[300px]" type="text">
                    <InputError :message="depositForm.errors.phone_number"></InputError>
                </div>
                <p class="text-[14px] mb-[15px]">
                    Please transfer KSh {{depositForm.tokens}} to M-Pesa number 0719445697 then enter the
                    transaction reference code in the field below.
                </p>
                <p class="text-[14px] mb-[15px]">Do not press confirm until the transaction is successful</p>
                <div class="mb-[15px]">
                    <label class="block">Transaction Code</label>
                    <input v-model="depositForm.transaction_code" class="rounded border-gray-300 w-[300px]" type="text">
                    <InputError :message="depositForm.errors.transaction_code"></InputError>
                </div>
            </form>
            <div class="flex items-center justify-between mb-[10px]">
                <button @click.prevent.stop="submitForm" class="bg-green-500 px-[14px] py-[5px] rounded text-white">Confirm</button>
                <button @click.prevent.stop="clearForm" class="bg-gray-300 px-[14px] py-[5px] rounded">Cancel</button>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">

</style>
