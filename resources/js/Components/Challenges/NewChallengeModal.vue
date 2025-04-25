<script setup>
import { useForm } from '@inertiajs/vue3'
const emit = defineEmits(['close'])

defineProps(['errors'])

const availableGames = [
    { key: '1', name: 'Chess' },
]

const matchTypes = [
    { key: 1, name: '1 vs 1' },
]

// Using useForm for reactive form + errors
const form = useForm({
    game_key: 1,
    match_type_key: 1,
    stake: 50,
    timer: 1,
    config: {}
})

const submit = () => {
    form.post('/matches', {
        onSuccess: () => emit('close')
    })
}
</script>

<template>
    <div class="fixed inset-0 bg-black bg-opacity-40 flex text-black justify-center items-center z-50">
        <div class="bg-white rounded shadow p-6 w-full max-w-md space-y-4  mx-5">
            <h2 class="text-lg font-bold">Create New Challenge</h2>

            <div class="space-y-2">

                <div>
                    <label class="font-semibold">Game</label>
                    <select v-model="form.game_key" class="border px-3 py-1 rounded w-full">
                        <option v-for="game in availableGames" :key="game.key" :value="game.key">
                            {{ game.name }}
                        </option>
                    </select>
                    <p v-if="errors.game_key" class="text-xs text-red-600 mt-1">{{ form.errors.game_key }}</p>
                </div>

                <div>
                    <label class="font-semibold">Match Type</label>
                    <select v-model="form.match_type_key" class="border px-3 py-1 rounded w-full">
                        <option v-for="type in matchTypes" :key="type.key" :value="type.key">
                            {{ type.name }}
                        </option>
                    </select>
                    <p v-if="errors.match_type_key" class="text-xs text-red-600 mt-1">{{ form.errors.match_type_key }}</p>
                </div>

                <div>
                    <label class="font-semibold">Stake Amount (Ksh)</label>
                    <input type="number" v-model="form.stake" min="20" class="border px-3 py-1 rounded w-full" />
                    <p v-if="errors.stake" class="text-xs text-red-600 mt-1">{{ form.errors.stake }}</p>
                </div>

                <div>
                    <label class="font-semibold">Timer (minutes per player)</label>
                    <input type="number" v-model="form.timer" min="1" class="border px-3 py-1 rounded w-full" />
                    <p v-if="errors.timer" class="text-xs text-red-600 mt-1">{{ form.errors.timer }}</p>
                </div>

            </div>

            <div class="flex justify-end gap-2 pt-4">
                <button @click="emit('close')" class="text-sm text-gray-500">Cancel</button>
                <button @click="submit" class="text-sm bg-green-600 text-white px-4 py-1.5 rounded" :disabled="form.processing">
                    Submit
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
input {
    @apply text-black;
}
</style>
