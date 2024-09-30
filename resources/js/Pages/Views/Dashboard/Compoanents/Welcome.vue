<script setup>
import {usePage} from "@inertiajs/vue3";

const page = usePage()
</script>
<template>
  <div class="w-[100%] text-gray-600 mx-auto mb-[20px]">
    <p>Hello</p>
    <h1 class="font-bold text-[20px]">{{ page.props.auth.user.username }}</h1>
  </div>
</template>