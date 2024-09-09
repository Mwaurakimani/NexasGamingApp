<script setup>

</script>

<template>
    <teleport to="body">
        <div class="bg-red-400 h-full w-full absolute" style="z-index: 10000;top: 0px; left: 0px; background-color: rgba(0,0,0,0.8)">
            <div class="p-[20px]" style="position: absolute; top: 0px; right: 0px" @click.prevent.stop="close_modal">
                <img width="24" height="24" src="https://img.icons8.com/material-outlined/48/ffffff/delete-sign.png" alt="delete-sign"/>
            </div>
            <div class="h-[calc(100%-60px)] relative top-[60px] flex">
                <slot></slot>
            </div>
        </div>
    </teleport>
</template>

<style scoped lang="scss">

</style>
