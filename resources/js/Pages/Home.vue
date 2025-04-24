<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import Hero from '@/modules/home/components/Hero.vue'
import GameListings from "@/modules/home/components/GameListings.vue";

const hostedGames = [
    {
        id: 1,
        name: 'Chess',
        cover: '/storage/images/games/chess.png',
        platform: 'arcade',
        link: route('challenges',{ game: 'Chess' }),
    },
    {
        id: 2,
        name: 'Call of Duty Mobile',
        cover: '/storage/images/games/codm.jpg',
        platform: 'mobile',
        link: '#', // Placeholder or future route
    },
]

const comingSoon = [
    {
        id: 3,
        name: 'Draughts',
        cover: '/storage/images/games/draughts.jpg',
        platform: 'arcade'
    }
]
</script>


<template>
    <DefaultLayout>
        <Hero/>
        <GameListings title="Games" :games="hostedGames"/>
        <GameListings title="Coming Soon" :games="comingSoon"/>
    </DefaultLayout>
</template>
