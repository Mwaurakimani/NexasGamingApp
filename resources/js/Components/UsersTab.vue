<script setup>
import {ref} from 'vue'

const props = defineProps({
    transactions: Array,
    played: Array,
    upcoming: Array,
})

const tab = ref('transactions')
</script>

<template>
    <div class="bg-white p-4 rounded shadow">
        <div class="flex space-x-4 mb-4">
            <button
                @click="tab = 'transactions'"
                :class="tab === 'transactions' ? 'font-bold border-b-2 border-black' : ''"
            >Transactions</button>
            <button
                @click="tab = 'played'"
                :class="tab === 'played' ? 'font-bold border-b-2 border-black' : ''"
            >Matches Played</button>
            <button
                @click="tab = 'upcoming'"
                :class="tab === 'upcoming' ? 'font-bold border-b-2 border-black' : ''"
            >Upcoming Matches</button>
        </div>

        <div v-if="tab === 'transactions'" class="space-y-2 text-sm">
            <div v-for="t in transactions" :key="t.id" class="border-b py-2">
                💸 {{ t.amount }} - {{ t.type }} <br />
                <span class="text-gray-500 text-xs">{{ t.created_at }}</span>
            </div>
        </div>

        <div v-if="tab === 'played'" class="space-y-2 text-sm">
            <div v-for="m in played" :key="m.id" class="border-b py-2">
                🕹 {{ m.game_name }} vs {{ m.opponent }}
                <div class="text-xs text-gray-500">{{ m.played_at }}</div>
            </div>
        </div>

        <div v-if="tab === 'upcoming'" class="space-y-2 text-sm">
            <div v-for="m in upcoming" :key="m.id" class="border-b py-2">
                🎮 {{ m.game_name }} ({{ m.date }})
            </div>
        </div>
    </div>
</template>
