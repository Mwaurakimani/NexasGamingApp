<script setup>
import DefaultLayout from '@/Layouts/DefaultLayout.vue'
import ChallengeList from '@/Components/Challenges/ChallengeList.vue'
import ChallengeFilterModal from '@/Components/Challenges/ChallengeFilterModal.vue'
import ChallengeSortButton from '@/Components/Challenges/ChallengeSortButton.vue'
import NewChallengeModal from '@/Components/Challenges/NewChallengeModal.vue'

import {ref} from 'vue'
const props = defineProps(['challenges','errors'])
const showFilter = ref(false)
const showNewChallenge = ref(false)
</script>

<template>
    <DefaultLayout>
        <div class="p-6 space-y-6">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold">Challenges</h1>
                <div class="flex gap-2">
                    <ChallengeSortButton @open-filter="showFilter = true"/>
                    <button @click="showNewChallenge = true" class="bg-blue-600 text-white px-2 py-1 text-sm rounded">
                        + New Challenge
                    </button>
                </div>
            </div>

            <ChallengeList v-if="challenges.length > 0" :challenges/>
            <div v-else>
                <p class="bg-gray-900 text-center py-6">No Challenges Available</p>
            </div>

            <ChallengeFilterModal v-if="showFilter" @close="showFilter = false"/>
            <NewChallengeModal v-if="showNewChallenge" @close="showNewChallenge = false" :errors/>
        </div>
    </DefaultLayout>
</template>
