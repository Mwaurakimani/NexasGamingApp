<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import MatchCard from "@/Components/App/MatchCard.vue";
</script>
<template>
    <DashboardLayout>
        <div class="w-full px-[10px] pb-[30px] justify-between mx-auto md:max-w-[750px] rounded">
            <div class="flex gap-2 flex-wrap md:flex-nowrap mb-[40px]">
                <div class="w-[100%] mmb-[50px] rounded-[10px] p-[10px] bg-white text-gray-600 mx-auto">
                    <p>Hello</p>
                    <h1 class="font-bold text-[20px] mb-[20px]">Mwaura Kimani</h1>
                </div>
                <div class="shadow-lg w-[100%] md:w-[100%] mb-[50px] rounded-[10px] p-[10px] bg-white text-gray-600 mx-auto">
                    <h2 class="text-[20px] mb-[5px]">Transactions</h2>
                    <h1 class="font-bold p-[20px] text-[20px] text-right mb-[30px] flex justify-between">
                        <p>Balance</p>
                        <p>Ksh 5,000</p>
                    </h1>
                    <div class="px-[20px] flex justify-between mb-[40px]">
                        <button class="bg-gray-300 px-[14px] py-[5px] rounded">Deposit</button>
                        <button class="bg-gray-300 px-[14px] py-[5px] rounded">Withdraw</button>
                    </div>
                    <table id="leader_board_mobile" class="w-full border">
                        <thead class="bg-black text-white">
                        <tr>
                            <th>Position</th>
                            <th>Username</th>
                            <th>Score</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(idx,item) in 5">
                            <td class="p-[3px]">{{idx}}</td>
                            <td>Mwaurakimani</td>
                            <td>100</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <h2 class="text-[20px] mb-[10px] lg:text-white">Current Matches</h2>
                    <MatchCard></MatchCard>
                </div>
            </div>
            <div class="bg-white md:p-[5px] rounded">
                <div class="flex justify-between items-center mb-[10px]">
                    <h2 class="text-[20px] mb-[10px]">Leaders Board</h2>
                    <div>
                        <select class="border-gray-500 rounded">
                            <option value="Daily">Daily</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Monthly">Monthly</option>
                        </select>
                    </div>
                </div>
                <table id="leader_board_mobile" class="w-full border">
                    <thead class="bg-black text-white">
                    <tr>
                        <th>Position</th>
                        <th>Username</th>
                        <th>Score</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(idx,item) in 10">
                        <td class="p-[10px]">{{idx}}</td>
                        <td>Mwaurakimani</td>
                        <td>100</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </DashboardLayout>
</template>

<style lang="scss" scoped>
button:active {
    transition: all ease-in-out 0.3ms;
    @apply bg-gray-700 text-white;
}

#leader_board_mobile {

    th{
        height: 30px;
    }
    tr:nth-of-type(even){
        background-color: grey;
        @apply text-white
    }

    tr{
        @apply px-[10px];
    }
}


</style>
