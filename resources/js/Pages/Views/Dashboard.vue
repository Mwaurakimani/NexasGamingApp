<script setup>
import {reactive} from "vue";

const props = defineProps()

const navigation = reactive([
    {
        name: "Dashboard",
        link: "dashboard"
    },
    {
        name: "Matches",
        link: "dashboard"
    },
    {
        name: "Accounts",
        link: "dashboard"
    },
    {
        name: "Transactions",
        link: "dashboard"
    },
])

const openMenu = () => {
    let menu = $('#navigation-menu')
    menu.css({'width': '100%'})
}
const closeMenu = () => {
    let menu = $('#navigation-menu')
    menu.css({'width': '0%'})
}

</script>

<template>
    <div class="w-full h-[100vh] flex">
        <section id="navigation-menu"
                 class="w-[0px] absolute top-0 overflow-hidden lg:hidden h-full bg-black text-white">
            <div class=" flex justify-end px-[10px]" @click="closeMenu">
                <img width="30" height="30" src="https://img.icons8.com/material-outlined/48/ffffff/delete-sign.png"
                     alt="delete-sign"/>
            </div>
            <ul class="flex flex-col items-center justify-center h-full bg-">
                <li class="my-[20px]" v-for="button in navigation">
                    <Link :href="route(button.link)"
                          class="block text-[20px] px-[10px] flex items-center justify-center">
                        <span v-if="route().current() == button.link"
                              class="w-[14px] h-[14px] bg-gray-100 block mx-[5px] rounded-[50%]"></span>
                        {{ button.name }}
                    </Link>
                </li>
            </ul>
        </section>
        <section class="w-[250px] overflow-hidden hidden lg:block h-full bg-black text-white">
            <div id="image_display" class=" p-[20px]">
                <img class="h-[50px]" src="/storage/system/Asset%202.png">
            </div>
            <ul class="">
                <li class="my-[20px]" v-for="button in navigation">
                    <Link :href="route(button.link)" class="block text-[20px] mx-[10px] py-[5px] px-[10px] rounded"
                          :class="[route().current() === button.link ?'bg-gray-500':'']"
                    >
                        {{ button.name }}
                    </Link>
                </li>
            </ul>
        </section>
        <section class="w-[calc(100%-250px)]">
            <div class="h-[100px] bg-black flex items-center justify-between px-[20px] lg:hidden">
                <div @click="openMenu">
                    <img width="30" height="30" src="https://img.icons8.com/stamp/64/ffffff/menu.png" alt="menu"/>
                </div>
                <div id="image_display">
                    <img class="h-[50px]" src="/storage/system/Asset%202.png">
                </div>
                <Link :href="route('logout')" method="post" class="block" as="button" id="logout_display">
                    <img width="30" height="30" src="https://img.icons8.com/forma-regular/24/ffffff/exit.png"
                         alt="exit"/>
                </Link>
            </div>
        </section>
    </div>
</template>

<style lang="scss">
#navigation-menu {
    transition: width 0.3s ease-in-out;
}
</style>

