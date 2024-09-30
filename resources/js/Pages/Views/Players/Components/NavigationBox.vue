<script setup>

const props = defineProps(['active'])
</script>

<template>
  <div>
    <ul class="flex gap-[10px] mb-[40px]">
      <li>
        <Link :class="[active === 'Transfers'?'active':'']" as="button" :href="route('transactions.list')" class="px-[10px] py-[3px] bg-gray-200 rounded">Transfers</Link>
      </li>
      <li>
        <Link :class="[active === 'Deposits'?'active':'']" as="button" :href="route('transactions.list_deposits')" class="px-[10px] py-[3px] bg-gray-200 rounded">Deposits</Link>
      </li>
      <li>
        <Link :class="[active === 'Withdrawals'?'active':'']" as="button" :href="route('transactions.list_withdrawals')" class="px-[10px] py-[3px] bg-gray-200 rounded">Withdrawals</Link>
      </li>
    </ul>
  </div>
</template>

<style scoped lang="scss">
button.active{
  @apply bg-gray-800 text-white;
}
</style>