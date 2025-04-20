<script setup>
import DashboardShell from "@/Layouts/DashboardLayoutsTemplates/Components/DashboardShell.vue";
import SideNavigation from "@/Layouts/DashboardLayoutsTemplates/Components/SideNavigation.vue";
import TopNav from "@/Layouts/DashboardLayoutsTemplates/Components/TopNav.vue";
import MobileNav from "@/Layouts/DashboardLayoutsTemplates/Components/MobileNav.vue";
</script>

<template>
    <DashboardShell>
        <template #sidebar><SideNavigation /></template>
        <template #topnav><TopNav /></template>
        <template #mobilenav><MobileNav /></template>
        <slot />
    </DashboardShell>
</template>

