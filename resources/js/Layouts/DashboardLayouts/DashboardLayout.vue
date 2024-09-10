<script setup>
import {reactive} from "vue";
import {navigation_button, openMenu, closeMenu} from "@/Layouts/DashboardLayouts/GuestHelper.js";

const props = defineProps({
    header_item: {
        type: String,
        required: false,
        default: "Welcome"
    },
})
const navigation = reactive(navigation_button)

</script>

<template>
    <div class="w-full h-[100vh] flex">
        <section id="navigation-menu"
                 class="w-[0px] fixed top-0 overflow-hidden lg:hidden h-full bg-black text-white" style="top: 100px;z-index: 1100">
            <div class="flex justify-end items-end" @click="closeMenu">
                <img width="30" height="30" src="https://img.icons8.com/material-outlined/48/ffffff/delete-sign.png"
                     alt="delete-sign"/>
            </div>
            <ul class="flex flex-col items-center justify-center h-full bg-">
                <li class="my-[20px]" v-for="button in navigation">
                    <Link :href="button.link[0]"
                          class="block text-[20px] px-[10px] flex items-center justify-center">
                        <span v-if="button.link.includes(route().current())"
                              class="w-[14px] h-[14px] bg-gray-100 block mx-[5px] rounded-[50%]"></span>
                        {{ button.name }}
                    </Link>
                </li>
            </ul>
        </section>
        <section class="w-[250px] hidden lg:block h-full bg-black text-white">
            <div id="image_display" class="p-[20px] mt-[200px]">
                <img class="h-[50px]" src="/storage/system/Asset%202.png">
            </div>
            <ul class="">
                <li class="my-[20px] pl-[10px]" v-for="button in navigation">
                    <Link :href="button.link[0]" class="block text-[20px] py-[5px] px-[10px]"
                          style="border-radius: 5px 0px 0px 5px;"
                          :class="[button.link.includes(route().current()) ?'bg-gray-500':'']"
                    >
                        {{ button.name }}
                    </Link>
                </li>
            </ul>
        </section>
        <section class="lg:w-[calc(100%-250px)] overflow-auto  w-[100%] bg-black">
            <div class="h-[60px] bg-black flex items-center justify-between px-[20px] sticky top-0 lg:hidden"
                 style="z-index: 1000">
                <div @click="openMenu">
                    <img width="30" height="30" src="https://img.icons8.com/stamp/64/ffffff/menu.png" alt="menu"/>
                </div>
                <div id="image_display">
                    <img class="h-[40px]" src="/storage/system/Asset%202.png">
                </div>
                <Link :href="route('logout')" method="post" class="block" as="button" id="logout_display">
                    <img width="30" height="30" src="https://img.icons8.com/forma-regular/24/ffffff/exit.png"
                         alt="exit"/>
                </Link>
            </div>
            <div class="w-full h-[50px] px-[15px] hidden lg:flex justify-between items-center">
                <h1 class="text-white text-[20px]">{{ header_item }}</h1>
                <Link :href="route('logout')" method="post" class="block" as="button" id="logout_display">
                    <img width="30" height="30" src="https://img.icons8.com/forma-regular/24/ffffff/exit.png"
                         alt="exit"/>
                </Link>
            </div>
            <div id="display_body" class="w-full lg:h-[calc(100vh-50px)] h-full bg-white overflow-auto lg:!bg-gray-500 p-[15px]" >
                <slot name="default"></slot>
            </div>
        </section>
    </div>
</template>

<style lang="scss">
#navigation-menu {
    transition: width 0.3s ease-in-out;
}

//media query for pas 1024px
@media (min-width: 1024px) {
    #display_body {
        border-radius: 15px 0 0 0;
    }
}
</style>

