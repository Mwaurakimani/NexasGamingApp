<script setup>

import {usePage} from "@inertiajs/vue3";
import {reactive} from "vue";

const props = usePage().props

const stats = reactive(props.stats)

const recentMatches = reactive(props.recentMatches)

const announcements = reactive(props.announcements)
</script>

<template>
    <div class="space-y-8 text-black">
        <!-- 🎯 Player Stats -->
        <section>
            <h2 class="text-xl font-semibold mb-4">Your Stats</h2>
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

        <!-- 🧾 Recent Matches -->
        <section class="w-100 overflow-hidden">
            <h2 class="text-xl font-semibold mb-4">Recent Matches</h2>
            <div class="overflow-x-auto shadow">
                <table v-if="recentMatches.length > 0" class="w-full table-auto text-left bg-white rounded shadow">
                    <thead>
                    <tr class="bg-gray-100 text-sm text-gray-700">
                        <th class="px-4 py-2">Game</th>
                        <th class="px-4 py-2">Stake</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="match in recentMatches"
                        :key="match.id"
                        class="border-t text-sm"
                    >
                        <td class="px-4 py-2">{{ match.game }}</td>
                        <td class="px-4 py-2">KES {{ match.stake }}</td>
                        <td class="px-4 py-2">{{ match.status }}</td>
                    </tr>
                    </tbody>
                </table>
                <p v-else class="w-full bg-gray-100 rounded py-4 h4 text-center text-gray-700">
                    No Matches found
                </p>
            </div>
        </section>

        <!-- 🚀 Action Panel -->
        <section class="space-y-4" v-if="false">
            <h2 class="text-xl font-semibold">Get in the Game</h2>
            <div class="flex flex-wrap gap-4">
                <a
                    href="/games"
                    class="bg-black text-white px-6 py-2 rounded hover:opacity-90 transition"
                >
                    🎮 Find Match
                </a>
                <a
                    href="/stake"
                    class="bg-black text-white px-6 py-2 rounded hover:opacity-90 transition"
                >
                    💸 Stake Now
                </a>
                <a
                    href="/tournaments"
                    class="bg-black text-white px-6 py-2 rounded hover:opacity-90 transition"
                >
                    🏆 View Tournaments
                </a>

                <!-- ✅ New: View Rankings -->
                <a
                    href="/rankings"
                    class="bg-black text-white px-6 py-2 rounded hover:opacity-90 transition"
                >
                    📊 View Rankings
                </a>
            </div>
        </section>


        <!-- 📢 Announcements -->
        <section v-if="false">
            <h2 class="text-xl font-semibold mb-2">Announcements</h2>
            <ul class="space-y-2 text-sm">
                <li
                    v-for="(note, i) in announcements"
                    :key="i"
                    class="bg-yellow-100 border border-yellow-300 px-4 py-2 rounded text-yellow-800"
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
