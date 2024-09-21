<script setup>

import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import UsuportedDevice from "@/Components/App/UsuportedDevice.vue";
import Pagination from "@/Components/App/Pagination.vue";

const props = defineProps(['accounts'])

</script>

<template>
    <DashboardLayout>
        <UsuportedDevice/>
        <section class="hidden lg:block">
            <h1 class="font-bold text-[20px] mb-[20px]">Accounts</h1>
            <div class="flex justify-between mb-[10px]">
                <div>
                    <button>Create</button>
                </div>
                <div class="flex gap-x-2 items-center">
                    <form>
                        <input type="search" class="rounded border-gray-300 mx-[10px]">
                        <button @click.prevent>Search</button>
                    </form>
                    <div>
                        <button>Filter</button>
                    </div>
                </div>
            </div>
            <div class="gap-x-2 mb-[10px] hidden">
                <button v-for="item in 5" class="!rounded-[20px] !px-[8px]">Tag1 <span class="mx-[5px]">X</span></button>
            </div>
            <div>
                <div class="flex justify-between mb-[10px]">
                    <p>20 of 200</p>
                    <p>Page 1 of 20</p>
                </div>
                <div class="mb-[20px]">
                    <table class="border w-full">
                        <thead class="bg-black text-white">
                        <tr>
                            <th class="p-[5px]">ID</th>
                            <th class="py-[5px]">Username</th>
                            <th class="py-[5px]">CODM Username</th>
                            <th class="py-[5px]">Role</th>
                        </tr>
                        </thead>
                        <tbody>
                        <Link class="hover:!bg-black hover:!text-white cursor-pointer" as="tr" :href="route('accounts.view_user',[user.id])" v-for="user in accounts">
                            <td class="p-[5px] px-[10px]">{{user.id}}</td>
                            <td class="py-[5px]">{{user.username}}</td>
                            <td class="py-[5px]">{{user.codm_username}}</td>
                            <td class="py-[5px]">{{user.role_name}}</td>
                        </Link>
                        </tbody>
                    </table>
                </div>
                <pagination></pagination>
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
