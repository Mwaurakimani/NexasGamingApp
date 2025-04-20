<script setup>
import {usePage} from '@inertiajs/vue3'
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {defineAsyncComponent} from "vue";

const page = usePage()
const role = page.props.Dashboards.role ?? 'Guest'

const component = defineAsyncComponent(() => {
    const components = {
        "Player": () => import('@/modules/dashboard/PlayerOverview.vue'),
        "Moderator": () => import('@/modules/dashboard/ModeratorOverview.vue'),
        "Manager": () => import('@/modules/dashboard/ManagerOverview.vue'),
        "Admin": () => import('@/modules/dashboard/AdminOverview.vue'),
        "Super Admin": () => import('@/modules/dashboard/SuperAdminOverview.vue'),
    }

    // Return the matching component function OR fallback
    return components[role]?.() ?? import('@/modules/dashboard/GuestOverview.vue')
})

</script>

<template>
    <DashboardLayout>
        <section class="p-6 space-y-6">
            <component :is="component" v-bind="page.props" />
        </section>
    </DashboardLayout>
</template>
