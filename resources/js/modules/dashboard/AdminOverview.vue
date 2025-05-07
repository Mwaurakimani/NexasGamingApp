<script setup>

import {usePage} from "@inertiajs/vue3";

const page = usePage()

</script>

<template>
    <div class="space-y-8 text-black">
        <!-- 📊 Stats -->
        <section>
            <h2 class="text-xl font-semibold mb-4">Platform Stats</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div
                    v-for="stat in page.props.dataset.stats"
                    :key="stat.label"
                    class="bg-white rounded shadow p-4 text-center"
                >
                    <div class="text-3xl mb-1">{{ stat.icon }}</div>
                    <div class="text-lg font-bold">{{ stat.value }}</div>
                    <div class="text-sm text-gray-500">{{ stat.label }}</div>
                </div>
            </div>
        </section>

        <!-- 🛡 User Management -->
        <section>
            <h2 class="text-xl font-semibold mb-4">User Management</h2>
            <table class="w-full table-auto bg-white shadow rounded text-sm">
                <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Balance</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in page.props.dataset.users" :key="user.id" class="border-t">
                    <td class="px-4 py-2">{{ user.name }}</td>
                    <td class="px-4 py-2">{{ user.role }}</td>
                    <td class="px-4 py-2">KES {{ user.balance }}</td>
                    <td class="px-4 py-2 text-right">
                        <a href="#" class="text-blue-600 hover:underline">Edit</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>

        <!-- 🎯 Feature Toggles -->
        <section v-if="false">
            <h2 class="text-xl font-semibold mb-4">Feature Toggles</h2>
            <div class="bg-white shadow rounded divide-y text-sm">
                <div
                    v-for="toggle in page.props.dataset.toggles"
                    :key="toggle.feature"
                    class="flex justify-between items-center px-4 py-3"
                >
                    <span>{{ toggle.feature }}</span>
                    <span
                        :class="[
              'px-2 py-1 rounded-full text-xs',
              toggle.enabled
                ? 'bg-green-100 text-green-800'
                : 'bg-red-100 text-red-700',
            ]"
                    >
            {{ toggle.enabled ? 'Enabled' : 'Disabled' }}
          </span>
                </div>
            </div>
        </section>

        <!-- 📝 Logs -->
        <section v-if="false">
            <h2 class="text-xl font-semibold mb-4">Recent Admin Activity</h2>
            <ul class="bg-white rounded shadow divide-y text-sm">
                <li v-for="(log, i) in page.props.dataset.logs" :key="i" class="px-4 py-2">
                    {{ log }}
                </li>
            </ul>
        </section>

        <!-- 📢 Notices -->
        <section v-if="false">
            <h2 class="text-xl font-semibold mb-2">Admin Notices</h2>
            <ul class="space-y-2 text-sm">
                <li
                    v-for="(note, i) in page.props.dataset.notices"
                    :key="i"
                    class="bg-red-100 border border-red-300 px-4 py-2 rounded text-red-800"
                >
                    {{ note }}
                </li>
            </ul>
        </section>
    </div>
</template>

<style scoped lang="scss">
table {
    border-collapse: collapse;
    width: 100%;
    th,
    td {
        padding: 0.75rem;
    }
}
</style>
