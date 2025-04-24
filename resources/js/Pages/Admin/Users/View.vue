<script setup>
import {Head, Link} from '@inertiajs/vue3'
import DashboardLayout from "@/Layouts/DashboardLayout.vue";
import {provide} from "vue";

const props = defineProps({
    user: Object,
    stats: Object,
    // transactions: Array,
    // matches: {
    //     played: Array,
    //     upcoming: Array,
    // },
})

provide('pageTitle', 'User Management')

</script>

<template>
    <DashboardLayout>
        <Head title="View User" />

        <div class="p-6 space-y-6 text-black max-w-7xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <h1 class="text-xl font-bold">User: {{ user.username }}</h1>
                <Link
                    :href="route('admin.users.edit', user.id)"
                    class="text-blue-600 hover:underline"
                >
                    ✏️ Edit User
                </Link>
            </div>

            <!-- Layout: Grid -->
            <div class="grid md:grid-cols-4 gap-6">
                <!-- Main Info and Tabs -->
                <div class="md:col-span-3 space-y-4">
                    <div class="bg-white p-4 rounded shadow space-y-2">
                        <p><strong>Email:</strong> {{ user.email }}</p>
                        <p><strong>Phone:</strong> {{ user.phone_number }}</p>
                        <p><strong>Role:</strong> {{ user.role }}</p>
                        <p><strong>Status:</strong> {{ user.is_active }}</p>
                    </div>

                    <!-- Tabs: transactions, matches -->
                    <!--                <UserTabs-->
                    <!--                    :transactions="transactions"-->
                    <!--                    :played="matches.played"-->
                    <!--                    :upcoming="matches.upcoming"-->
                    <!--                />-->
                </div>

                <!-- Sidebar Stats -->
                <div class="md:col-span-1">
                    <!--                <UserStatsPanel :stats="stats" :balance="user.balance" />-->
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>
