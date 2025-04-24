<script setup>
import ChallengeCard from './ChallengeCard.vue'

const dummyChallenges = [
    {
        id: 1,
        user: { name: 'Mwaura Kimani', avatar: null },
        game: 'Chess',
        amount: 500,
        status: 'Open',
        created_at: '2025-04-21 10:00'
    },
    {
        id: 2,
        user: { name: 'Jane Doe', avatar: null },
        game: 'Chess',
        amount: 1000,
        status: 'Open',
        created_at: '2025-04-20 14:30'
    }
]
</script>

<template>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        <ChallengeCard v-for="challenge in dummyChallenges" :key="challenge.id" :challenge="challenge" />
    </div>
</template>
