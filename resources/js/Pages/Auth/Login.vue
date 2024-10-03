<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import InputError from "@/Components/DefaultComponents/InputError.vue";

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
  <Head title="Welcome"/>
  <div class="pt-[20px]">
    <img class="w-[200px] h-[50px] pb-[10px] object-contain mx-auto" src="/storage/system/Asset%202.png"
         alt="image">
  </div>
  <div class="h-[100vh] md:pt-[30px]">
    <div
        class="h-full w-fulls flex bg-white flex-col items-center pt-[20px] md:!rounded-[6px] md:w-[500px] md:h-fit pb-[30px] md:mx-[auto]"
        id="input-panel">
      <h1 class="text-black text-[20px] font-bold">SIGN IN</h1>
      <form class="px-[30px] w-full" @submit.prevent="submit">
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
      </form>
    </div>
  </div>
</template>

<style lang="scss" scoped>
@import "../../../scss/body";

#input-panel {
  border-top-left-radius: 70px;

  div {
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


    &:focus-within {
      transform: scale(1.05);
    }
  }
}

button {
  &:active {
    background-color: white;
    color: grey;
  }
}
</style>
