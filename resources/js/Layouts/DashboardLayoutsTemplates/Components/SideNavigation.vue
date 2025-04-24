<script setup>
import {usePage} from '@inertiajs/vue3'

const page = usePage()
const role = page.props.auth?.user?.role ?? 'Guest'

const isActive = (startsWith) => page.url.startsWith(startsWith)

const hasRole = (check) => {
    const hierarchy = ['Guest', 'Player', 'Moderator', 'Manager', 'Admin', 'Super Admin']
    return hierarchy.indexOf(role) >= hierarchy.indexOf(check)
}
</script>

<template>
    <div class="side-navigation pt-4 hidden md:block">
        <div class="mb-4 flex justify-center">
            <img
                style="height: 40px"
                class="object-contain"
                src="/storage/system/Asset%202.png"
                alt="Nexus Logo"
            />
        </div>

        <section>
            <!-- Player / Guest Links -->
            <ul class="space-y-2">
                <Link :href="'/dashboard'" :as="'li'"
                      :class="[ 'p-1 rounded cursor-pointer', isActive('/dashboard') ? 'bg-white/20 font-bold' : 'hover:bg-white/10' ]">
                    🏠 Dashboard
                </Link>
                <li :class="[ 'p-1 rounded cursor-pointer', isActive('/games') ? 'bg-white/20 font-bold' : 'hover:bg-white/10' ]">
                    🎮 Games
                </li>
                <li :class="[ 'p-1 rounded cursor-pointer', isActive('/wallet') ? 'bg-white/20 font-bold' : 'hover:bg-white/10' ]">
                    💼 Wallet
                </li>
                <li :class="[ 'p-1 rounded cursor-pointer', isActive('/settings') ? 'bg-white/20 font-bold' : 'hover:bg-white/10' ]">
                    ⚙️ Settings
                </li>
            </ul>

            <!-- Moderator Section -->
            <template v-if="hasRole('Moderator')">
                <hr class="my-4 border-white/20"/>
                <h6 class="text-xs uppercase text-white/60 font-bold mb-2 px-1">Moderator Panel</h6>
                <ul class="space-y-2">
                    <li :class="[ 'p-1 rounded cursor-pointer', isActive('/moderation') ? 'bg-white/20 font-bold' : 'hover:bg-white/10' ]">
                        🛡️ Dispute Center
                    </li>
                </ul>
            </template>

            <!-- Manager Section -->
            <template v-if="hasRole('Manager')">
                <hr class="my-4 border-white/20"/>
                <h6 class="text-xs uppercase text-white/60 font-bold mb-2 px-1">Manager Tools</h6>
                <ul class="space-y-2">
                    <li :class="[ 'p-1 rounded cursor-pointer', isActive('/tournaments') ? 'bg-white/20 font-bold' : 'hover:bg-white/10' ]">
                        🏆 Manage Tournaments
                    </li>
                </ul>
            </template>

            <!-- Admin Section -->
            <template v-if="hasRole('Admin')">
                <hr class="my-4 border-white/20"/>
                <h6 class="text-xs uppercase text-white/60 font-bold mb-2 px-1">Admin Tools</h6>
                <ul class="space-y-2">
                    <Link as="li" :href="route('admin.users')"
                          :class="[ 'p-1 rounded cursor-pointer', isActive('/users') ? 'bg-white/20 font-bold' : 'hover:bg-white/10' ]">
                        👥 Manage Users
                    </Link>
                </ul>
            </template>

            <!-- Super Admin Section -->
            <template v-if="hasRole('Super Admin')">
                <hr class="my-4 border-white/20"/>
                <h6 class="text-xs uppercase text-white/60 font-bold mb-2 px-1">Super Admin</h6>
                <ul class="space-y-2">
                    <li :class="[ 'p-1 rounded cursor-pointer', isActive('/system') ? 'bg-white/20 font-bold' : 'hover:bg-white/10' ]">
                        🧠 System Control
                    </li>
                </ul>
            </template>
        </section>
    </div>
</template>

<style scoped lang="scss">
.side-navigation {
    @apply h-full w-full px-4 transition-all;
}
</style>
