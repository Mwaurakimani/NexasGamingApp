<script setup>
import {onMounted, ref} from 'vue'
import VChart from 'vue-echarts'
import * as echarts from 'echarts/core'
import {GridComponent, LegendComponent, TitleComponent, TooltipComponent,} from 'echarts/components'
import {BarChart, LineChart} from 'echarts/charts'
import {CanvasRenderer} from 'echarts/renderers'

echarts.use([
    TitleComponent,
    TooltipComponent,
    GridComponent,
    LegendComponent,
    BarChart,
    LineChart,
    CanvasRenderer,
])

const userTraffic = ref({})
const disputeStats = ref({})
const revenueStats = ref({})
const gameRevenues = ref([])

const healthCards = [
    { service: 'Auth System', status: 'OK' },
    { service: 'Payments', status: 'Warning' },
    { service: 'Match Engine', status: 'OK' },
    { service: 'Chat System', status: 'Error' },
]

const logs = [
    '🛠 Admin John enabled staking',
    '🚨 Mike escalated a dispute',
    '✅ Tournament “Retro Brawl” launched',
    '👤 Lina promoted to Manager'
]

onMounted(() => {
    userTraffic.value = {
        xAxis: { type: 'category', data: ['00h', '06h', '12h', '18h', '00h+'] },
        yAxis: { type: 'value' },
        series: [
            {
                data: [22, 75, 140, 230, 100],
                type: 'line',
                smooth: true,
                lineStyle: { color: '#0ea5e9' },
                areaStyle: {},
            },
        ],
    }

    disputeStats.value = {
        xAxis: { type: 'category', data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] },
        yAxis: { type: 'value' },
        series: [
            {
                data: [3, 5, 8, 12, 9, 4, 2],
                type: 'bar',
                itemStyle: { color: '#f97316' },
            },
        ],
    }

    revenueStats.value = {
        tooltip: {},
        legend: { data: ['Profits', 'Pending Incomes', 'Pending Outpays'] },
        xAxis: { type: 'category', data: ['Week 1', 'Week 2', 'Week 3', 'Week 4'] },
        yAxis: { type: 'value' },
        series: [
            {
                name: 'Profits',
                type: 'bar',
                data: [2000, 3000, 2800, 3500],
                itemStyle: { color: '#22c55e' },
            },
            {
                name: 'Pending Incomes',
                type: 'bar',
                data: [800, 600, 750, 900],
                itemStyle: { color: '#facc15' },
            },
            {
                name: 'Pending Outpays',
                type: 'bar',
                data: [400, 500, 450, 600],
                itemStyle: { color: '#ef4444' },
            },
        ],
    }

    gameRevenues.value = [
        { name: 'Chess', cover: '/storage/images/games/chess.png', revenue: 2400 },
        { name: 'Draughts', cover: '', revenue: 1800 },
        { name: 'Monopoly', cover: '/storage/images/games/monopoly.webp', revenue: 3200 },
        { name: 'Ludo', cover: '', revenue: 900 }
    ]
})
</script>

<template>
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 text-black">
        <div class="space-y-6">
            <section>
                <h2 class="text-2xl font-bold">Super Admin Dashboard</h2>
                <p class="text-sm text-gray-600">Full platform intelligence and control.</p>
            </section>

            <section class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold mb-2">User Traffic (24h)</h3>
                <VChart :option="userTraffic" style="height: 300px; width: 100%" />
            </section>

            <section class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold mb-2">Disputes Overview</h3>
                <VChart :option="disputeStats" style="height: 300px; width: 100%" />
            </section>

            <section class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold mb-2">Revenue Overview</h3>
                <VChart :option="revenueStats" style="height: 300px; width: 100%" />
            </section>
        </div>

        <div class="space-y-6">
            <section>
                <h3 class="text-lg font-semibold mb-4">System Health</h3>
                <ul class="grid grid-cols-2 md:grid-cols-2 gap-4">
                    <li
                        v-for="(h, i) in healthCards"
                        :key="i"
                        class="rounded shadow px-4 py-3 text-center text-sm font-semibold"
                        :class="{
              'bg-green-100 text-green-800': h.status === 'OK',
              'bg-yellow-100 text-yellow-800': h.status === 'Warning',
              'bg-red-100 text-red-800': h.status === 'Error',
            }"
                    >
                        {{ h.service }}<br /><span class="font-bold">{{ h.status }}</span>
                    </li>
                </ul>
            </section>

            <section>
                <h3 class="text-lg font-semibold mb-4">Revenue Per Game</h3>
                <ul class="space-y-3">
                    <li v-for="(game, i) in gameRevenues" :key="i" class="bg-white p-3 rounded shadow flex items-center gap-4">
                        <div>
                            <img
                                v-if="game.cover"
                                :src="game.cover"
                                :alt="game.name"
                                class="w-10 h-10 rounded-full object-cover"
                            />
                            <div
                                v-else
                                class="w-10 h-10 flex items-center justify-center bg-gray-300 rounded-full text-sm font-bold"
                            >
                                {{ game.name.charAt(0).toUpperCase() }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium">{{ game.name }}</div>
                            <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden mt-1">
                                <div
                                    class="h-2 bg-green-500 rounded-full transition-all duration-500 ease-in-out"
                                    :style="`width: ${(game.revenue / 4000) * 100}%`"
                                ></div>
                            </div>
                        </div>
                        <div class="text-sm font-bold text-green-600">KES {{ game.revenue.toLocaleString() }}</div>
                    </li>
                </ul>
            </section>

            <section>
                <h3 class="text-lg font-semibold mb-4">Recent Logs</h3>
                <ul class="bg-white rounded shadow divide-y text-sm">
                    <li v-for="(log, i) in logs" :key="i" class="px-4 py-2">
                        {{ log }}
                    </li>
                </ul>
            </section>
        </div>
    </div>
</template>

<style scoped>
</style>
