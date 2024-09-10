<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import MatchCard from "@/Components/App/MatchCard.vue";
</script>

<template>
    <DashboardLayout>
        <div class="w-full px-[10px] pb-[30px] justify-between mx-auto md:max-w-[750px] rounded">
            <h1 class="font-bold text-[20px] mb-[5px]">Matches</h1>
            <div class="flex gap-2 flex-wrap md:flex-nowrap mb-[30px]">
                <h2 class="text-[20px] mb-[10px] lg:text-white">Current Matches</h2>
                <MatchCard :fixture="true"></MatchCard>
            </div>
            <div class="">
                <h2 class="text-[20px] mb-[10px] lg:text-white">Past Matches</h2>
                <section class=" flex flex-wrap mb-[20px] gap-2 justify-between">
                    <MatchCard class="max-w-[350px]" v-for="item in 6" :results="true"></MatchCard>
                </section>
                <div class="flex justify-between w-full">
                    <button>Previous</button>
                    <button>Next</button>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>

<style scoped lang="scss">
button {
    @apply bg-gray-300 px-[30px] py-[5px] rounded;
    &:active {
        transition: all ease-in-out 0.3ms;
        @apply bg-gray-700 text-white;
    }
}
</style>
