<template>
    <div class="bg-black text-white min-h-screen flex flex-col">
        <!-- Top Navigation Bar -->
        <header class="bg-black border-b border-white/10 px-4 py-3 flex justify-between items-center">
            <div class="text-lg font-bold">Nexus</div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex gap-6 text-sm text-white/80">
                <Link :href="route('home')" class="hover:text-white">Home</Link>
                <Link :href="route('challenges.index')" class="hover:text-white">Challenges</Link>
                <Link :href="route('account.profile')" class="hover:text-white">Profile</Link>
            </nav>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <slot />
        </main>

        <!-- Bottom Navigation for Mobile -->
        <nav class="fixed bottom-0 left-0 right-0 z-50 bg-black border-t border-white/10 md:hidden">
            <ul class="flex justify-around text-sm text-white/80">
                <li class="p-3 hover:text-white">
                    <a :href="route('home')">
                        <span class="block text-center">🏠</span>
                        <span class="block text-xs">Home</span>
                    </a>
                </li>
                <li class="p-3 hover:text-white">
                    <a :href="route('challenges.index')">
                        <span class="block text-center">⚔️</span>
                        <span class="block text-xs">Challenges</span>
                    </a>
                </li>
                <li class="p-3 hover:text-white">
                    <a :href="route('account.profile')">
                        <span class="block text-center">👤</span>
                        <span class="block text-xs">Profile</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<style scoped>
main {
    padding-bottom: 60px;
}
</style>
