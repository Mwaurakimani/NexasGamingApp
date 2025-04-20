<script setup>
const props = defineProps({
    stats: Object,
    balance: Number,
})
</script>

<template>
    <div class="bg-white p-4 rounded shadow text-sm space-y-2">
        <div>
            <h3 class="font-bold">Balance</h3>
            <p class="text-lg font-semibold text-green-600">KES {{ balance.toFixed(2) }}</p>
        </div>

        <div>
            <h3 class="font-bold">Games Played</h3>
            <p>{{ stats.games_played }} total</p>
        </div>

        <div>
            <h3 class="font-bold">Win Rate</h3>
            <p>{{ stats.win_rate }}%</p>
        </div>

        <div>
            <h3 class="font-bold">Rating</h3>
            <p>{{ stats.rating }}</p>
        </div>
    </div>
</template>
