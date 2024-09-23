<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

const emit = defineEmits(['closePanel'])
const page = usePage()
const generationForm = useForm({
    receiver_username : "Super Admin",
    receiver_id : "1",
    password : "password",
    tokens:1000
})

const clearForm = () => {
    generationForm.reset();
    emit('closePanel')
}

const submitForm = () => {
    generationForm.post(route('admin_transactions.generateTokens'),{
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
            <h2 class="text-[20px] mb-[10px] font-bold">Generate Tokens</h2>
            <form @submit.prevent.stop class="mb-[20px] px-[20px]">
                <div class="mb-[5px]">
                    <label class="block">Receiver User Name</label>
                    <input v-model="generationForm.receiver_username" class="rounded border-gray-300 w-[300px]" type="text">
                    <InputError class="mt-2" :message="generationForm.errors.receiver_username" />
                </div>
                <div class="mb-[5px]">
                    <label class="block">Receiver User ID</label>
                    <input v-model="generationForm.receiver_id" class="rounded border-gray-300 w-[300px]" type="text">
                    <InputError class="mt-2" :message="generationForm.errors.receiver_id" />
                </div>
                <div class="mb-[15px]">
                    <label class="block">Tokens</label>
                    <input v-model="generationForm.tokens" class="rounded border-gray-300 w-[300px]" type="number">
                    <InputError class="mt-2" :message="generationForm.errors.tokens" />
                </div>
                <div class="mb-[15px]">
                    <label class="block">Password</label>
                    <input v-model="generationForm.password" class="rounded border-gray-300 w-[300px]" type="password">
                    <InputError class="mt-2" :message="generationForm.errors.password" />
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
