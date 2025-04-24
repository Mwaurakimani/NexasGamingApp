<script setup>
import { usePage, Link, router } from '@inertiajs/vue3'
import DashboardLayout from '@/Layouts/DashboardLayout.vue'

const user = usePage().props.auth.user

const confirmDisable = () => {
    if (confirm('Are you sure you want to disable your account? This action cannot be undone.')) {
        router.delete(route('account.profile.disable'))
    }
}
</script>

<template>
    <DashboardLayout>
        <div class="p-6 space-y-6 text-black max-w-2xl mx-auto">
            <!-- Title + Action -->
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">My Profile</h1>
                <Link
                    :href="route('account.profile.edit')"
                    class="text-sm px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                >
                    Edit Info
                </Link>
            </div>

            <!-- Profile Info -->
            <div class="bg-white rounded shadow p-6 space-y-4">
                <div>
                    <h3 class="text-sm text-gray-500">Username</h3>
                    <p class="font-semibold">{{ user.username }}</p>
                </div>

                <div>
                    <h3 class="text-sm text-gray-500">Email</h3>
                    <p class="font-semibold">{{ user.email }}</p>
                </div>

                <div>
                    <h3 class="text-sm text-gray-500">Phone Number</h3>
                    <p class="font-semibold">{{ user.phone_number ?? 'N/A' }}</p>
                </div>

                <div>
                    <h3 class="text-sm text-gray-500">Role</h3>
                    <p class="font-semibold">{{ user.role }}</p>
                </div>

                <div>
                    <h3 class="text-sm text-gray-500">Status</h3>
                    <p
                        class="font-semibold"
                        :class="{
              'text-green-600': user.is_active === 'Active',
              'text-yellow-600': user.is_active === 'Inactive',
              'text-red-600': user.is_active === 'Suspended',
            }"
                    >
                        {{ user.is_active }}
                    </p>
                </div>
            </div>

            <!-- Account Management -->
            <div class="space-y-2">
                <Link
                    :href="route('account.password.edit')"
                    class="block w-full text-center bg-gray-800 text-white py-2 rounded hover:bg-gray-900"
                >
                    Change Password
                </Link>

                <button
                    @click="confirmDisable"
                    class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700"
                >
                    Disable Account
                </button>
            </div>
        </div>
    </DashboardLayout>
</template>
