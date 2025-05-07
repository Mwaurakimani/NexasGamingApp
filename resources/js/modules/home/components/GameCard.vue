<template>
    <component :is="wrapper" :href="game.link"
               class="game-card rounded-xl text-center p-1 bg-white w-[200px] md:w-[250px]">
        <div class="game-image rounded h-[150px]">
            <img v-if="game.cover" :src="game.cover" :alt="game.name" class="w-full h-full rounded-xl"
                 style="object-fit: cover" @error="game.cover = null"/>

            <div v-else class="fallback">
                {{ game.name.charAt(0).toUpperCase() }}
            </div>
        </div>
        <div class="game-name">{{ game.name }}</div>
        <div v-if="game.platform" class="platform-badge">
            {{ getPlatformIcon(game.platform) }}
        </div>
    </component>
</template>

<script setup>
import {Link} from '@inertiajs/vue3'

const props = defineProps({
    game: Object
})

// Dynamically choose to use Link or div as root element
const wrapper = props.game.link ? Link : 'div'

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


<style scoped lang="scss">
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
    margin-top: 0.2rem;
}

.platform-badge {
    font-size: 1.25rem;
    margin-top: 0.2rem;
}
</style>
