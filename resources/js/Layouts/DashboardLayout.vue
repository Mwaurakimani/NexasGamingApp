<script setup>
import {router, usePage} from "@inertiajs/vue3";
import {computed, onMounted} from "vue";
import AdminDashboardLayout from "@/Layouts/DashboardLayoutsTemplates/AdminDashboardLayout.vue";
import ModeratorDashboardLayout from "@/Layouts/DashboardLayoutsTemplates/ModeratorDashboardLayout.vue";
import GuestDashboardLayout from "@/Layouts/DashboardLayoutsTemplates/GuestDashboardLayout.vue";
import PlayerDashboardLayout from "@/Layouts/DashboardLayoutsTemplates/PlayerDashboardLayout.vue";
import { useNotificationStore } from '@/stores/notificationStore'

const page = usePage()
const role = page.props.Dashboards.role

const notificationStore = useNotificationStore()

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
let reloadTimeout = null
function scheduleDatasetReload(delay = 300) {
    if (reloadTimeout) clearTimeout(reloadTimeout)

    reloadTimeout = setTimeout(() => {
        router.reload({ only: ['dataset'] })
    }, delay)
}


onMounted(() => {
    if (page.props.auth && page.props.auth.user) {
        window.Echo.join('presence-users')
            .here((users) => {
                scheduleDatasetReload()
            })
            .joining((user) => {
                scheduleDatasetReload()
            })
            .leaving((user) => {
                scheduleDatasetReload()
            });
        notificationStore.subscribe()

    }
})

</script>

<template>
    <component :is="dashboard">
        <slot />
    </component>
</template>
