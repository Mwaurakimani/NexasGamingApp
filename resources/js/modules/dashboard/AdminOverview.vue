<script setup>
const stats = [
    { icon: '👥', label: 'Total Users', value: 1298 },
    { icon: '🛠️', label: 'Active Moderators', value: 4 },
    { icon: '🎮', label: 'Live Matches', value: 9 },
    { icon: '⚠️', label: 'Open Disputes', value: 14 },
]

const users = [
    { id: 1, name: 'Alice', role: 'Player', status: 'Active' },
    { id: 2, name: 'Bob', role: 'Moderator', status: 'Suspended' },
    { id: 3, name: 'Lina', role: 'Guest', status: 'Active' },
]

const toggles = [
    { feature: 'Staking System', enabled: true },
    { feature: 'Tournament Hosting', enabled: true },
    { feature: 'Live Chat', enabled: false },
]

const logs = [
    '👑 Promoted Lina to Moderator',
    '🚫 Suspended user Bob for violation',
    '✅ Enabled staking platform',
]

const notices = [
    '⚠ Some moderators haven’t responded to disputes in 24+ hrs.',
    '📌 Confirm all players before new tournament launch.',
]
</script>

<template>
    <div class="space-y-8 text-black">
        <!-- 📊 Stats -->
        <section>
            <h2 class="text-xl font-semibold mb-4">Platform Stats</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div
                    v-for="stat in stats"
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
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2 text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="user in users" :key="user.id" class="border-t">
                    <td class="px-4 py-2">{{ user.name }}</td>
                    <td class="px-4 py-2">{{ user.role }}</td>
                    <td class="px-4 py-2">{{ user.status }}</td>
                    <td class="px-4 py-2 text-right">
                        <a href="#" class="text-blue-600 hover:underline">Edit</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>

        <!-- 🎯 Feature Toggles -->
        <section>
            <h2 class="text-xl font-semibold mb-4">Feature Toggles</h2>
            <div class="bg-white shadow rounded divide-y text-sm">
                <div
                    v-for="toggle in toggles"
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
        <section>
            <h2 class="text-xl font-semibold mb-4">Recent Admin Activity</h2>
            <ul class="bg-white rounded shadow divide-y text-sm">
                <li v-for="(log, i) in logs" :key="i" class="px-4 py-2">
                    {{ log }}
                </li>
            </ul>
        </section>

        <!-- 📢 Notices -->
        <section>
            <h2 class="text-xl font-semibold mb-2">Admin Notices</h2>
            <ul class="space-y-2 text-sm">
                <li
                    v-for="(note, i) in notices"
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
