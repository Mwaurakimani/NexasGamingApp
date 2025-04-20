<script setup>
import {computed, inject} from 'vue'
import {usePage} from '@inertiajs/vue3'
import DashboardShell from "@/Layouts/DashboardLayoutsTemplates/Components/DashboardShell.vue";
import MobileNav from "@/Layouts/DashboardLayoutsTemplates/Components/MobileNav.vue";
import TopNav from "@/Layouts/DashboardLayoutsTemplates/Components/TopNav.vue";

const page = usePage()
const providedTitle = inject('pageTitle', null)

const pageTitle = computed(() => providedTitle?.value ?? 'Welcome')
</script>

<template>
    <DashboardShell>
        <template #topnav>
            <TopNav/>
        </template>
        <template #mobilenav>
            <MobileNav/>
        </template>
        <slot/>
    </DashboardShell>
</template>

<style scoped lang="scss">
.guest-dashboard {
    @apply min-h-screen bg-black text-white;

    section {
        @apply overflow-auto min-h-[calc(100vh-60px)];
    }
}
</style>
