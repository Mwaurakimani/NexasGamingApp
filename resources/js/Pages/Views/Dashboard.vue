<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import MatchCard from "@/Components/App/MatchCard.vue";
import {usePage} from "@inertiajs/vue3";

</script>
<template>
    <DashboardLayout>
        <div class="w-[100%] text-gray-600 mx-auto mb-[20px]">
            <p>Hello</p>
<!--            <h1 class="font-bold text-[20px]">{{username}}</h1>-->
        </div>
        <div class="flex">
            <section>
                <div class="w-full px-[5px] justify-between mx-auto rounded-md">
                    <div class="flex gap-2 flex-wrap mb-[40px]">
                        <div
                            class=" w-[100%] md:w-[49%] mb-[50px] md:mb-[30px] md:items-stretch bg-white text-gray-600 mx-auto">
                            <h2 class="text-[18px] mb-[5px]">Credits</h2>
                            <div
                                class="shadow-lg md:items-stretch rounded-[10px] p-[5px] bg-white text-gray-600 h-[100%]">
                                <h1 class="font-bold py-[10px] text-[20px] text-right mb-[10px] flex justify-between">
                                    <p>Balance</p>
                                    <p>Ksh 5,000</p>
                                </h1>
                                <div class="px-[5px] flex justify-between mb-[10px]">
                                    <button class="bg-gray-300 px-[14px] py-[5px] rounded">Deposit</button>
                                    <button class="bg-gray-300 px-[14px] py-[5px] rounded">Withdraw</button>
                                </div>
                                <div class="rounded">
                                    <table id="leader_board_mobile" class="w-full rounded overflow-hidden">
                                        <thead class="bg-black text-white">
                                        <tr>
                                            <th>Position</th>
                                            <th>Username</th>
                                            <th>Score</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(idx,item) in 8">
                                            <td class="p-[3px]">{{ idx }}</td>
                                            <td>Mwaurakimani</td>
                                            <td>100</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="md:w-[49%]">
                            <h2 class="text-[18px] mb-[5px]">Current Matches</h2>
                            <MatchCard class="md:shadow-lg"></MatchCard>
                        </div>
                    </div>
                </div>
                <div class="bg-white md:p-[5px] rounded">
                    <div class="flex justify-between items-center mb-[10px]">
                        <h2 class="text-[18px] mb-[5px]">Leader Board</h2>
                        <div>
                            <select class="border-gray-500 rounded">
                                <option value="Daily">Daily</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                            </select>
                        </div>
                    </div>
                    <div class="shadow-lg p-[5px] rounded-lg">
                        <table id="leader_board_mobile" class="w-full overflow-hidden">
                            <thead class="bg-black text-white">
                            <tr>
                                <th>Position</th>
                                <th>Username</th>
                                <th>Score</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(idx,item) in 10">
                                <td class="p-[10px]">{{ idx }}</td>
                                <td>Mwaurakimani</td>
                                <td>100</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <section class="w-[600px] h-[300px] hidden xl:block">
                <div class="w-full px-[5px] justify-between mx-auto rounded-md">
                    <h2 class="text-[18px] mb-[5px]">Moderator</h2>
                    <div class="w-[100%] h-[370px] bg-red-400 rounded shadow-lg">

                    </div>
                </div>
            </section>
        </div>
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
