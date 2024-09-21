<!--suppress JSVoidFunctionReturnValueUsed -->
<script setup>

import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import UsuportedDevice from "@/Components/App/UsuportedDevice.vue";
import Pagination from "@/Components/App/Pagination.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {onMounted, onUpdated, useAttrs} from "vue";
import InputError from "@/Components/InputError.vue";

const props = defineProps(['account'])
const attrs = useAttrs()

const userForm = useForm({
    username: props.account.username,
    codm_username: props.account.codm_username,
    email: props.account.email,
    phone_number: props.account.phone_number,
    role_name: props.account.role_name,
})

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})


function updateAccount() {
    userForm.post(route('accounts.update_account', [props.account.id]))
}

function updatePassword() {
    passwordForm.post(route('accounts.update_password', [props.account.id]))
}

onUpdated(() => {
    if (attrs.success_message != null)
        alert(attrs.success_message)
})
</script>

<template>
    <DashboardLayout>
        <UsuportedDevice/>
        <section class="hidden lg:block">
            <h1 class="font-bold text-[20px] mb-[20px]">Accounts: {{ account.username }}</h1>
            <div class="flex justify-between mb-[10px]">
                <div>
                    <Link as="button" :href="route('accounts.list')">Accounts</Link>
                </div>
                <div class="flex gap-x-2 items-center">
                    <button>Reset</button>
                </div>
            </div>
            <div class="flex gap-x-2 justify-between">
                <section class="w-[70%]">
                    <div class="shadow-lg rounded-lg p-[15px] mb-[20px]">
                        <h2 class="text-[18px] mb-[5px]">Account Details</h2>
                        <form class="p-[10px]" @submit.prevent="'#'">
                            <div class="flex mb-[10px]">
                                <label class="w-[200px] text-[16px]">Username</label>
                                <input class="w-full rounded-lg border-gray-300" type="text"
                                       v-model="userForm.username">
                            </div>
                            <InputError class="my-2 text-right" :message="userForm.errors.current_password"/>

                            <div class="flex mb-[10px]">
                                <label class="w-[200px] text-[16px]">COD Username</label>
                                <input class="w-full rounded-lg border-gray-300" type="text"
                                       v-model="userForm.codm_username">
                            </div>
                            <InputError class="my-2 text-right" :message="userForm.errors.current_password"/>
                            <div class="flex mb-[10px]">
                                <label class="w-[200px] text-[16px]">Email</label>
                                <input class="w-full rounded-lg border-gray-300" type="email" v-model="userForm.email">
                            </div>
                            <InputError class="my-2 text-right" :message="userForm.errors.current_password"/>
                            <div class="flex mb-[10px]">
                                <label class="w-[200px] text-[16px]">Phone Number</label>
                                <input class="w-full rounded-lg border-gray-300" type="text"
                                       v-model="userForm.phone_number">
                            </div>
                            <InputError class="my-2 text-right" :message="userForm.errors.current_password"/>
                            <div class="flex mb-[10px]">
                                <label class="w-[200px] text-[16px]">Role</label>
                                <select class="w-full rounded-lg border-gray-300" v-model="userForm.role_name">
                                    <option value="Guest">Guest</option>
                                    <option value="Player">Player</option>
                                    <option value="Moderator">Moderator</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Super Admin">Super Admin</option>
                                </select>
                            </div>
                            <InputError class="my-2 text-right" :message="userForm.errors.current_password"/>
                            <div class="flex justify-end py-[5px]">
                                <button @click.prevent="updateAccount">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="shadow-lg rounded-lg p-[15px] mb-[20px]">
                        <h2 class="text-[18px] mb-[5px]">Security</h2>
                        <form class="p-[10px]" @submit.prevent="updatePassword">
                            <div class="flex mb-[10px]">
                                <label class="w-[200px] text-[16px]">Current Password</label>
                                <input class="w-full rounded-lg border-gray-300" type="password"
                                       v-model="passwordForm.current_password">
                            </div>
                            <InputError class="my-2 text-right" :message="passwordForm.errors.current_password"/>
                            <div class="flex mb-[10px]">
                                <label class="w-[200px] text-[16px]">New Password</label>
                                <input class="w-full rounded-lg border-gray-300" type="password"
                                       v-model="passwordForm.password">
                            </div>
                            <InputError class="my-2 text-right" :message="passwordForm.errors.password"/>
                            <div class="flex mb-[10px]">
                                <label class="w-[200px] text-[16px]">Confirm Password</label>
                                <input class="w-full rounded-lg border-gray-300" type="password"
                                       v-model="passwordForm.password_confirmation">
                            </div>
                            <InputError class="my-2 text-right" :message="passwordForm.errors.password_confirmation"/>
                            <div class="flex justify-end py-[5px]">
                                <button>Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="shadow-lg rounded-lg p-[15px] mb-[20px]">
                        <h2 class="text-[18px] mb-[5px]">Security</h2>
                        <div class="h-[40px] flex justify-end">
                            <input class="text rounded-lg border-gray-300 h-[35px]" placeholder="Search by ID...">
                        </div>
                        <div class="p-[10px]">
                            <table class="border w-full mb-[20px]">
                                <thead class="bg-black text-white">
                                <tr>
                                    <th class="p-[5px]">ID</th>
                                    <th class="py-[5px]">Mode</th>
                                    <th class="py-[5px]">Stake</th>
                                    <th class="py-[5px]">Players</th>
                                    <th class="py-[5px]">Date</th>
                                    <th class="py-[5px]">Time</th>
                                    <th class="py-[5px]">Status</th>
                                    <th class="py-[5px]">Score</th>
                                </tr>
                                </thead>
                                <tbody>
                                <Link as="tr" :href="route('accounts.view_user',[1])" v-for="item in 10"
                                      class="hover:!bg-black hover:!text-white cursor-pointer"
                                >
                                    <td class="p-[5px] px-[10px]">1</td>
                                    <td class="py-[5px]">Battle Royal</td>
                                    <td class="py-[5px]">50</td>
                                    <td class="py-[5px]">100</td>
                                    <td class="py-[5px]">00/00/00</td>
                                    <td class="py-[5px]">00:00</td>
                                    <td class="py-[5px]">Active</td>
                                    <td class="p-[5px] px-[10px]">10</td>
                                </Link>
                                </tbody>
                            </table>
                            <pagination></pagination>
                        </div>
                    </div>
                </section>
                <section class="w-[28%]">
                    <div class="shadow-lg rounded-lg p-[15px] mb-[20px]">
                        <h2 class="text-[18px] mb-[5px]">Account Details</h2>
                        <ul class="text-[14px]">
                            <li class="flex mb-[8px] justify-between">
                                <p>Date Joined</p>
                                <p>00/00/0000</p>
                            </li>
                            <li class="flex mb-[8px] justify-between">
                                <p>Last Update</p>
                                <p>00/00/0000</p>
                            </li>
                            <li class="flex mb-[8px] justify-between">
                                <p>Account Type</p>
                                <p>Admin</p>
                            </li>
                        </ul>
                    </div>
                    <div class="shadow-lg rounded-lg  p-[15px] mb-[20px]">
                        <div class="mb-[10px]">
                            <h2 class="text-[18px] mb-[5px]">Match Stats</h2>
                            <ul class="px-[15px]">
                                <li class="flex mb-[8px] justify-between">
                                    <p>ID</p>
                                    <p>1</p>
                                </li>
                                <li class="flex mb-[8px] justify-between">
                                    <p>Mode</p>
                                    <p>Battle Royal</p>
                                </li>
                                <li class="flex mb-[8px] justify-between">
                                    <p>Stake</p>
                                    <p>50</p>
                                </li>
                                <li class="flex mb-[8px] justify-between">
                                    <p>Players</p>
                                    <p>100</p>
                                </li>
                                <li class="flex mb-[8px] justify-between">
                                    <p>Date</p>
                                    <p>00/00/00</p>
                                </li>
                            </ul>
                            <hr>
                        </div>
                        <div class="mb-[10px]">
                            <h2 class="text-[18px] mb-[5px]">Daily Stats</h2>
                            <ul class="px-[15px]">
                                <li class="flex mb-[8px] justify-between">
                                    <p>ID</p>
                                    <p>1</p>
                                </li>
                                <li class="flex mb-[8px] justify-between">
                                    <p>Mode</p>
                                    <p>Battle Royal</p>
                                </li>
                                <li class="flex mb-[8px] justify-between">
                                    <p>Stake</p>
                                    <p>50</p>
                                </li>
                                <li class="flex mb-[8px] justify-between">
                                    <p>Players</p>
                                    <p>100</p>
                                </li>
                                <li class="flex mb-[8px] justify-between">
                                    <p>Date</p>
                                    <p>00/00/00</p>
                                </li>
                            </ul>
                            <hr>
                        </div>
                        <div class="mb-[10px]">
                            <h2 class="text-[18px] mb-[5px]">Weekly Stats</h2>
                            <ul class="px-[15px]">
                                <li class="flex mb-[8px] justify-between">
                                    <p>ID</p>
                                    <p>1</p>
                                </li>
                                <li class="flex mb-[8px] justify-between">
                                    <p>Mode</p>
                                    <p>Battle Royal</p>
                                </li>
                                <li class="flex mb-[8px] justify-between">
                                    <p>Stake</p>
                                    <p>50</p>
                                </li>
                                <li class="flex mb-[8px] justify-between">
                                    <p>Players</p>
                                    <p>100</p>
                                </li>
                                <li class="flex mb-[8px] justify-between">
                                    <p>Date</p>
                                    <p>00/00/00</p>
                                </li>
                            </ul>
                            <hr>
                        </div>
                    </div>
                </section>
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
