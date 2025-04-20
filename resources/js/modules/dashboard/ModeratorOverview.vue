<script setup>
const stats = [
    { icon: '⚖️', label: 'Open Disputes', value: 8 },
    { icon: '⏳', label: 'Pending Reviews', value: 3 },
    { icon: '✅', label: 'Resolved This Week', value: 21 },
    { icon: '🎮', label: 'Active Matches', value: 12 },
]

const disputes = [
    {
        id: '#341',
        game: 'Monopoly',
        players: 'Alice vs Bob',
        summary: 'Bob claims cheating',
    },
    {
        id: '#342',
        game: 'Chess',
        players: 'Eve vs John',
        summary: 'Disconnect conflict',
    },
]

const assignedMatches = [
    {
        id: '#MT100',
        game: 'Draughts',
        players: 'Luke vs Jane',
        status: 'Live',
    },
    {
        id: '#MT101',
        game: 'Ludo',
        players: 'Mike vs Sarah',
        status: 'Pending',
    },
]

const notices = [
    '🆕 New dispute resolution policy takes effect next week.',
    '⚠ Please prioritize disputes older than 3 days.',
    '📢 Report inappropriate usernames ASAP.',
]
</script>

<template>
    <div class="space-y-8 text-black">
        <!-- 🔹 Stats Summary -->
        <section>
            <h2 class="text-xl font-semibold mb-4">Moderation Stats</h2>
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

        <!-- 🚨 Dispute Queue -->
        <section>
            <h2 class="text-xl font-semibold mb-4">Dispute Queue</h2>
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left bg-white rounded shadow">
                    <thead>
                    <tr class="bg-gray-100 text-sm text-gray-700">
                        <th class="px-4 py-2">Game</th>
                        <th class="px-4 py-2">Players</th>
                        <th class="px-4 py-2">Summary</th>
                        <th class="px-4 py-2 text-right">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="dispute in disputes"
                        :key="dispute.id"
                        class="border-t text-sm"
                    >
                        <td class="px-4 py-2">{{ dispute.game }}</td>
                        <td class="px-4 py-2">{{ dispute.players }}</td>
                        <td class="px-4 py-2">{{ dispute.summary }}</td>
                        <td class="px-4 py-2 text-right">
                            <a
                                href="#"
                                class="text-blue-600 hover:underline text-sm"
                            >
                                🔍 Review
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 🎮 Assigned Matches -->
        <section>
            <h2 class="text-xl font-semibold mb-4">Assigned Matches</h2>
            <div class="overflow-x-auto">
                <table class="w-full table-auto text-left bg-white rounded shadow">
                    <thead>
                    <tr class="bg-gray-100 text-sm text-gray-700">
                        <th class="px-4 py-2">Match ID</th>
                        <th class="px-4 py-2">Game</th>
                        <th class="px-4 py-2">Players</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2 text-right">Review</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="match in assignedMatches"
                        :key="match.id"
                        class="border-t text-sm"
                    >
                        <td class="px-4 py-2">{{ match.id }}</td>
                        <td class="px-4 py-2">{{ match.game }}</td>
                        <td class="px-4 py-2">{{ match.players }}</td>
                        <td class="px-4 py-2">{{ match.status }}</td>
                        <td class="px-4 py-2 text-right">
                            <a
                                href="#"
                                class="text-blue-600 hover:underline text-sm"
                            >
                                View
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- 📢 Notices -->
        <section>
            <h2 class="text-xl font-semibold mb-2">Moderator Notices</h2>
            <ul class="space-y-2 text-sm">
                <li
                    v-for="(note, i) in notices"
                    :key="i"
                    class="bg-blue-100 border border-blue-300 px-4 py-2 rounded text-blue-800"
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
