<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import MatchCard from "@/Components/App/MatchCard.vue";
import InputError from "@/Components/InputError.vue";
import {useForm} from "@inertiajs/vue3";

const props = defineProps(['user']);

const userForm = useForm({
    username:props.user.username,
    email:props.user.email,
    phone_number:props.user.phone_number,
    codm_username:props.user.codm_username,
})

const userSecurity = useForm({
    current_password:'',
    password: '',
    password_confirmation: '',
})

const updateUser = () => {
    userForm.post(route('profile.updateAccount'),{
        onSuccess: () => {
            alert("User updated Successfully")
            window.location.reload()
        }
    })
}

const updateSecurity = () => {
    userSecurity.post(route('profile.updateSecurity'),{
        onSuccess: () => {
            alert("Security settings updated Successfully")
        }
    })
}

</script>

<template>
    <DashboardLayout>
        <div class="w-full px-[10px] pb-[30px] mx-auto md:max-w-[750px] rounded">
            <h1 class="font-bold text-[20px] mb-[5px]">Profile Details</h1>
            <form class="mb-[60px] text-gray-500" @submit.prevent.stop="updateUser">
                <section class=" border-gray-200  overflow-hidden rounded p-[10px]">
                    <div class="flex flex-col mb-[20px]">
                        <label class="text-[15px] mb-[5px] text-gray-600">Username</label>
                        <input v-model="userForm.username" type="text" class="rounded-md border-1 border-gray-300">
                    </div>
                    <div class="flex mb-[20px] flex-col">
                        <label class="text-[15px] mb-[5px] text-gray-600">Email</label>
                        <input v-model="userForm.email" type="text" class="rounded-md border-1 border-gray-300">
                    </div>
                    <div class="flex mb-[20px] flex-col">
                        <label class="text-[15px] mb-[5px] text-gray-600">Phone Number</label>
                        <input v-model="userForm.phone_number" type="text" class="rounded-md border-1 border-gray-300">
                    </div>
                    <div class="flex flex-col mb-[20px]">
                        <label class="text-[15px] mb-[5px] text-gray-600">Call of Duty Username</label>
                        <input v-model="userForm.codm_username" type="text" class="rounded-md border-1 border-gray-300">
                    </div>
                    <div>
                        <button type="submit" class="bg-gray-300 block w-full px-[30px] py-[5px] rounded">Save Changes</button>
                    </div>
                </section>
            </form>
            <h1 class="font-bold text-[20px] mb-[5px]">Security Details</h1>
            <form @submit.prevent.stop="updateSecurity">
                <section class=" border-gray-200  overflow-hidden rounded p-[10px]">
                    <div class="flex mb-[5px] flex-col">
                        <label class="text-[15px] mb-[5px] text-gray-600">Current Password</label>
                        <input v-model="userSecurity.current_password" type="password" class="rounded-md border-1 border-gray-300">
                        <InputError class="mt-2" :message="userSecurity.errors.current_password"/>
                    </div>
                    <div class="flex mb-[5px] flex-col">
                        <label class="text-[15px] mb-[5px] text-gray-600">New Password</label>
                        <input v-model="userSecurity.password" type="password" class="rounded-md border-1 border-gray-300">
                        <InputError class="mt-2" :message="userSecurity.errors.password"/>
                    </div>
                    <div class="flex flex-col mb-[20px]">
                        <label class="text-[15px] mb-[5px] text-gray-600">Confirm New Password</label>
                        <input v-model="userSecurity.password_confirmation" type="password" class="rounded-md border-1 border-gray-300">
                        <InputError class="mt-2" :message="userSecurity.errors.current_password"/>
                    </div>
                    <div>
                        <button type="submit" class="bg-gray-300 block w-full px-[30px] py-[5px] rounded">Save Password</button>
                    </div>
                </section>
            </form>
        </div>
    </DashboardLayout>
</template>

<style scoped lang="scss">
button:active {
    transition: all ease-in-out 0.3ms;
    @apply bg-gray-700 text-white;
}
</style>
