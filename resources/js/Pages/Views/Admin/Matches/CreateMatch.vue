<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import UsuportedDevice from "@/Components/App/UsuportedDevice.vue";
import MatchDetailsForm from "@/Pages/Views/Admin/Matches/Components/MatchDetailsForm.vue";
import {useForm} from "@inertiajs/vue3";


const matchForm = useForm({
    mode: "BRD",
    date: "2024-09-22",
    teams: 1,
    status: "Active",
    time: "15:44",
    stake: 50,
})

const save_match = async () => {
    try {
        await matchForm.post(route('matches.post_match_action'), {
            preserveState: true,
        });
        alert('Match created successfully');
    } catch (error) {
        console.log(error);
    }
}

</script>

<template>
    <DashboardLayout>
        <UsuportedDevice/>
        <h1 class="font-bold text-[20px] mb-[20px]">Create Matches</h1>
        <section class="content-area">
            <section>
                <div>
                    <h1>Match Details</h1>
                    <MatchDetailsForm :matchForm @save_match="save_match"></MatchDetailsForm>
                </div>
            </section>
            <section>
            </section>
        </section>

    </DashboardLayout>
</template>

<style scoped lang="scss">
button {
    @apply bg-gray-300 px-[30px] py-[5px] rounded;

    &:hover {
        @apply bg-gray-400 text-white;
    }

    &:active {
        transition: all ease-in-out 0.3ms;
        @apply bg-gray-700 text-white;
    }
}

.content-area{
    width: 100%;
    height: calc(100% - 45px);
    @apply overflow-auto flex gap-1;

    & > section:nth-of-type(1) {
        width: 65%;
    }
    & > section:nth-of-type(2) {
        width: 35%;
    }

    & > section {
        & > div{
            width: 100%;
            @apply rounded border border-gray-100 shadow-lg p-2 mb-[20px];

            h1 {
                @apply font-bold text-[20px] text-gray-700 mb-[10px];
            }

        }
    }
}
</style>
