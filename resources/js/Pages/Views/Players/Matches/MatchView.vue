<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import MatchCard from "@/Components/App/MatchCard.vue";
import Mode1v1 from "@/Pages/Views/Players/Matches/Components/Modes/Mode1v1.vue";
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import ModeBRS from "@/Pages/Views/Players/Matches/Components/Modes/ModeBRS.vue";

const props = defineProps(['match', 'results'])
const page = usePage()
const authUserId = page.props.auth.user.id; // Get the authenticated user's ID
let currentUserParticipant = null;

// Check if participants exist and is an array
if (Array.isArray(props.match.participants) && props.match.participants.length > 0) {
  // Find the participant whose user_id matches the authenticated user's ID
  currentUserParticipant = props.match.participants.find(participant => participant.user_id === authUserId);
}

const kills = ref(currentUserParticipant?.user_score ?? 0)

function postResutlts() {
  axios.post(route('matches.postResults', [props.match.id]), {
    kills: kills.value
  }).then((res) => {
    alert("Updated scores successfully...")
  }).catch((err) => {
    console.log(err)
  })
}

function disputeResults(){
}

</script>

<template>
  <DashboardLayout>
    <div class="w-full pb-[30px] justify-between mx-auto md:max-w-[750px] rounded">
      <div class="flex items-center mb-[20px] justify-between">
        <h1 class="font-bold text-[20px] ">Matches ID: {{ match.id }}</h1>
      </div>
      <div class="flex gap-2 flex-wrap md:flex-nowrap mb-[30px]">
        <MatchCard class="border" :match="match" :view="false"></MatchCard>
      </div>
      <div v-if="currentUserParticipant == null">
        <Mode1v1 v-if="match.mode === '1v1'" :match="match"></Mode1v1>
        <ModeBRS v-if="match.mode === 'BRS'" :match="match"></ModeBRS>
      </div>
      <div v-else-if="match.status === 'Starting'" class="px-[10px] border p-[20px] rounded">
        <ul>
          <li class="flex flex-col justify-between mb-[20px]">
            <p class="mb-[10px] font-bold ">Copy the Password and click start to join the match</p>
            <li class="flex mb-[20px] justify-between font-bold">
              <p>Password: </p>
              <p>{{ match.password }}</p>
            </li>
            <iframe
                class="aspect-[4/3]"
                id="myIframe"
                :src="match.link"
                style="border:none;">
            </iframe>
          </li>
        </ul>
      </div>
      <div v-else-if="match.status === 'Progressing'">
        <p class="bg-gray-300 font-bold text-center py-[30px]">Match in progress..</p>
      </div>
      <section v-else-if="match.status === 'Tallying'">
        <div class="mb-[30px]">
          <div class="flex items-center justify-between mb-[5px] flex-wrap">
            <label>Score/Kills</label>
            <input v-model="kills" class="w-[100px] text-right border-1 border-gray-400 h-[30px] rounded" type="number">
            <div v-if="match.status === 'Tallying'" class="w-full flex justify-between py-[20px]">
              <button @click.prevent.stop="postResutlts" class="w-full py-[10px]">Confirm Results</button>
            </div>
          </div>
        </div>
      </section>
      <section v-else-if="match.status === 'Tallied'" class="border p-[10px] rounded">
        <h2 class="text-[25px] font-bold mb-[20px]">Results</h2>
        <div class="mb-[30px]">
          <div class="flex items-center justify-between mb-[5px] flex-wrap">
            <div class="flex justify-between w-full mb-[10px]">
              <label>Entered Score</label>
              <p>{{ currentUserParticipant.user_score }}</p>
            </div>
            <div class="flex justify-between w-full mb-[10px] border-b-gray-500 border-b pb-[10px]">
              <label>Modified Score</label>
              <p>{{ currentUserParticipant.moderator_score }}</p>
            </div>
            <div class="flex justify-between w-full mb-[10px]">
              <label>Estimated Payout</label>
              <div class="flex items-center gap-[5px]">
                <img class="h-[20px] w-[20px]" src="/storage/system/Coin%20Dark.png" alt="coin">
                <p class="flex">{{ currentUserParticipant.user_score * match.stake }}</p>
              </div>
            </div>
            <div class="flex justify-between w-full mb-[10px]">
              <label>Service Fee</label>
              <div class="flex items-center gap-[5px]">
                <img class="h-[20px] w-[20px]" src="/storage/system/Coin%20Dark.png" alt="coin">
                <p>{{ currentUserParticipant.user_score * match.stake * 0.1 }}</p>
              </div>
            </div>
            <div class="flex justify-between w-full mb-[10px]  border-b-gray-500 border-b pb-[10px]">
              <label>Full Payout</label>
              <div class="flex items-center gap-[5px]">
                <img class="h-[20px] w-[20px]" src="/storage/system/Coin%20Dark.png" alt="coin">
                <p>{{ currentUserParticipant.user_score * match.stake * 0.9 }}</p>
              </div>
            </div>
            <div v-if="match.status === 'Tallied'" class="w-full flex justify-between py-[10px]">
              <a :href="'https://wa.me/254719445697?text=Disputing_results_for match_id_'+match.id+'\n'"  @click.prevent.stop="disputeResults" class="block bg-gray-300 text-center rounded w-full py-[10px]">Dispute Results</a>
            </div>
            <p class="text-red-400">Ensure you have supporting proof to dispute the results. This includes screen recordings, screenshots or any other statistical analysis to support your claim</p>
          </div>
        </div>
      </section>


    </div>
  </DashboardLayout>
</template>

<style scoped lang="scss">
button {
  @apply bg-gray-300 px-[30px] rounded;
  &:active {
    transition: all ease-in-out 0.3ms;
    @apply bg-gray-700 text-white;
  }
}

.markdown-format {
  background-color: red;

  & > h1 {
    display: none !important;
  }
}
</style>
