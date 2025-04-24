<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import {router} from '@inertiajs/vue3'
import {provide, ref, watch} from 'vue'

const props = defineProps({
    users: Object,
    filters: Object,
    stats: Object,
})

provide('pageTitle', 'User Management')

const search = ref(props.filters.search || '')
const role = ref(props.filters.role || '')

watch([search, role], () => {
    router.get(route('admin.users'), {
        search: search.value,
        role: role.value,
    }, {
        preserveState: true,
        replace: true,
    })
})
const impersonate = (userId) => {
    router.post(route('admin.users.impersonate', userId), {}, {
        onSuccess: () => router.visit('/dashboard')
    })
}
</script>

<template>
    <DashboardLayout>
        <div class="p-6 space-y-6 text-black">

            <!-- Stat Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded shadow p-4 text-center">
                    <div class="text-sm text-gray-500">Total Users</div>
                    <div class="text-xl font-bold">{{ stats.total }}</div>
                </div>
                <div class="bg-white rounded shadow p-4 text-center">
                    <div class="text-sm text-gray-500">Active Users</div>
                    <div class="text-xl font-bold text-green-600">{{ stats.active }}</div>
                </div>
                <div class="bg-white rounded shadow p-4 text-center">
                    <div class="text-sm text-gray-500">Inactive Users</div>
                    <div class="text-xl font-bold text-red-600">{{ stats.inactive }}</div>
                </div>
                <div class="bg-white rounded shadow p-4 text-center">
                    <div class="text-sm text-gray-500">Suspended Users</div>
                    <div class="text-xl font-bold text-orange-600">{{ stats.suspended }}</div>
                </div>
            </div>

            <!-- Search + Filters -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <h1 class="text-xl font-bold">Users Management</h1>

                <div class="flex gap-2">
                    <input
                        v-model="search"
                        type="text"
                        placeholder="Search users..."
                        class="border px-3 py-1.5 rounded w-[180px]"
                    />
                    <select
                        v-model="role"
                        class="border px-2 py-1.5 rounded text-sm"
                    >
                        <option value="">All Roles</option>
                        <option value="Guest">Guest</option>
                        <option value="Player">Player</option>
                        <option value="Moderator">Moderator</option>
                        <option value="Manager">Manager</option>
                        <option value="Admin">Admin</option>
                        <option value="Super Admin">Super Admin</option>
                    </select>
                </div>
            </div>

            <!-- User Table -->
            <div class="overflow-auto rounded border">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-100 text-left text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Username</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Phone</th>
                        <th class="px-4 py-2">Role</th>
                        <th class="px-4 py-2">Active</th>
                        <th class="px-4 py-2">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <Link as="tr" :href="route('admin.users.show',[user.id])" v-for="user in users.data" :key="user.id" class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ user.id }}</td>
                        <td class="px-4 py-2 font-semibold">{{ user.username }}</td>
                        <td class="px-4 py-2">{{ user.email }}</td>
                        <td class="px-4 py-2">{{ user.phone_number }}</td>
                        <td class="px-4 py-2">{{ user.role }}</td>
                        <td class="px-4 py-2">
                                <span :class="user.is_active === 'Active' ? 'text-green-600' : 'text-red-600'" class="font-semibold">
                                    {{ user.is_active  }}
                                </span>
                        </td>
                        <td class="px-4 py-2">
                            <button class="text-blue-600 hover:underline text-xs">View</button>
                        </td>
                    </Link>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex justify-between items-center text-sm mt-4">
                <div>Showing {{ users.from }} - {{ users.to }} of {{ users.total }}</div>
                <div class="space-x-2">
                    <button
                        v-if="users.prev_page_url"
                        @click="router.get(users.prev_page_url)"
                        class="px-3 py-1 border rounded hover:bg-gray-100"
                    >
                        Prev
                    </button>
                    <button
                        v-if="users.next_page_url"
                        @click="router.get(users.next_page_url)"
                        class="px-3 py-1 border rounded hover:bg-gray-100"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
