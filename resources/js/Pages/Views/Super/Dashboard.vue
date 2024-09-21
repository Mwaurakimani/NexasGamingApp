<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
</script>
<template>
    <DashboardLayout>
        <div class="w-[100%] text-gray-600 mx-auto mb-[20px]">
            <p>Hello</p>
            <h1 class="font-bold text-[20px]">Mwaura Kimani</h1>
        </div>
        <section class="flex flex-wrap justify-evenly gap-x-2 gap-y-3">
            <div v-for="item in 20" class="bg-red-400 p-[10px] h-[100px] w-[200px]">

            </div>
        </section>
    </DashboardLayout>
</template>

<style lang="scss" scoped>
button:active {
    transition: all ease-in-out 0.3ms;
    @apply bg-gray-700 text-white;
}

#leader_board_mobile {

    th {
        height: 30px;
    }

    tr:nth-of-type(even) {
        background-color: grey;
        @apply text-white
    }

    tr {
        @apply px-[10px];
    }
}


</style>
