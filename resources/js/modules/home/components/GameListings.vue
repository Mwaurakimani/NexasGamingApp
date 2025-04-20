<template>
    <section class="game-listings container py-4">
        <h2 class="listing-title mb-3">{{ title }}</h2>
        <div class="games-row">
            <GameCard v-for="game in games" :key="game.id" :game="game" />
        </div>
    </section>
</template>

<script setup>
import GameCard from './GameCard.vue'

defineProps({
    title: String,
    games: Array
})
</script>

<style lang="scss" scoped>
@use '@scss/modules/home/carousel';
</style>
