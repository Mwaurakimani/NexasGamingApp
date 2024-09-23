<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import MatchCard from "@/Components/App/MatchCard.vue";
import InputError from "@/Components/InputError.vue";
</script>

<template>
    <DashboardLayout>
        <div class="w-full px-[10px] pb-[30px] mx-auto md:max-w-[750px] rounded">
            <h1 class="font-bold text-[20px] mb-[5px]">Profile Details</h1>
            <form class="mb-[40px]">
                <section class=" border-gray-200  overflow-hidden rounded p-[10px]">
                    <div class="flex flex-col mb-[5px]">
                        <label class="text-[15px] mb-[5px] text-gray-600">Username</label>
                        <input type="text" class="rounded-md border-1 border-gray-300">
                    </div>
                    <div class="flex mb-[5px] flex-col">
                        <label class="text-[15px] mb-[5px] text-gray-600">Email</label>
                        <input type="text" class="rounded-md border-1 border-gray-300">
                    </div>
                    <div class="flex mb-[5px] flex-col">
                        <label class="text-[15px] mb-[5px] text-gray-600">Phone Number</label>
                        <input type="text" class="rounded-md border-1 border-gray-300">
                    </div>
                    <div class="flex flex-col mb-[20px]">
                        <label class="text-[15px] mb-[5px] text-gray-600">Call of Duty Username</label>
                        <input type="text" class="rounded-md border-1 border-gray-300">
                    </div>
                    <div>
                        <button class="bg-gray-300 block w-full px-[30px] py-[5px] rounded">Save Changes</button>
                    </div>
                </section>
            </form>
            <h1 class="font-bold text-[20px] mb-[5px]">Security Details</h1>
            <form>
                <section class=" border-gray-200  overflow-hidden rounded p-[10px]">
                    <div class="flex mb-[5px] flex-col">
                        <label class="text-[15px] mb-[5px] text-gray-600">Current Password</label>
                        <input type="text" class="rounded-md border-1 border-gray-300">
                    </div>
                    <div class="flex mb-[5px] flex-col">
                        <label class="text-[15px] mb-[5px] text-gray-600">New Password</label>
                        <input type="text" class="rounded-md border-1 border-gray-300">
                    </div>
                    <div class="flex flex-col mb-[20px]">
                        <label class="text-[15px] mb-[5px] text-gray-600">Confirm New Password</label>
                        <input type="text" class="rounded-md border-1 border-gray-300">
                    </div>
                    <div>
                        <button class="bg-gray-300 block w-full px-[30px] py-[5px] rounded">Save Password</button>
                    </div>
                </section>
            </form>
        </div>
    </DashboardLayout>
</template>

<style scoped lang="scss">
button:active {
    transition: all ease-in-out 0.3ms;
    @apply bg-gray-700 text-white;
}
</style>
