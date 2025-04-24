<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue'
import { TheChessboard } from 'vue3-chessboard'
import 'vue3-chessboard/style.css'
import DefaultLayout from "@/Layouts/DefaultLayout.vue"
import { router } from "@inertiajs/vue3"
import { boardConfig, handleCheckmate, handleOffline } from './mechanics.js'

// Props
const props = defineProps({
    user: {
        type: Object,
        default: () => ({
            id: 99,
            username: 'GuestPlayer',
            avatar: null,
            rating: 1450,
        }),
    },
})

// Challenge data
const challenge = ref({
    id: 101,
    stake: 50,
    payout: 90,
    service_fee: 10,
    timer: 10,
    player1: {
        id: 99,
        username: 'GuestPlayer',
        avatar: null,
        rating: 1450,
    },
    player2: {
        id: 100,
        username: 'GuestOpponent',
        avatar: null,
        rating: 1500,
    },
})

// Other refs
const logs = ref([
    "Player A moved to e4",
    "Player B moved to e5",
    "Player A moved to Nf3",
    "Player B moved to Nc6",
    "Player A moved to Bb5",
])

const boardAPI = ref(null)
const vsVisible = ref(true)

const guardMessage = 'You are in a live match. Leaving will result in a forfeit. Proceed?'

// Functions
const cancelInertiaGuard = router.on('before', (event) => {
    if (!confirm(guardMessage)) {
        event.cancel()
    }
})

function beforeUnloadHandler(event) {
    event.preventDefault()
    event.returnValue = 'Are you sure you want to leave the match? You may forfeit the game.'
}

// Lifecycle
onMounted(() => {
    window.addEventListener('beforeunload', beforeUnloadHandler)
    window.addEventListener('offline', handleOffline)

    // Hide VS modal after 5 seconds
    setTimeout(() => {
        vsVisible.value = false
    }, 5000)
})

onBeforeUnmount(() => {
    window.removeEventListener('beforeunload', beforeUnloadHandler)
    window.removeEventListener('offline', handleOffline)
    cancelInertiaGuard()
})
</script>

<template>
    <DefaultLayout>
        <div class="max-w-5xl mx-auto py-8 space-y-6">

            <!-- VS MODAL -->
            <div v-if="vsVisible" class="fixed inset-0 z-50 bg-black bg-opacity-80 flex items-center justify-center">
                <div class="bg-gray-900 p-6 rounded shadow text-white text-center space-y-4 max-w-md w-full">
                    <div class="flex items-center justify-center gap-10">
                        <!-- Player 1 -->
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center text-xl font-bold">
                                {{ challenge.player1.username[0] }}
                            </div>
                            <div class="mt-2 text-sm font-semibold">{{ challenge.player1.username }}</div>
                        </div>

                        <div class="text-3xl font-bold">VS</div>

                        <!-- Player 2 -->
                        <div class="flex flex-col items-center">
                            <div class="w-16 h-16 rounded-full bg-red-600 flex items-center justify-center text-xl font-bold">
                                {{ challenge.player2.username[0] }}
                            </div>
                            <div class="mt-2 text-sm font-semibold">{{ challenge.player2.username }}</div>
                        </div>
                    </div>

                    <div class="text-sm mt-4 space-y-1">
                        <div><strong>Stake:</strong> ${{ challenge.stake }}</div>
                        <div><strong>Winning:</strong> ${{ challenge.payout }}</div>
                        <div><strong>Service Fee:</strong> ${{ challenge.service_fee }}</div>
                        <div><strong>Timer:</strong> {{ challenge.timer }} min/player</div>
                    </div>
                </div>
            </div>

            <!-- STAKE INFO (Always Visible) -->
            <div class="text-white text-center bg-gray-700 p-3 rounded shadow mx-1">
                <div class="text-lg font-bold">Match Stake: ${{ challenge.stake }}</div>
                <div class="text-sm text-gray-300">Winner takes ${{ challenge.payout }} • Fee: ${{ challenge.service_fee }}</div>
            </div>

            <!-- CHESS BOARD -->
            <div class="bg-gray-800 p-2 mx-1 rounded shadow">
                <TheChessboard
                    :board-config="boardConfig"
                    @board-created="api => boardAPI = api"
                    @checkmate="handleCheckmate"
                />
            </div>

            <!-- MATCH LOGS -->
            <div class="bg-gray-900 p-2 mx-1 rounded shadow text-white text-sm space-y-2 max-h-64 overflow-y-auto">
                <h2 class="font-bold text-base border-b border-gray-700 pb-2 mb-2">Match Log</h2>
                <ul class="bg-black p-2 rounded">
                    <li v-for="(log, index) in logs" :key="index" class="border-gray-800 py-1 text-gray-400">
                        {{ log }}
                    </li>
                </ul>
            </div>

        </div>
    </DefaultLayout>
</template>
