<script setup>
import {usePage} from "@inertiajs/vue3";
import axios from "axios";

const props = defineProps(['match', 'view'])

const page = usePage();
const authUserId = page.props.auth.user.id;

// Initialize currentUserParticipant to null
let currentUserParticipant = null;

// Check if participants exist and is an array
if (Array.isArray(props.match.participants) && props.match.participants.length > 0) {
  // Find the participant whose user_id matches the authenticated user's ID
  currentUserParticipant = props.match.participants.find(participant => participant.user_id === authUserId);
}


async function joinMatch() {
  try {
    let response = await axios.post(route('matches.joinMatch'), {matchId: props.match.id})
    alert("Joined Match successfully..")
    window.location.reload()
  } catch (error) {
    alert(error.response.data.message)
  }
}

</script>

<template>
  <div class="border rounded-md overflow-hidden">
    <div class="h-[190px] bg-black relative overflow-hidden">
      <img src="/storage/system/codm_banner.jpg" alt="banner">
      <div class="game_banner_overlay absolute top-0 w-full h-full flex-col justify-between">
        <section class="flex items-center justify-end p-[10px]">
          <p class="bg-green-500 text-white w-fit rounded-lg p-[3px]">{{ match.status }}</p>
        </section>
        <section>
          <div class="p-[10px] flex items-center">
            <img class="w-[25px]" src="/storage/system/Coin%20Light.png">
            <p class="text-white text-[15px] px-[5px]">{{ match.stake }}</p>
          </div>
          <div class="text-center p-[10px] text-white">
            <p>{{ match.date }}</p>
            <p>{{ match.time }}</p>
          </div>
          <div class="p-[10px] flex items-center">
            <img class="w-[25px]" src="/storage/system/icons8-crowd-50.png">
            <p class="text-white text-[15px] px-[5px]">{{ match.teams }}</p>
          </div>
        </section>
      </div>
    </div>
    <div class="p-[10px]">
      <ul class="w-full">
        <li class=" mb-[20px]">
          <p class="text-center font-bold">Ready Players</p>
          <p class="text-center mb-[5px]">{{ match.participants?.length ?? 0 }}</p>
          <hr class="w-[80%] mx-auto ">
        </li>
        <li class="mb-[20px]">
          <p class="text-center font-bold">Mode</p>
          <p v-if="match.mode === 'BRS'" class="text-center ">Battle Royal (Solos)</p>
          <p v-else-if="match.mode === 'BRD'" class="text-center ">Battle Royal (Duos)</p>
          <p v-else-if="match.mode === 'BRQ'" class="text-center ">Battle Royal (Quad)</p>
          <p v-else-if="match.mode === '1v1'" class="text-center ">PVP (1V1)</p>
          <p v-else-if="match.mode === '2v2'" class="text-center ">PVP (2V2)</p>
          <p v-else-if="match.mode === '5v5'" class="text-center ">PVP (5V5)</p>
        </li>
        <li class="grid place-content-center">
          <Link v-if="view"
                as="button"
                :href="route('matches.view_match',[1])"
                class="bg-gray-300 px-[30px] py-[5px] rounded"
                v-html="'View Match'"
          />
          <div v-else-if="match.participants && currentUserParticipant == null">
            <button class="w-full py-[10px]" @click="joinMatch()">Join Match</button>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<style scoped lang="scss">
button {
  @apply bg-gray-300 px-[30px] rounded;
  &:active {
    transition: all ease-in-out 0.3ms;
    @apply bg-gray-700 text-white;
  }
}

button:active {
  transition: all ease-in-out 0.3ms;
  @apply bg-gray-700 text-white;
}

.game_banner_overlay {
  background-image: linear-gradient(180deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, 1) 100%);
  display: flex;

  section:nth-of-type(2) {
    @apply flex items-end justify-between;
  }
}
</style>
