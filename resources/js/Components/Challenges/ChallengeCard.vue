<script setup>
const props = defineProps({ challenge: Object })

const initials = props.challenge.user.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase()
</script>

<template>
    <Link as="div" :href="route('chess.challenges',[1])" class="bg-white rounded shadow p-4 space-y-2">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 rounded-full bg-gray-600 text-white flex items-center justify-center font-bold">
                {{ initials }}
            </div>
            <div>
                <p class="font-semibold text-gray-500">{{ challenge.user.name }}</p>
                <p class="text-sm text-gray-500">{{ challenge.game }}</p>
            </div>
        </div>
        <div class="flex justify-between items-center text-sm">
            <span class="text-gray-500">Amount:</span>
            <span class="font-semibold text-green-600">KES {{ challenge.amount }}</span>
        </div>
        <div class="text-xs text-right text-gray-400">
            {{ challenge.created_at }}
        </div>
    </Link>
</template>
