<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import DefaultLayout from "@/Layouts/DefaultLayout.vue";

const form = useForm({
    username: '',
    email: '',
    phone_number: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <DefaultLayout>
        <section class=" flex flex-col items-center justify-center mt-10">
            <Head title="Sign Up"/>
            <img style="width: 200px" class="object-contain mx-auto mb-4" src="/storage/system/Asset%202.png"
                 alt="Nexus Logo"/>
            <div id="input-panel" class="py-4 w-[90%] md:w-[500px] mx-auto flex-col items-center rounded p-3 bg-white">
                <h1 class="text-black text-center font-bold h3 p-3">Create Account</h1>
                <form @submit.prevent="submit" class="md:p-3">
                    <div class="shadow-lg rounded-lg p-[10px] mb-[20px]">
                        <label class="block text-sm font-medium">Username</label>
                        <input type="text" v-model="form.username" required/>
                        <InputError :message="form.errors.username"/>
                    </div>

                    <div class="shadow-lg rounded-lg p-[10px] mb-[20px]">
                        <label class="block text-sm font-medium">Email</label>
                        <input type="email" v-model="form.email" required/>
                        <InputError :message="form.errors.email"/>
                    </div>

                    <div class="shadow-lg rounded-lg p-[10px] mb-[20px]">
                        <label class="block text-sm font-medium">Phone Number</label>
                        <input type="tel" placeholder="+254700000000" v-model="form.phone_number" required/>
                        <InputError :message="form.errors.phone_number"/>
                    </div>

                    <div class="shadow-lg rounded-lg p-[10px] mb-[20px]">
                        <label class="block text-sm font-medium">Password</label>
                        <input type="password" v-model="form.password" required/>
                        <InputError :message="form.errors.password"/>
                    </div>

                    <div class="shadow-lg rounded-lg p-[10px] mb-[20px]">
                        <label class="block text-sm font-medium">Confirm Password</label>
                        <input type="password" v-model="form.password_confirmation" required/>
                        <InputError :message="form.errors.password_confirmation"/>
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-black text-white py-2 px-4 rounded hover:opacity-90 transition"
                    >
                        Sign Up
                    </button>

                    <p class="text-center text-sm text-gray-600 mt-4">
                        Already have an account?
                        <Link href="/login" class="text-blue-700 underline">Login</Link>
                    </p>
                </form>
            </div>
        </section>
    </DefaultLayout>
</template>

<style lang="scss">
#input-panel {
    background-color: #fff;

    & > form > div {
        @apply mb-4 ;
    }

    label {
        @apply text-black;
    }

    input {
        border: none;
        outline: none;
        border-bottom: 1px solid #ccc;
        color: black;
        width: 100%;
        padding: 0.5rem 0;
        transition: border-color 0.2s ease-in-out;
        @apply focus:outline-none focus:ring-0 focus:border-black ;
    }

    div:focus-within {
        transform: scale(1.02);
        transition: transform 0.2s ease-in-out;
        @apply shadow-lg;
    }
}
</style>
