<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import UsuportedDevice from "@/Components/App/UsuportedDevice.vue";
</script>

<template>
    <DashboardLayout>
        <UsuportedDevice/>
        <section class="hidden lg:block">
            <h1 class="font-bold text-[20px] mb-[20px]">Transactions</h1>
        </section>
    </DashboardLayout>
</template>
