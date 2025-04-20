<template>
    <p v-if="message" class="input-error text-danger text-sm mt-1">
        {{ message }}
    </p>
</template>

<script setup>
defineProps({
    message: {
        type: String,
        default: '',
    },
})
</script>

<style scoped>
.input-error {
    font-weight: 500;
}
</style>
