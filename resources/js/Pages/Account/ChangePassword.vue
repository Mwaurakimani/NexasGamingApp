<script setup>
import { useForm } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import InputError from '@/Components/InputError.vue'

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.put(route('account.password.update'), {
        preserveScroll: true,
    })
}
</script>

<template>
    <DashboardLayout>
        <div class="max-w-xl mx-auto p-6 text-black space-y-6">
            <h1 class="text-2xl font-bold">Change Password</h1>

            <form @submit.prevent="submit" class="space-y-5 bg-white p-6 rounded shadow">
                <div>
                    <label for="current_password" class="block text-sm font-medium">Current Password</label>
                    <input
                        id="current_password"
                        v-model="form.current_password"
                        type="password"
                        class="mt-1 w-full border rounded px-3 py-2"
                        required
                        autocomplete="current-password"
                    />
                    <InputError :message="form.errors.current_password" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium">New Password</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        class="mt-1 w-full border rounded px-3 py-2"
                        required
                        autocomplete="new-password"
                    />
                    <InputError :message="form.errors.password" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        class="mt-1 w-full border rounded px-3 py-2"
                        required
                        autocomplete="new-password"
                    />
                    <InputError :message="form.errors.password_confirmation" />
                </div>

                <div class="pt-4">
                    <button
                        type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 disabled:opacity-50"
                        :disabled="form.processing"
                    >
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </DashboardLayout>
</template>
