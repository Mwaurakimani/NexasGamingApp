<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import MatchCard from "@/Components/App/MatchCard.vue";
</script>

<template>
    <DashboardLayout>
        <div class="w-full pb-[30px] justify-between mx-auto md:max-w-[750px] rounded">
            <h1 class="font-bold text-[20px] mb-[20px]">Matches ID: M_0001</h1>
            <div class="flex gap-2 flex-wrap md:flex-nowrap mb-[30px]">
                <MatchCard :fixture="true"></MatchCard>
            </div>
            <div class="border-1 border-gray-200 p-[10px] rounded mb-[30px]">
                <ul class="">
                    <li class="flex py-[10px] border-b-2 justify-between"><p>Score</p> <strong>5</strong></li>
                    <li class="flex py-[10px] border-b-2 justify-between"><p>Winning</p>
                        <strong>
                            <div class="flex justify-center items-center mb-[10px]">
                                <img class="w-[20px]" src="/storage/system/Coin%20Dark.png">
                                <p class="text-center mx-[5px]">50</p>
                            </div>
                        </strong>
                    </li>
                    <li class="flex py-[10px] border-b-2 justify-between"><p>Date:</p>
                        <strong>
                            <div class="flex justify-center items-center mb-[10px]">
                                <img class="w-[20px]" src="/storage/system/Coin%20Dark.png">
                                <p class="text-center mx-[5px]">50 (-10%)</p>
                            </div>
                        </strong>
                    </li>
                    <li class="flex py-[10px]  justify-between"><p>Payout</p>
                        <strong>
                            <div class="flex justify-center items-center mb-[10px]">
                                <img class="w-[20px]" src="/storage/system/Coin%20Dark.png">
                                <p class="text-center mx-[5px]">50</p>
                            </div>
                        </strong>
                    </li>
                </ul>
            </div>
            <div class="mb-[30px]">
                <h2 class="text-[20px] mb-[5px] lg:text-white">Results</h2>
                <div class="flex items-center justify-between mb-[5px] flex-wrap">
                    <label>Kills</label>
                    <input class="w-[50px] border-1 border-gray-400 h-[30px] rounded" type="number">
                    <ul class="w-full flex justify-between py-[20px]">
                        <button>Confirm Results</button>
                        <button>Dispute Results</button>
                    </ul>
                </div>
                <p class="mb-[10px] text-red-500">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam, aspernatur commodi dolore dolores
                    fugiat harum ipsa, modi nam nemo, odio repudiandae sit tenetur. Ad aperiam dignissimos et hic magni
                    quaerat?
                </p>
            </div>
            <form>
                <h2 class="text-[20px] mb-[5px] lg:text-white">Dispute</h2>
                <div class="flex items-center justify-between mb-[3px] flex-wrap">
                    <label class="bg-gray-300 px-[30px] py-[5px] rounded" for="dispute_image">Upload Image</label>
                    <input id="dispute_image" class="invisible" type="file">
                </div>
                <div class="bg-green-300 w-full h-[200px] mb-[10px]">

                </div>
                <div class="flex flex-col mb-[10px]">
                    <label class="mb-[10px]">Provide any relevant information</label>
                    <textarea class="rounded border-gray-300 h-[100px]"></textarea>
                </div>
                <button class="block w-full">Send</button>
            </form>
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
