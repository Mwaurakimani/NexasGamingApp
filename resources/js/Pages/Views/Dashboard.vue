<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import {usePage} from "@inertiajs/vue3";
import Modal from "@/Components/App/Modal.vue";
import {shallowRef} from "vue";
import DepositBox from "@/Pages/Views/Players/Components/DepositBox.vue";
import WithdrawalBox from "@/Pages/Views/Players/Components/WithdrawalBox.vue";
import Welcome from "@/Pages/Views/Dashboard/Compoanents/Welcome.vue";
import DashboardExtentionView from "@/Pages/Views/Dashboard/Compoanents/DashboardExtentionView.vue";
import LeaderBoard from "@/Pages/Views/Dashboard/Compoanents/LeaderBoard.vue";
import CurrentMatchDisplay from "@/Pages/Views/Dashboard/Compoanents/CurrentMatchDisplay.vue";
import BalanceDisplay from "@/Pages/Views/Dashboard/Compoanents/BalanceDisplay.vue";


const props = defineProps(['username', 'account', 'currentMatch', 'leaderBoard', 'active_moderator'])
const page = usePage()
const component = shallowRef()

function openModal(panel) {
  console.log(panel)
  if (panel === 'deposit') {
    component.value = DepositBox
  } else {
    component.value = WithdrawalBox
  }

  $('#main_modal').fadeIn('fast')
}

const closeModal = () => $('#main_modal').fadeOut('fast')

</script>
<template>
  <DashboardLayout>
    <Modal @closeModalTrigger="closeModal">
      <div class=" flex w-full h-full items-center justify-center">
        <component @closePanel="closeModal" :is="component"/>
      </div>
    </Modal>
    <Welcome/>
    <section class="flex">
      <div class="w-full md:flex-wrap md:flex ">
        <BalanceDisplay :account="account" @openModal="openModal"/>
        <CurrentMatchDisplay :currentMatch="currentMatch" :view="true"/>
        <LeaderBoard/>
      </div>
      <DashboardExtentionView/>
    </section>
  </DashboardLayout>
</template>

<style lang="scss" scoped>
@use "./Dashboard/index";
</style>
