<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import {onMounted} from "vue";

const props = defineProps(['matches'])

onMounted(() => {
  $("#see-more").click(function() {
    $.get($ul.find("a[rel='next']").attr("href"), function(response) {
      $posts.append(
          $(response).find("#posts").html()
      );
    });
  });
})

const formatTime = (timeString) => {
  const [hours, minutes] = timeString.split(':');
  const ampm = hours >= 12 ? 'PM' : 'AM';
  const formattedHours = (hours % 12 || 12).toString();
  return `${formattedHours}:${minutes.padStart(2, '0')} ${ampm}`;
};

function formatDate(dateString) {
  // Split the date string by '-'
  const [year, month, day] = dateString.split('-');

  // Rearrange to "dd-mm-yy"
  return `${day}-${month}-${year.slice(2)}`;
}
</script>

<template>
  <DashboardLayout>
    <h1 class="font-bold text-[20px] mb-[20px]">Matches</h1>
    <div class="flex gap-[20px] mb-[20px]">
      <Link as="button" :href="route('matches.MyMatches')">My Matches</Link>
    </div>
    <div class="mb-[20px] bg-gray-100 p-[15px]">
      <ul class="flex gap-3">
        <li class="flex flex-col">
          <label class="mb-[10px]">Match Type</label>
          <select>
            <option value="BRS">Battle Royal (Solo)</option>
            <option value="BRD">Battle Royal (Duo)</option>
            <option value="BRQ">Battle Royal (Quad)</option>
            <option value="1v1">1 v 1</option>
            <option value="2v2">2 v 2</option>
            <option value="5v5">2 v 2</option>
          </select>
        </li>
      </ul>
    </div>
    <section v-if="matches.data.length > 0">
      <ul>
        <Link as="li" :href="route('matches.view_match',[match.id])" v-for="match in matches.data" class="match_display w-full mb-[20px] overflow-hidden shadow b-[10px] rounded">
          <div class="flex gap-[20px] ">
            <img class="mr-[2px] w-[100px] md:w-[200px] object-cover" src="/storage/system/codm_banner.jpg" alt=""/>
            <section class="w-[100%] py-[5px] text-sm md:text-lg lg:text-xlg pr-[5px]">
              <div class="flex  mb-[3px] justify-between gap-[5px]">
                <span class="font-bold">Mode</span>
                <p v-if="match.mode === 'BRS'" class="text-center ">Battle Royal (Solos)</p>
                <p v-else-if="match.mode === 'BRD'" class="text-center ">Battle Royal (Duos)</p>
                <p v-else-if="match.mode === 'BRQ'" class="text-center ">Battle Royal (Quad)</p>
                <p v-else-if="match.mode === '1v1'" class="text-center ">PVP (1V1)</p>
                <p v-else-if="match.mode === '2v2'" class="text-center ">PVP (2V2)</p>
                <p v-else-if="match.mode === '5v5'" class="text-center ">PVP (5V5)</p>
              </div>
              <div class="flex  mb-[3px] justify-between gap-[5px]">
                <span class="font-bold">Date</span>
                <span>{{formatTime(match.time)}} {{formatDate(match.date)}}</span>
              </div>
              <div class="flex  mb-[3px] justify-between gap-[5px]">
                <span class="font-bold">Teams/Players</span>
                <span>{{match.teams}}</span>
              </div>
              <div class="flex  mb-[3px] justify-between gap-[5px]">
                <span class="font-bold">Stake</span>
                <span class="flex gap-0.5 items-center">
                    <img src="/storage/system/Coin%20Dark.png" alt="coin" class="h-[20px]">
                    <span>{{match.stake}}</span>
                  </span>
              </div>
            </section>
          </div>
        </Link>
      </ul>
      <div class="flex items-center justify-center">
        <button class="px-[30px] py-[5px] rounded" id="see-more">Load More</button>
      </div>
    </section>
    <p v-else class="text-center p-[30px] bg-gray-200 md:h-full font-bold">There is currently no active match to display</p>

  </DashboardLayout>
</template>

<style scoped lang="scss">
button {
  @apply bg-gray-300 px-[30px] py-[5px] rounded;
  &:active {
    transition: all ease-in-out 0.3ms;
    @apply bg-gray-700 text-white;
  }
}

select, input {
  @apply w-[250px] px-[10px] py-[5px] border-2 border-gray-300 rounded;
}

.match_display {
  transition: all linear 0.1s;

  &:hover {
    @apply bg-gray-700 text-white;
    cursor: pointer;
    transform: scale(1.01);
  }
}
</style>
