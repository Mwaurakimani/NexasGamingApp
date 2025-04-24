<script setup>
import { useForm, usePage, Link } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import InputError from '@/Components/InputError.vue'

const user = usePage().props.auth.user

const form = useForm({
    username: user.username || '',
    email: user.email || '',
    phone_number: user.phone_number || '',
})

const submit = () => {
    form.put(route('account.profile.update'))
}
</script>

<template>
    <DashboardLayout>
        <div class="p-6 space-y-6 text-black max-w-2xl mx-auto">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Edit Profile</h1>
                <Link
                    :href="route('account.profile')"
                    class="text-sm px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                >
                    Back
                </Link>
            </div>

            <form @submit.prevent="submit" class="bg-white rounded shadow p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Username</label>
                    <input v-model="form.username" type="text" class="border rounded px-3 py-2 w-full" />
                    <InputError :message="form.errors.username" />
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input v-model="form.email" type="email" class="border rounded px-3 py-2 w-full" />
                    <InputError :message="form.errors.email" />
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Phone Number</label>
                    <input v-model="form.phone_number" type="tel" class="border rounded px-3 py-2 w-full" />
                    <InputError :message="form.errors.phone_number" />
                </div>

                <div class="pt-4">
                    <button
                        type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                        :disabled="form.processing"
                    >
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </DashboardLayout>
</template>
