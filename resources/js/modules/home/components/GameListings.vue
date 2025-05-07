<template>
    <section class="game-listings container py-4">
        <h2 class="listing-title text-center mb-3">{{ title }}</h2>
        <div class="games-row">
            <GameCard v-for="game in games" :key="game.id" :game="game"/>
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
.game-listings {

    .listing-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #fff;
        margin-left: 1rem;
    }

    .games-row {
        display: flex;
        justify-content: center;
        flex-direction: row;
        overflow-x: auto;
        gap: 1rem;
        padding: 0.5rem;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch; // ✅ For smooth iOS scrolling

        &::-webkit-scrollbar {
            display: none;
        }
    }

    .games-row {
        scroll-snap-type: x mandatory;
    }
    .game-card {
        scroll-snap-align: start;
    }

}
</style>
