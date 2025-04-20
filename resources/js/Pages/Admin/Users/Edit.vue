<script setup>
import DashboardLayout from '@/Layouts/DashboardLayout.vue'
import InputError from '@/Components/InputError.vue'
import {useForm} from '@inertiajs/vue3'
import {provide} from 'vue'

const props = defineProps({
    user: Object,
})

provide('pageTitle', 'Edit User')

const form = useForm({
    username: props.user.username,
    email: props.user.email,
    phone_number: props.user.phone_number,
    role: props.user.role,
    Active: props.user.Active,
})

const updateUser = () => {
    form.put(route('admin.users.update', props.user.id), {
        preserveScroll: true,
    })
}
</script>

<template>
    <DashboardLayout>
        <div class="max-w-3xl mx-auto p-6 text-black space-y-6">
            <h1 class="text-xl font-bold">Edit User: {{ form.username }}</h1>

            <form @submit.prevent="updateUser" class="space-y-4 bg-white p-6 rounded shadow">
                <div>
                    <label class="block font-medium">Username</label>
                    <input v-model="form.username" type="text" class="w-full border px-3 py-2 rounded" />
                    <InputError :message="form.errors.username" />
                </div>

                <div>
                    <label class="block font-medium">Email</label>
                    <input v-model="form.email" type="email" class="w-full border px-3 py-2 rounded" />
                    <InputError :message="form.errors.email" />
                </div>

                <div>
                    <label class="block font-medium">Phone Number</label>
                    <input v-model="form.phone_number" type="tel" class="w-full border px-3 py-2 rounded" />
                    <InputError :message="form.errors.phone_number" />
                </div>

                <div>
                    <label class="block font-medium">Role</label>
                    <select v-model="form.role" class="w-full border px-3 py-2 rounded">
                        <option value="Guest">Guest</option>
                        <option value="Player">Player</option>
                        <option value="Moderator">Moderator</option>
                        <option value="Manager">Manager</option>
                        <option value="Admin">Admin</option>
                        <option value="Super Admin">Super Admin</option>
                    </select>
                    <InputError :message="form.errors.role" />
                </div>

                <div>
                    <label class="block font-medium">Status</label>
                    <select v-model="form.Active" class="border px-3 py-2 rounded w-full">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                        <option value="2">Suspended</option>
                    </select>
                    <InputError :message="form.errors.active" />
                </div>




                <div>
                    <button type="submit" class="bg-black text-white px-4 py-2 rounded hover:opacity-90">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </DashboardLayout>
</template>
