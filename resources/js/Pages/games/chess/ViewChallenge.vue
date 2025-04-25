<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import { ref } from 'vue'
import {route} from "ziggy-js";

const props = defineProps(['match'])

const challenge = ref({
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
                <h4 class="font-bold">Challenge: #...{{ match.id.slice(-6).toUpperCase() }}</h4>
                <Link as="button" :href="route('game.chess.index',match.id)" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">
                    Accept
                </Link>
            </div>

            <!-- Challenger Info -->
            <section class="bg-white/5 p-4 rounded">
                <h3 class="text-lg font-semibold mb-2">Challenger</h3>
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 bg-gray-700 rounded-full flex items-center justify-center font-bold text-lg">
                        {{ match.participants[0].user.username.charAt(0).toUpperCase() }}
                    </div>
                    <div>
                        <p class="font-semibold">{{ match.participants[0].user.username }}</p>
<!--                        <p class="text-xs text-gray-400">Rank: {{ challenge.challenger.rank }}</p>-->
                    </div>
                </div>
            </section>

            <!-- Challenge Details -->
            <section class="bg-white/5 p-4 rounded space-y-2">
                <h3 class="text-lg font-semibold mb-2">Challenge Details</h3>
                <p><span class="font-medium">Stake:</span> KES {{ match.stake }}</p>
                <p><span class="font-medium">Service Cost:</span> KES {{ match.service_fee }}</p>
                <p><span class="font-medium">Winning Amount:</span> KES {{ match.stake * 2 - match.service_fee }}</p>
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
