<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/DefaultComponents/InputError.vue";

const emit = defineEmits(['closePanel'])
const page = usePage()
const burnForm = useForm({
    seized_username : "Super Admin",
    seized_id : "1",
    password : "password",
    tokens:1000
})

const clearForm = () => {
    burnForm.reset();
    emit('closePanel')
}

const submitForm = () => {
    burnForm.post(route('admin_transactions.seizeTokens'),{
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
            <h2 class="text-[20px] mb-[10px] font-bold">Seize Tokens</h2>
            <form @submit.prevent.stop class="mb-[20px] px-[20px]">
                <div class="mb-[5px]">
                    <label class="block">Burn From Username</label>
                    <input v-model="burnForm.seized_username" class="rounded border-gray-300 w-[300px]" type="text">
                    <InputError class="mt-2" :message="burnForm.errors.seized_username" />
                </div>
                <div class="mb-[5px]">
                    <label class="block">Burn From User ID</label>
                    <input v-model="burnForm.seized_id" class="rounded border-gray-300 w-[300px]" type="text">
                    <InputError class="mt-2" :message="burnForm.errors.seized_id" />
                </div>
                <div class="mb-[15px]">
                    <label class="block">Tokens</label>
                    <input v-model="burnForm.tokens" class="rounded border-gray-300 w-[300px]" type="number">
                    <InputError class="mt-2" :message="burnForm.errors.tokens" />
                </div>
                <div class="mb-[15px]">
                    <label class="block">Password</label>
                    <input v-model="burnForm.password" class="rounded border-gray-300 w-[300px]" type="password">
                    <InputError class="mt-2" :message="burnForm.errors.password" />
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
