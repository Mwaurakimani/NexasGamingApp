<script setup>
import {Head, Link, router} from '@inertiajs/vue3';
import {onMounted, onUpdated} from "vue";

let is_authenticated = async () => {
    let {data} = await axios.get(route('userIsAuthenticated'))

    if (data.status)
        window.location.href = route('dashboard')
    else
        window.location.href = route('login')
}

onMounted(() => {
    is_authenticated()
})

onUpdated(() => {
    is_authenticated()
})
</script>

<template>
    <Head title="Welcome"/>

    <div class="text-white flex w-full h-[100vh] items-center justify-center flex-col">
        <h1 class="text-[30px]">Welcome to</h1>
        <div class="pt-[20px]">
            <img class="w-[200px] h-[50px] mb-[10px] object-contain mx-auto" src="/storage/system/Asset%202.png"
                 alt="image">
        </div>
    </div>
</template>

<style lang="scss">
#input-panel {
    background-color: white;
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
</style>
