<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import UsuportedDevice from "@/Components/App/UsuportedDevice.vue";
import Pagination from "@/Components/App/Pagination.vue";
import {reactive, ref} from "vue";

const search_term = ref("")
const payload = reactive([])
</script>

<template>
    <DashboardLayout>
        <UsuportedDevice/>
        <section class="hidden lg:block">
            <h1 class="font-bold text-[20px] mb-[20px]">Matches</h1>
            <div class="flex justify-between mb-[10px]">
                <div>
                </div>
                <div class="flex gap-x-2 items-center">
                    <input v-model="search_term" type="search" class="rounded border-gray-300 mx-[10px]"
                           placeholder="Search...">Create Matches
                </div>
            </div>
            <div class="gap-x-2 mb-[10px] hidden">
                <button v-for="item in 5" class="!rounded-[20px] !px-[8px]">Tag1 <span class="mx-[5px]">X</span>
                </button>
            </div>
            <div v-if="payload.data?.length > 0">
                <div class="flex justify-between mb-[10px]">
                    <p>{{ payload.data.length }} of {{ payload.total }}</p>
                    <p>Page {{ payload.current_page }} of {{ payload.total }}</p>
                </div>
                <div class="mb-[20px]">
                    <table class="border w-full">
                        <thead class="bg-black text-white">
                        <tr>
                            <th class="p-[5px]">ID</th>
                            <th class="py-[5px]">Username</th>
                            <th class="py-[5px]">Email</th>
                            <th class="py-[5px]">Balance</th>
                            <th class="py-[5px]">CODM Username</th>
                            <th class="py-[5px]">Role</th>
                        </tr>
                        </thead>
                        <tbody>
                        <Link class="hover:!bg-black hover:!text-white cursor-pointer" as="tr"
                              :href="route('accounts.view_user',[user.id])" v-for="user in payload.data">
                            <td class="p-[5px] px-[10px]">{{ user.id }}</td>
                            <td class="py-[5px]">{{ user.username }}</td>
                            <td class="py-[5px]">{{ user.email }}</td>
                            <td class="py-[5px]">{{ user.balance }}</td>
                            <td class="py-[5px]">{{ user.codm_username }}</td>
                            <td class="py-[5px]">{{ user.role_name }}</td>
                        </Link>
                        </tbody>
                    </table>
                </div>
                <pagination :payload="payload"></pagination>
            </div>
            <div v-else class="text-[30px] text-center py-[20px]">
                <p>No Records Found ...</p>
            </div>
        </section>
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

table {
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
