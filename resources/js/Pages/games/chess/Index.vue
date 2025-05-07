<script setup>

import ChessGame from "@/modules/games/chess/ChessGame.vue";
const props = defineProps(['match','logs'])

const virtualUser = {
    id: 99,
    username: 'GuestPlayer',
    avatar: null,
    rating: 1450,
}

const challenge = {
    id: 101,
    stake: 50,
    payout: 90,
    service_fee: 10,
    timer: 10, // minutes per player
    challenger: {
        id: 1,
        username: 'ProChesser',
        avatar: null,
        rating: 1600,
    }
}

</script>

<template>
    <div class="min-h-screen bg-black text-white">
        <ChessGame :user="virtualUser" :challenge="challenge" :match :logs />
    </div>
</template>
