<script setup>

</script>

<template>
    <div class="mobile-nav md:hidden">
        <ul class="flex justify-around items-center h-full">
            <Link :as="'li'" :href="'/dashboard'" class="flex flex-col items-center text-sm cursor-pointer">
                <div>🏠</div>
                <span class="text-[10px]">Dashboard</span>
            </Link>
            <li class="flex flex-col items-center text-sm cursor-pointer">
                <div>🎮</div>
                <span class="text-[10px]">Games</span>
            </li>
            <li class="flex flex-col items-center text-sm cursor-pointer">
                <div>💼</div>
                <span class="text-[10px]">Wallet</span>
            </li>
            <li class="flex flex-col items-center text-sm cursor-pointer">
                <div>⚙️</div>
                <span class="text-[10px]">Settings</span>
            </li>
        </ul>
    </div>
</template>

<style scoped lang="scss">
.mobile-nav {
    @apply fixed bottom-0 left-0 right-0 h-[60px] bg-black text-white z-50 border-t border-white/10;

    ul {
        @apply w-full;
    }

    li {
        @apply flex-1 text-center;
    }
}
</style>
