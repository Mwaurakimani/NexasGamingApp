<script setup>
import { ref } from 'vue'
const emit = defineEmits(['close'])

const filters = ref({
    amount: '',
    status: '',
    game: ''
})
</script>

<template>
    <div class="fixed inset-0 bg-black bg-opacity-40 flex justify-center items-center z-50 text-black">
        <div class="bg-white rounded shadow p-6 w-full max-w-md space-y-4">
            <h2 class="text-lg font-bold">Filter Challenges</h2>

            <div class="space-y-2">
                <label>Amount</label>
                <input v-model="filters.amount" class="border px-3 py-1 rounded w-full" />

                <label>Status</label>
                <select v-model="filters.status" class="border px-3 py-1 rounded w-full">
                    <option value="">All</option>
                    <option>Open</option>
                    <option>Matched</option>
                </select>

                <label>Game</label>
                <input v-model="filters.game" class="border px-3 py-1 rounded w-full" />
            </div>

            <div class="flex justify-end gap-8 pt-4">
                <button @click="emit('close')" class="text-sm text-gray-500">Cancel</button>
                <button @click="filters.value = {}; emit('close')" class="text-sm text-red-500">Reset</button>
                <button @click="emit('close')" class="text-sm bg-blue-600 text-white px-4 py-1.5 rounded">Apply</button>
            </div>
        </div>
    </div>
</template>
