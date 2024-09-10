<script setup>



const props = defineProps([
    'results',
    'fixture'
])
</script>

<template>
    <div class="border rounded-md lg:!border-none bg-white overflow-hidden">
        <div class="h-[190px] bg-black relative overflow-hidden">
            <img src="/storage/system/codm_banner.jpg" alt="banner">
            <div class="game_banner_overlay absolute top-0 w-full h-full flex-col justify-between">
                <section class="flex items-center justify-end p-[10px]">
                    <p class="bg-green-500 text-white w-fit rounded-lg p-[3px]">Active</p>
                </section>
                <section>
                    <div class="p-[10px] flex items-center">
                        <img class="w-[25px]" src="/storage/system/Coin%20Light.png">
                        <p class="text-white text-[15px] px-[5px]">5</p>
                    </div>
                    <div class="text-center p-[10px] text-white">
                        <p>00/00/0000</p>
                        <p>00:00</p>
                    </div>
                    <div class="p-[10px] flex items-center">
                        <img class="w-[25px]" src="/storage/system/icons8-crowd-50.png">
                        <p class="text-white text-[15px] px-[5px]">100</p>
                    </div>
                </section>
            </div>
        </div>
        <div class="p-[10px]">
            <ul v-if="fixture" class="w-full">
                <li class=" mb-[20px]">
                    <p class="text-center font-bold">Ready Players</p>
                    <p class="text-center mb-[5px]">50</p>
                    <hr class="w-[80%] mx-auto ">
                </li>
                <li class="mb-[20px]">
                    <p class="text-center font-bold">Mode</p>
                    <p class="text-center ">Battle Royal</p>
                    <hr class="w-[80%] mx-auto border-gray-800 bg-black">
                </li>
                <li class="grid place-content-center">
                    <Link as="button" :href="route('matches.view_match',[1])" class="bg-gray-300 px-[30px] py-[5px] rounded">Join</Link>
                </li>
            </ul>
            <ul v-else class="w-full">
                <li class=" mb-[20px]">
                    <p class="text-center font-bold">Score</p>
                    <p class="text-center mb-[5px]">50</p>
                    <hr class="w-[80%] mx-auto ">
                </li>
                <li class="mb-[20px]">
                    <p class="text-center font-bold mb-[5px]">Payout</p>
                    <div class="flex justify-center items-center mb-[10px]">
                        <img class="w-[20px]" src="/storage/system/Coin%20Dark.png">
                        <p class="text-center mx-[5px]">50</p>
                    </div>
                    <hr class="w-[80%] mx-auto border-gray-800 bg-black">
                </li>
                <li class="grid place-content-center">
                    <Link as="button" :href="route('matches.view_match',[1])" class="bg-gray-300 px-[30px] py-[5px] rounded">View</Link>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped lang="scss">
button:active {
    transition: all ease-in-out 0.3ms;
    @apply bg-gray-700 text-white;
}
.game_banner_overlay{
    background-image: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 1) 100%);
    display: flex;
    section:nth-of-type(2){
        @apply flex items-end justify-between;
    }
}
</style>
