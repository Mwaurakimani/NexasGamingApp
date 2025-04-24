<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { ref } from 'vue'
import {route} from "ziggy-js";

// Dummy data (you'll later pull this from props or Inertia)
const challenge = ref({
    id: '#CHLG-48291',
    challenger: {
        name: 'Kimani Mwangi',
        avatar: null,
        rank: 'Pro',
    },
    stake: 100,
    serviceCost: 10,
    maxWaitTime: '10 mins',
    rules: [
        'Standard chess rules apply.',
        'You must respond within 5 minutes once the game starts.',
        'No take-backs.',
    ],
})
</script>

<template>
    <DefaultLayout>
        <div class="p-6 max-w-3xl mx-auto space-y-6 text-white">

            <!-- Header -->
            <div class="flex justify-between items-center border-b pb-4 border-white/10">
                <h4 class="text-lg font-bold">Challenge {{ challenge.id }}</h4>
                <Link as="button" :href="route('game.chess.index',[1])" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                    Accept
                </Link>
            </div>

            <!-- Challenger Info -->
            <section class="bg-white/5 p-4 rounded">
                <h3 class="text-lg font-semibold mb-2">Challenger</h3>
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 bg-gray-700 rounded-full flex items-center justify-center font-bold text-lg">
                        {{ challenge.challenger.avatar ? '' : challenge.challenger.name.charAt(0).toUpperCase() }}
                    </div>
                    <div>
                        <p class="font-semibold">{{ challenge.challenger.name }}</p>
                        <p class="text-xs text-gray-400">Rank: {{ challenge.challenger.rank }}</p>
                    </div>
                </div>
            </section>

            <!-- Challenge Details -->
            <section class="bg-white/5 p-4 rounded space-y-2">
                <h3 class="text-lg font-semibold mb-2">Challenge Details</h3>
                <p><span class="font-medium">Stake:</span> KES {{ challenge.stake }}</p>
                <p><span class="font-medium">Service Cost:</span> KES {{ challenge.serviceCost }}</p>
                <p><span class="font-medium">Winning Amount:</span> KES {{ challenge.stake * 2 - challenge.serviceCost }}</p>
                <p><span class="font-medium">Max Wait Time:</span> {{ challenge.maxWaitTime }}</p>
            </section>

            <!-- Rules -->
            <section class="bg-white/5 p-4 rounded space-y-2">
                <h3 class="text-lg font-semibold mb-2">Rules</h3>
                <ul class="list-disc list-inside text-sm text-gray-300">
                    <li v-for="(rule, index) in challenge.rules" :key="index">{{ rule }}</li>
                </ul>
            </section>
        </div>
    </DefaultLayout>
</template>
