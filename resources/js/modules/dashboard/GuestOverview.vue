<script setup>
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <div class="space-y-8 p-6 max-w-4xl mx-auto text-center text-black">
        <!-- Hero / Welcome -->
        <section>
            <h1 class="text-2xl font-bold">Welcome to Nexus Gaming 🎮</h1>
            <p class="text-gray-700 mt-2">
                Compete, stake, and dominate in retro and modern games. Verify your email now to get started!
            </p>
        </section>

        <!-- CTA -->
        <section class="space-y-2">
            <p class="text-lg mb-3">Ready to start winning?</p>
            <Link href="/register" class="bg-black text-white px-6 py-2 mb-3 rounded hover:opacity-90">
                Verify Account
            </Link>
            <p class="text-sm text-gray-500"><Link href="/" class="underline">Back to Home Page</Link></p>
        </section>
    </div>
</template>

<style scoped lang="scss">
</style>
