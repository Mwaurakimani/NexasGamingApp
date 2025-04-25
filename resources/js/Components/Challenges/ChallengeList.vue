<script setup>
import ChallengeCard from './ChallengeCard.vue'

const props = defineProps(['challenges'])
</script>

<template>
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        <ChallengeCard v-for="challenge in challenges" :key="challenge.id" :challenge="challenge" />
    </div>
</template>
