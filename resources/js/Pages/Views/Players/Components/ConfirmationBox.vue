<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/DefaultComponents/InputError.vue";

const props = defineProps(['transaction'])
const emit = defineEmits(['closePanel'])
const page = usePage()
const withdrawalForm = useForm({
  withdrawal_id: props.transaction.id,
  transaction_code: "",
  password: "",
})

const clearForm = () => {
  withdrawalForm.reset();
  emit('closePanel')
}

const submitForm = () => {
  withdrawalForm.post(route('transactions.confirmWithdrawal'), {
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
      <ul class="px-[10px]">
        <li class="flex justify-between mb-[20px] border-b-gray-200 pb-[5px] border-b">
          <span>ID :</span><span>{{ transaction.id }}</span></li>
        <li class="flex justify-between mb-[20px] border-b-gray-200 pb-[5px] border-b">
          <span>Status :</span><span>{{ transaction.status }}</span></li>
        <li class="flex justify-between mb-[20px] border-b-gray-200 pb-[5px] border-b">
          <span>Amount :</span><span>{{ transaction.amount }}</span></li>
        <li v-if="transaction.processed_by" class="flex justify-between mb-[20px] border-b-gray-200 pb-[5px] border-b">
          <span>Processed By:</span><span>{{ transaction.processed_by ?? "N/A" }}</span></li>
        <li v-if="transaction.transaction_code" class="flex justify-between mb-[20px] border-b-gray-200 pb-[5px] border-b">
          <span>Transaction Code</span><span>{{ transaction.transaction_code ?? "N/A" }}</span></li>
      </ul>
      <form class="mb-[20px] px-[10px]">
        <template v-if="transaction.status === 'pending'">
          <p class="text-[14px] text-red-400 mb-[15px]">Do not press confirm until you receive the funds</p>
          <div class="mb-[15px]">
            <label class="block">Transaction Code</label>
            <input v-model="withdrawalForm.transaction_code" class="rounded border-gray-300 w-[300px]" type="text">
            <InputError :message="withdrawalForm.errors.transaction_code"></InputError>
            <InputError :message="withdrawalForm.errors.withdrawal_id"></InputError>
          </div>
          <div class="mb-[15px]">
            <label class="block">Password</label>
            <input v-model="withdrawalForm.password" class="rounded border-gray-300 w-[300px]" type="password">
            <InputError :message="withdrawalForm.errors.password"></InputError>
          </div>
        </template>

      </form>
      <div class="flex items-center justify-between mb-[10px]">
        <button v-if="transaction.status === 'pending'" @click.prevent.stop="submitForm" class="bg-green-500 px-[14px] py-[5px] rounded text-white">Confirm
        </button>
        <button @click.prevent.stop="clearForm" class="bg-gray-300 px-[14px] py-[5px] rounded">
          {{ transaction.status === 'pending' ? 'cancel' : 'close'}}
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">

</style>
