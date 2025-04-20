<script setup>
import {usePage} from "@inertiajs/vue3";
import {computed} from "vue";
import AdminDashboardLayout from "@/Layouts/DashboardLayoutsTemplates/AdminDashboardLayout.vue";
import ModeratorDashboardLayout from "@/Layouts/DashboardLayoutsTemplates/ModeratorDashboardLayout.vue";
import GuestDashboardLayout from "@/Layouts/DashboardLayoutsTemplates/GuestDashboardLayout.vue";
import PlayerDashboardLayout from "@/Layouts/DashboardLayoutsTemplates/PlayerDashboardLayout.vue";

const page = usePage()
const role = page.props.Dashboards.role

let dashboard = computed(() => {
    switch (role) {
        case "Super Admin":
        case "Admin":
            return AdminDashboardLayout
        case "Moderator":
        case "Manager":
            return ModeratorDashboardLayout
        case "Player":
            return PlayerDashboardLayout
        default:
            return GuestDashboardLayout
    }
})
</script>

<template>
    <component :is="dashboard">
        <slot />
    </component>
</template>
