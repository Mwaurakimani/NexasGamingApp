<script setup>
import DashboardLayout from "@/Layouts/DashboardLayouts/DashboardLayout.vue";
import UsuportedDevice from "@/Components/App/UsuportedDevice.vue";
import MatchDetailsForm from "@/Pages/Views/Admin/Matches/Components/MatchDetailsForm.vue";
import EventDetailsForm from "@/Pages/Views/Admin/Matches/Components/EventDetailsForm.vue";
import ParticipantsComponent from "@/Pages/Views/Admin/Matches/Components/ParticipantsComponent.vue";
import MatchResultsUpload from "@/Pages/Views/Admin/Matches/Components/MatchResultsUpload.vue";
import {router, useForm} from "@inertiajs/vue3";
import {reactive, ref, watch} from "vue";
import {debounce} from "lodash";
import axios from "axios";


//update match details
const props = defineProps(['match'])
const matchForm = useForm({
    mode: props.match.mode,
    date: props.match.date,
    teams: props.match.teams,
    status: props.match.status,
    time: props.match.time,
    stake: props.match.stake,
})
const save_match = async () => {
    try {
        matchForm.time = matchForm.time = formatTime(matchForm.time);
        await matchForm.put(route('matches.put_match_action', [props.match.id]), {
            preserveState: true,
        });
        alert("Updated Match Details")
    } catch (error) {
        console.log(error);
    }
}
const formatTime = (time) => {
    const [hours, minutes] = time.split(':');
    return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
};

//update event details
const EventForm = useForm({
    link: props.match.link,
    password: props.match.password,
    pace: props.match.pace,
    notes: props.match.notes,
})
const updateEvent = async () => {
    try {
        await EventForm.put(route('matches.put_match_event_action', [props.match.id]), {
            preserveState: true,
        });

        alert("Updated Match Details")
    } catch (error) {
        console.log(error);
    }
}

//search functionality
const searchTerm = ref('')
const searchedUsers = reactive([])
const search_user_api = debounce(() => {
    if (searchedUsers.value === "") {
        searchedUsers.splice(0, searchedUsers.length);
    } else {
        axios.post(route("matches.get_user_by_name"), {
            search: searchTerm.value
        })
            .then(response => {
                searchedUsers.splice(0, searchedUsers.length, ...response.data);
            })
            .catch(error => {
                console.error(error);
            });
    }

}, 500)
watch(searchTerm, search_user_api);
const handleSelectUser = (username) => {
    searchedUsers.splice(0, searchedUsers.length);
    searchTerm.value = username
};
const handleAddUserToMatch = async () => {
    searchedUsers.splice(0, searchedUsers.length);
    await axios.post(route('matches.addUserToMatch'), {
        username: searchTerm.value,
        matchId: props.match.id
    }).then(() => {
        alert("User added successfully")
        window.location.reload();
    }).catch((error) => {
        console.log(error)
    })
}

</script>

<template>
    <DashboardLayout>
        <UsuportedDevice/>
        <h1 class="font-bold text-[20px] mb-[20px]">Create Matches</h1>
        <div class="flex justify-between mb-[20px]">
            <article class="flex gap-1">
                <Link as="button" :href="route('matches.list')">Matches</Link>
            </article>
            <article class="flex gap-x-2 items-center">
            </article>
        </div>
        <section class="content-area">
            <section>
                <div>
                    <h1>Match Detail : {{ match.id }}</h1>
                    <MatchDetailsForm :matchForm @save_match="save_match"></MatchDetailsForm>
                </div>
                <div>
                    <h1>Participants Details</h1>
                    <ParticipantsComponent
                        v-model:searchTerm="searchTerm"
                        :searchedUsers
                        :participants="match.participants"
                        @handleSelectUser="handleSelectUser"
                        @handleAddUserToMatch="handleAddUserToMatch"
                    ></ParticipantsComponent>
                </div>
                <div>
                    <h1>Results Details</h1>
                    <MatchResultsUpload></MatchResultsUpload>
                </div>
            </section>
            <section>
                <div>
                    <div class="flex justify-between items-center">
                        <h1>Event Details</h1>
                        <button @click.prevent="updateEvent">Update</button>
                    </div>
                    <EventDetailsForm :EventForm></EventDetailsForm>
                </div>
            </section>
        </section>

    </DashboardLayout>
</template>

<style scoped lang="scss">
button {
    @apply bg-gray-300 px-[10px] py-[5px] rounded;

    &:hover {
        @apply bg-gray-400 text-white;
    }

    &:active {
        transition: all ease-in-out 0.3ms;
        @apply bg-gray-700 text-white;
    }
}

.content-area {
    width: 100%;
    height: calc(100% - 45px);
    @apply overflow-auto flex gap-1;

    & > section:nth-of-type(1) {
        width: 65%;
    }

    & > section:nth-of-type(2) {
        width: 35%;
    }

    & > section {
        & > div {
            width: 100%;
            @apply rounded border border-gray-100 shadow-lg p-2 mb-[20px];

            h1 {
                @apply font-bold text-[20px] text-gray-700 mb-[10px];
            }

        }
    }
}
</style>
