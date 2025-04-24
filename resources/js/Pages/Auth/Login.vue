<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import DefaultLayout from "@/Layouts/DefaultLayout.vue";
import InputError from "@/Components/InputError.vue";

const form = useForm({
  email: '',
  password: '',
});
const submit = () => {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};


</script>

<template>
    <DefaultLayout>
        <section class=" flex flex-col items-center justify-center mt-10">
            <Head title="Sign Up"/>
            <img style="width: 200px" class="object-contain mx-auto mb-4" src="/storage/system/Asset%202.png"
                 alt="Nexus Logo"/>
            <div id="input-panel" class="py-4 w-[90%] md:w-[400px] mx-auto flex-col items-center rounded p-3 bg-white">

                <h1 class="text-black text-center font-bold h3 p-3">Sign In</h1>
                <form class="md:p-3" @submit.prevent="submit">
                    <div class="shadow-lg rounded-lg p-[10px] mb-[20px]">
                        <label class="block text-[15px]">Email</label>
                        <input class="" type="email" required v-model="form.email">
                        <InputError class="mt-2" :message="form.errors.email"/>
                    </div>
                    <div class="shadow-lg rounded-lg p-[10px] mb-[20px]">
                        <label class="block text-[15px]">Password</label>
                        <input class="" type="password" required v-model="form.password">
                        <InputError class="mt-2" :message="form.errors.password"/>
                    </div>
                    <section>
                        <button type="submit" class="bg-black text-white w-full p-[10px] rounded">Sign In</button>
                        <p class="text-center text-gray-600 mt-[20px] text-[15px]">Forgot Password?
                            <Link class="text-blue-700 underline" href="/password-reset">Reset your password</Link>
                        </p>
                        <p class="text-center text-gray-600 mt-[20px] text-[15px]">Dont have an account?
                            <Link class="text-blue-700 underline" href="/register">Register</Link>
                        </p>
                    </section>
                    <div class="w-[200px] h-[100px] mx-auto mt-[50px] flex justify-center items-center flex-col">
                        <img alt="image" class="w-[200px] h-[50px] mb-[5px] object-contain mx-auto" src="/storage/system/WhatsApp_icon.png.webp">
                        <a href="https://chat.whatsapp.com/DCZtOj3G4AYJtgCwc0h9wQ" class="bg-green-500 text-black px-[20px] py-[10px] rounded ">Join Group</a>
                    </div>
                </form>
            </div>
        </section>
    </DefaultLayout>
</template>

<style lang="scss">
#input-panel {
    background-color: #fff;

    &>form>div{
        @apply mb-4 ;
    }

    label{
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
