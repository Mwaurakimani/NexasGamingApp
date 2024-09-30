<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import MatchCard from "@/Components/App/MatchCard.vue";
import Mode1v1 from "@/Pages/Views/Players/Matches/Components/Modes/Mode1v1.vue";
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";

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


console.log(currentUserParticipant?.user_score)

function postResutlts() {
  axios.post(route('matches.postResults', [props.match.id]), {
    kills:kills.value
  }).then((res) => {
    alert("Updated scores successfully...")
  }).catch((err) => {
    console.log(err)
  })
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
<!--          <div class="flex items-center justify-between mb-[5px] flex-wrap">-->
<!--            <label>Moderator Score/Kills</label>-->
<!--            <input v-model="kills" class="w-[100px] text-right border-1 border-gray-400 h-[30px] rounded" type="number">-->
<!--            <div v-if="currentUserParticipant?.user_score == null" class="w-full flex justify-between py-[20px]">-->
<!--              <button @click.prevent.stop="postResutlts" class="w-full py-[10px]">Confirm Results</button>-->
<!--            </div>-->
<!--          </div>-->
        </div>
      </section>
      <div v-else-if="match.status === 'Starting'" class="px-[10px] border p-[20px] rounded">
        <ul>
          <li class="flex justify-between mb-[20px]" >
            <p>Link: </p>
            <p>{{match.link}}</p>
          </li>
          <li class="flex justify-between">
            <p>Password </p>
            <p>{{match.password}}</p>
          </li>
        </ul>
      </div>
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
