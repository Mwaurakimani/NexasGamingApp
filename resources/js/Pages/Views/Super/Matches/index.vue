<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import UsuportedDevice from "@/Components/App/UsuportedDevice.vue";
import Pagination from "@/Components/App/Pagination.vue";
import {reactive, ref} from "vue";
import MatchCard from "@/Components/App/MatchCard.vue";

const props = defineProps(['matches'])
const search_term = ref("")
const payload = reactive(props.matches)
</script>

<template>
    <DashboardLayout>
        <UsuportedDevice/>
        <h1 class="font-bold text-[20px] mb-[20px]">Matches</h1>
        <section class="hidden lg:block">
            <div class="flex justify-between mb-[20px]">
                <article class="flex gap-1">
                    <Link as="button" :href="route('matches.create_match')">Create Match</Link>
                    <Link as="button" :href="'/'">Create Template</Link>
                </article>
                <article class="flex gap-x-2 items-center">
                    <input v-model="search_term" type="search" class="rounded border-gray-300 mx-[10px]"
                           placeholder="Search...">
                </article>
            </div>
            <div class="flex mb-[40px] justify-end">
                <div class="w-full p-[20px]">
                    <h2>Match Events</h2>
                    <MatchCard class="w-full" :results="false"></MatchCard>
                </div>
                <div class="w-full p-[20px]">
                    <h2>Match Templates</h2>
                    <ul class="px-[10px] rounded bg-gray-600 m-[10px]" v-for="item in 5">
                        <li class="h-20">
                            <h3 class="text-white p-[10px]">Battle Royal (100-10)</h3>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="  bg-white ">
                <h1 class=" text-[20px] text-center">Matches</h1>
                <div v-if="payload.data?.length > 0" class="p-[20px]">
                    <div class="flex justify-between mb-[10px]">
                        <p>{{ payload.data.length }} of {{ payload.total }}</p>
                        <p>Page {{ payload.current_page }} of {{ payload.total }}</p>
                    </div>
                    <div class="mb-[20px] ">
                        <table class="border w-full table-sm">
                            <thead class="bg-black text-white">
                            <tr>
                                <th class="p-[5px]">ID</th>
                                <th class="py-[5px]">Mode</th>
                                <th class="py-[5px]">Moderator</th>
                                <th class="py-[5px]">Date</th>
                                <th class="py-[5px]">Time</th>
                                <th class="py-[5px]">Stake</th>
                                <th class="py-[5px]">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <Link class="hover:!bg-black hover:!text-white cursor-pointer" as="tr"
                                  :href="route('matches.view_match',[match.id])" v-for="match in payload.data">
                                <td class="py-[5px]">{{ match.id }}</td>
                                <td class="py-[5px]">{{ match.mode }}</td>
                                <td class="py-[5px]">{{ match.moderator.username }}</td>
                                <td class="py-[5px]">{{ match.date }}</td>
                                <td class="py-[5px]">{{ match.time }}</td>
                                <td class="py-[5px]">{{ match.stake }}</td>
                                <td class="py-[5px]">{{ match.status }}</td>
                            </Link>
                            </tbody>
                        </table>
                    </div>
                    <pagination :payload="payload"></pagination>
                </div>
            </div>
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

section {
    & > div {
        & > div {
            @apply rounded shadow-lg;
            h2 {
                @apply text-lg font-bold text-center mb-[20px] ;
            }
        }
    }
}
</style>
