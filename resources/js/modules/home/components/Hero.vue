<template>
    <section class="hero container py-5 text-center">
        <h1 class="hero__title mb-3">Welcome to <span class="hero__brand">Nexus Gaming</span></h1>
        <p class="hero__subtitle mb-4">Stake. Compete. Win.</p>
        <button @click.prevent="router.get(route('login'))" class="btn btn-outline-light btn-lg">Get Started</button>
    </section>
</template>

<script setup>
import {router} from "@inertiajs/vue3";
</script>

<style lang="scss" scoped>
@use '@scss/modules/home/hero' as hero;
</style>
