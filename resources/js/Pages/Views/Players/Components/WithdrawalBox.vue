<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/DefaultComponents/InputError.vue";

const emit = defineEmits(['closePanel'])
const page = usePage()
const withdrawalForm = useForm({
    amount:"",
    phone_number : "",
    transaction_code : "",
    password : "",
})

const clearForm = () => {
    withdrawalForm.reset();
    emit('closePanel')
}

const submitForm = () => {
    withdrawalForm.post(route('transactions.withdraw'),{
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
            <h2 class="text-[20px] mb-[10px] font-bold">Withdraw</h2>
            <form class="mb-[20px] px-[20px]">
                <div class="mb-[5px]">
                    <label class="block">Amount</label>
                    <input v-model="withdrawalForm.amount" class="rounded border-gray-300 w-[300px]" type="number">
                    <InputError :message="withdrawalForm.errors.amount"></InputError>
                </div>
                <div class="mb-[5px]">
                    <label class="block">Your Phone Number</label>
                    <input v-model="withdrawalForm.phone_number" class="rounded border-gray-300 w-[300px]" type="text">
                    <InputError :message="withdrawalForm.errors.phone_number"></InputError>
                </div>
                <div class="mb-[15px]">
                    <label class="block">Password</label>
                    <input v-model="withdrawalForm.password" class="rounded border-gray-300 w-[300px]" type="password">
                    <InputError :message="withdrawalForm.errors.password"></InputError>
                </div>
            </form>
            <div class="flex items-center justify-between mb-[10px]">
                <button @click.prevent.stop="submitForm" class="bg-green-500 px-[14px] py-[5px] rounded text-white">Confirm Request</button>
                <button @click.prevent.stop="clearForm" class="bg-gray-300 px-[14px] py-[5px] rounded">Cancel</button>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">

</style>
