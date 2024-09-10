<script setup>

</script>

<template>
    <div class="p-[10px] bg-white rounded max-w-[350px]">
        <div class="">
            <h2 class="text-[20px] mb-[10px] font-bold">Withdraw</h2>
            <form class="mb-[20px] px-[20px]">
                <div class="mb-[5px]">
                    <label class="block">Amount</label>
                    <input class="rounded border-gray-300 w-[300px]" type="number">
                </div>
                <div class="mb-[5px]">
                    <label class="block">Your Phone Number</label>
                    <input class="rounded border-gray-300 w-[300px]" type="text">
                </div>
                <div class="mb-[15px]">
                    <label class="block">Password</label>
                    <input class="rounded border-gray-300 w-[300px]" type="password">
                </div>
                <p class="text-[14px] mb-[15px]">Do not press confirm until you receive the funds</p>
                <div class="mb-[15px]">
                    <label class="block">Transaction Code</label>
                    <input class="rounded border-gray-300 w-[300px]" type="number">
                </div>
            </form>
            <div class="flex items-center justify-between mb-[10px]">
                <button class="bg-green-500 px-[14px] py-[5px] rounded text-white">Confirm</button>
                <button class="bg-gray-300 px-[14px] py-[5px] rounded">Cancel</button>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">

</style>
