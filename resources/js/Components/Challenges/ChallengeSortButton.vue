<script setup>
const emit = defineEmits(['open-filter'])
</script>

<template>
    <button @click="emit('open-filter')" class="sort-filter-btn">
        <span>Sort/Filter</span>
        <span>🔽</span>
    </button>
</template>

<style scoped>
.sort-filter-btn {
    @apply border rounded flex items-center px-1 gap-1 text-sm;
    background-color: transparent;
    color: #d1d5db; /* Tailwind's gray-300 for readability on dark */
    transition: background-color 0.2s ease, color 0.2s ease;
}

.sort-filter-btn:hover {
    background-color: #f3f4f6; /* Tailwind's gray-100 */
    color: #111827; /* Tailwind's gray-900 for contrast on light background */
}
.sort-filter-btn:active {
    color: #111827;
}
.sort-filter-btn:focus{
    @apply text-white;
}
</style>
