<script setup>
import { ref } from 'vue'
const emit = defineEmits(['close'])

const form = ref({
    game: 'Chess',
    amount: 500
})
</script>

<template>
    <div class="fixed inset-0 bg-black bg-opacity-40 flex text-black justify-center items-center z-50">
        <div class="bg-white rounded shadow p-6 w-full max-w-md space-y-4">
            <h2 class="text-lg font-bold">Create New Challenge</h2>

            <div class="space-y-2">
                <label>Game</label>
                <select v-model="form.game" class="border px-3 py-1 rounded w-full">
                    <option>Chess</option>
                    <option>Draughts</option>
                </select>

                <label>Amount</label>
                <input type="number" v-model="form.amount" class="border px-3 py-1 rounded w-full" />
            </div>

            <div class="flex justify-end gap-2 pt-4">
                <button @click="emit('close')" class="text-sm text-gray-500">Cancel</button>
                <button class="text-sm bg-green-600 text-white px-4 py-1.5 rounded">Submit</button>
            </div>
        </div>
    </div>
</template>

<style scoped>
input {
    @apply text-black;
}
</style>
