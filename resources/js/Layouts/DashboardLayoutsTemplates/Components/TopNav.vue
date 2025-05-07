<script setup>
import {Link, router, usePage} from "@inertiajs/vue3";
import {computed, inject, ref} from "vue";
import {goFullScreen} from "@/Composables/GlobalHelpers.js";


const showDropdown = ref(false)
const page = usePage()
const providedTitle = inject('pageTitle', null)
const role = usePage().props.auth.user.role

const showBackButton = computed(() => page.url !== '/dashboard')

const pageTitle = computed(() => {
    if (providedTitle) return providedTitle ?? providedTitle.value
    return 'Dashboard'
})

function toggleDropdown() {
    showDropdown.value = !showDropdown.value
}

function logout() {
    window.Echo.leave('presence-users')
    showDropdown.value = false
    router.post(route('logout'), {onSuccess: () => router.get('/')})
}

function toggleFullscreen() {
    showDropdown.value = false

    const el = document.documentElement
    if (!document.fullscreenElement) {
        goFullScreen()
    } else {
        document.exitFullscreen?.()
    }
}

const userInitials = computed(() => {
    const user = usePage().props.auth?.user
    return user?.username?.charAt(0).toUpperCase() ?? 'U'
})
</script>

<template>
    <nav
        class="top-nav sticky-top px-4 flex items-center justify-end h-[60px] w-full bg-black border-b border-white/10">
        <div class="flex items-center gap-2 text-white text-sm flex-1">
            <button
                v-if="showBackButton"
                @click="router.visit('/dashboard')"
                class="text-white hover:opacity-80 md:hidden"
            >
                🔙
            </button>
            <h6 class="capitalize h6 p-0 m-0">{{ pageTitle }}</h6>
        </div>
        <div class="flex items-center gap-3 text-white text-sm">
            <!-- Wallet -->
            <div class="cursor-pointer text-xs hover:opacity-80">
                💰 KES 3,500
            </div>

            <!-- Notifications -->
            <div class="relative cursor-pointer hover:opacity-80">
                🔔
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] px-1 rounded-full">3</span>
            </div>

            <!-- Profile -->
            <div class="relative" v-click-outside="() => (showDropdown = false)" @click="toggleDropdown">
                <!-- Avatar -->
                <button
                    class="w-8 h-8 bg-white text-black rounded-full text-sm font-bold flex items-center justify-center focus:outline-none">
                    {{ userInitials ?? 'U' }}
                </button>

                <!-- Dropdown -->
                <div v-if="showDropdown"
                     class="absolute right-0 mt-2 w-40 bg-white text-black rounded shadow-md text-sm z-50">
                    <ul>
                        <li class="hover:bg-gray-100 px-4 py-2 cursor-pointer" @click="toggleFullscreen">
                            🔲 Fullscreen
                        </li>
                        <Link as="li" href="/" class="hover:bg-gray-100 px-4 py-2 cursor-pointer">
                            <span>🏠 Home</span>
                        </Link>
                        <Link as="li" href="/profile" class="hover:bg-gray-100 px-4 py-2 cursor-pointer">
                            <span>👤 Profile</span>
                        </Link>
                        <li class="hover:bg-gray-100 px-4 py-2 cursor-pointer">
                            <div @click.stop="logout">
                                <button type="button" class="w-full text-left">🚪 Logout</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </nav>
</template>

<style scoped lang="scss">

</style>
