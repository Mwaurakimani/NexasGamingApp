<script setup>
const stats = [
    { icon: '🎮', label: 'Active Matches', value: 6 },
    { icon: '🏆', label: 'Tournaments Running', value: 2 },
    { icon: '👥', label: 'Player Requests', value: 5 },
    { icon: '✅', label: 'Completed Events', value: 18 },
]

const hostedMatches = [
    { id: '#M234', game: 'Chess', status: 'Live', players: 2 },
    { id: '#M235', game: 'Monopoly', status: 'Scheduled', players: 4 },
]

const tournaments = [
    { id: '#T190', name: 'Retro Weekend', date: '2025-04-21', status: 'Ongoing' },
    { id: '#T191', name: 'Arcade Brawl', date: '2025-04-25', status: 'Scheduled' },
]

const applications = [
    { id: '#A990', player: 'Brian', game: 'Draughts', reason: 'Tournament Request' },
    { id: '#A991', player: 'Lina', game: 'Ludo', reason: 'Late Registration' },
]

const notices = [
    '📌 All matches must be approved 1 hour before launch.',
    '🎯 Tournaments must have a minimum of 4 participants.',
]
</script>

<template>
    <div class="space-y-8 text-black">
        <!-- 🧮 Quick Stats -->
        <section>
            <h2 class="text-xl font-semibold mb-4">Manager Overview</h2>
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

        <!-- 🎮 Managed Matches -->
        <section>
            <h2 class="text-xl font-semibold mb-4">Hosted Matches</h2>
            <table class="w-full table-auto bg-white shadow rounded text-sm">
                <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">Match ID</th>
                    <th class="px-4 py-2">Game</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Players</th>
                    <th class="px-4 py-2 text-right">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="match in hostedMatches" :key="match.id" class="border-t">
                    <td class="px-4 py-2">{{ match.id }}</td>
                    <td class="px-4 py-2">{{ match.game }}</td>
                    <td class="px-4 py-2">{{ match.status }}</td>
                    <td class="px-4 py-2">{{ match.players }}</td>
                    <td class="px-4 py-2 text-right">
                        <a href="#" class="text-blue-600 hover:underline">Manage</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>

        <!-- 🏆 Tournaments -->
        <section>
            <h2 class="text-xl font-semibold mb-4">Tournaments</h2>
            <table class="w-full table-auto bg-white shadow rounded text-sm">
                <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">Tournament</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2 text-right">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="t in tournaments" :key="t.id" class="border-t">
                    <td class="px-4 py-2">{{ t.name }}</td>
                    <td class="px-4 py-2">{{ t.date }}</td>
                    <td class="px-4 py-2">{{ t.status }}</td>
                    <td class="px-4 py-2 text-right">
                        <a href="#" class="text-blue-600 hover:underline">Edit</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>

        <!-- 👥 Player Applications -->
        <section>
            <h2 class="text-xl font-semibold mb-4">Player Applications</h2>
            <table class="w-full table-auto bg-white shadow rounded text-sm">
                <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">Player</th>
                    <th class="px-4 py-2">Game</th>
                    <th class="px-4 py-2">Reason</th>
                    <th class="px-4 py-2 text-right">Approve</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="app in applications" :key="app.id" class="border-t">
                    <td class="px-4 py-2">{{ app.player }}</td>
                    <td class="px-4 py-2">{{ app.game }}</td>
                    <td class="px-4 py-2">{{ app.reason }}</td>
                    <td class="px-4 py-2 text-right">
                        <a href="#" class="text-green-600 hover:underline">✅ Approve</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </section>

        <!-- 📢 Notices -->
        <section>
            <h2 class="text-xl font-semibold mb-2">Manager Notices</h2>
            <ul class="space-y-2 text-sm">
                <li
                    v-for="(note, i) in notices"
                    :key="i"
                    class="bg-indigo-100 border border-indigo-300 px-4 py-2 rounded text-indigo-800"
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
