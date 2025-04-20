<template>
    <div class="game-card">
        <div class="game-image">
            <img
                v-if="game.cover"
                :src="game.cover"
                :alt="game.name"
                class="game-img"
                @error="game.cover = null"
            />
            <div v-else class="fallback">
                {{ game.name.charAt(0).toUpperCase() }}
            </div>
        </div>
        <div class="game-name">{{ game.name }}</div>
        <div v-if="game.platform" class="platform-badge">
            {{ getPlatformIcon(game.platform) }}
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    game: Object
})

function getPlatformIcon(platform) {
    const icons = {
        ps: '🎮',
        pc: '🖥',
        arcade: '🕹',
        mobile: '📱'
    }
    return icons[platform] ?? ''
}
</script>

<style scoped>
.game-card {
    flex: 0 0 auto;
    width: 200px;
    height: 300px;
    background-color: #fff;
    border-radius: 1rem;
    padding: 1rem;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    text-align: center;
}

.game-image {
    height: 220px;
    background: #f1f1f1;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.2rem;
}

img.game-img {
    object-fit: cover;
    width: 100%;
    height: 100%;
}

.fallback {
    font-size: 2.5rem;
    font-weight: bold;
    height: 80px;
    width: 80px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    background-color: #000;
    color: #fff;
}

.game-name {
    font-size: 1rem;
    color: #222;
    font-weight: 500;
    margin-top: 0.5rem;
}

.platform-badge {
    font-size: 1.25rem;
    margin-top: 0.25rem;
}
</style>
