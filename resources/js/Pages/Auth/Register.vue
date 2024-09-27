<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import InputError from "@/Components/InputError.vue";
import {onMounted} from "vue";


const form = useForm({
    username: '',
    email: '',
    phone_number:'',
    codm_username:'',
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
    <Head title="Welcome"/>
    <div class="pt-[20px]">
        <img class="w-[200px] h-[50px] pb-[10px] object-contain mx-auto" src="/storage/system/Asset%202.png" alt="image">
    </div>
    <div class="h-[100vh] md:pt-[30px]">
        <div class="h-full w-full flex flex-col items-center pt-[20px] md:!rounded-[6px] md:w-[500px] md:h-fit pb-[30px] md:mx-[auto]" id="input-panel">
            <h1 class="text-black text-[20px] font-bold">SIGN UP</h1>
            <form class="px-[30px] w-full" @submit.prevent="submit">
                <div class="shadow-lg rounded-lg p-[10px] mb-[20px]">
                    <label class="block text-[15px]">Username</label>
                    <input class="" type="text" required v-model="form.username">
                    <InputError class="mt-2" :message="form.errors.username" />
                </div>
                <div class="shadow-lg rounded-lg p-[10px] mb-[20px]">
                    <label class="block text-[15px]">Email</label>
                    <input class="" type="email" required v-model="form.email">
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <div class="shadow-lg rounded-lg p-[10px] mb-[20px]">
                    <label class="block text-[15px]">Phone Number</label>
                    <input class="" placeholder="+254700000000" required type="tel" v-model="form.phone_number">
                    <InputError class="mt-2" :message="form.errors.phone_number" />
                </div>
                <div class="shadow-lg rounded-lg p-[10px] mb-[20px]">
                    <label class="block text-[15px]">CODM username</label>
                    <input class="" placeholder="Call of Duty Username" required v-model="form.codm_username">
                    <InputError class="mt-2" :message="form.errors.codm_username" />
                </div>
                <div class="shadow-lg rounded-lg p-[10px] mb-[20px]">
                    <label class="block text-[15px]">Password</label>
                    <input class="" type="password" v-model="form.password">
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
                <div class="shadow-lg rounded-lg p-[10px] mb-[20px]">
                    <label class="block text-[15px]">Confirm Password</label>
                    <input class="" type="password" v-model="form.password_confirmation">
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
                <section>
                    <button type="submit" class="bg-black text-white w-full p-[10px] rounded">Sign Up</button>
                    <p class="text-center text-gray-600 mt-[20px] text-[15px]">Already have an account? <Link class="text-blue-700 underline" href="/login">Login</Link></p>
                </section>
            </form>
        </div>
    </div>
</template>

<style lang="scss" scoped>
@import "../../../scss/body";


#input-panel {
    background-color: white;
    border-top-left-radius: 70px;

    div{
        transition: all ease-in-out 200ms;

        input {
            border: none;
            border-bottom: 1px solid grey;
            outline: none !important;
            width: 100%;
            transition: all ease-in-out 200ms;
            --tw-ring-shadow: 0 0 #000 !important;
            box-sizing: border-box;

            &:focus {
                border-bottom: 1px solid black;
            }

        }

        &:focus-within{
            transform:scale(1.05);
        }
    }
}
</style>
