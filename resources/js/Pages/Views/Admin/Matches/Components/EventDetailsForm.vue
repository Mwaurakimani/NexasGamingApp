<script setup>


import InputError from "@/Components/InputError.vue";

const props = defineProps(['EventForm'])

</script>

<template>
    <form class="px-[10px] ">
        <div class="p-[10px] mb-[5px]">
            <label class="block text-[15px]">Link</label>
            <input v-model="EventForm.link" class="rounded" type="text" required>
            <InputError class="mt-2" :message="EventForm.errors.link"/>
        </div>
        <div class="p-[10px] mb-[5px]">
            <label class="block text-[15px]">Password</label>
            <input v-model="EventForm.password" class="rounded" type="text" required>
            <InputError class="mt-2" :message="EventForm.errors.password"/>
        </div>
        <div class="p-[10px] mb-[5px]">
            <label class="block text-[15px]">Pace</label>
            <select v-model="EventForm.pace" class="rounded" required>
                <option value="Normal">Normal</option>
                <option value="Fast">Fast</option>
                <option value="Fast">Fast</option>
            </select>
            <InputError class="mt-2" :message="EventForm.errors.pace"/>
        </div>

        <div class="p-[10px] mb-[5px]">
            <label class="block text-[15px]">Notes</label>
            <textarea v-model="EventForm.notes" class="h-[200px] rounded"></textarea>
            <InputError class="mt-2" :message="EventForm.errors.notes"/>
        </div>
    </form>
</template>

<style scoped lang="scss">
input, textarea, select {
    display: block !important;
    width: 100%;
    border: 1px solid lightgray;
    outline: none;
}
</style>
