<script setup>

import InputError from "@/Components/InputError.vue";

const props = defineProps(['matchForm'])
const emit = defineEmits(['save_match'])


const emit_save_match = () => {
    emit('save_match')
}
</script>

<template>
    <form class="p-[20px] flex flex-wrap">
        <article class="w-1/2">
            <div class="p-[10px] mb-[5px]">
                <label class="block text-[15px]">Mode</label>
                <select v-model="matchForm.mode">
                    <option value="BRS">Battle Royal (Solo)</option>
                    <option value="BRD">Battle Royal (Duo)</option>
                    <option value="BRQ">Battle Royal (Quad)</option>
                    <option value="1v1">1 v 1</option>
                    <option value="2v2">2 v 2</option>
                    <option value="5v5">2 v 2</option>
                </select>
                <InputError class="mt-2" :message="matchForm.errors.mode"/>
            </div>
            <div class="p-[10px] mb-[5px]">
                <label class="block text-[15px]">Date</label>
                <input v-model="matchForm.date" class="rounded" type="date" required>
                <InputError class="mt-2" :message="matchForm.errors.date"/>
            </div>
            <div class="p-[10px] mb-[5px]">
                <label class="block text-[15px]">Teams</label>
                <input v-model="matchForm.teams" class="rounded" type="number" min="0" required>
                <InputError class="mt-2" :message="matchForm.errors.teams"/>
            </div>

        </article>
        <article class="w-1/2">
            <div class="p-[10px] mb-[5px]">
                <label class="block text-[15px]">Status</label>
                <select v-model="matchForm.status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
                <InputError class="mt-2" :message="matchForm.errors.status"/>
            </div>
            <div class="p-[10px] mb-[5px]">
                <label class="block text-[15px]">Time</label>
                <input v-model="matchForm.time" class="rounded" type="time" required>
                <InputError class="mt-2" :message="matchForm.errors.time"/>
            </div>
            <div class="p-[10px] mb-[5px]">
                <label class="block text-[15px]">Stake (T)</label>
                <input v-model="matchForm.stake" class="rounded" type="number" min="0" required>
                <InputError class="mt-2" :message="matchForm.errors.stake"/>
            </div>
        </article>
        <div class="w-full">
            <button class="block w-full  py-[6px] rounded" @click.prevent="emit_save_match">Save</button>
        </div>
    </form>
</template>

<style scoped lang="scss">
button {
    @apply bg-gray-300 ;

    &:hover {
        @apply bg-gray-400 text-white;
    }

    &:active {
        transition: all ease-in-out 0.3ms;
        @apply bg-gray-700 text-white;
    }
}

input, select {
    display: block !important;
    width: 80%;
    border: 1px solid lightgray;
    outline: none;
    @apply rounded
}
</style>
