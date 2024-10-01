<script setup>
const props = defineProps(['searchTerm','searchedUsers','participants'])
const emits = defineEmits([
    'update:searchTerm',
    'handleSelectUser',
    'handleAddUserToMatch'
])
</script>

<template>
    <section>
        <div class="flex justify-between mb-[20px]">
            <div class="w-[400px] h-[30px] relative">
                <div class="flex gap-1">
                    <input id="search_user_input" class="!w-[250px] h-[30px] rounded p-[3px]" placeholder="Search user..."
                           :value="searchTerm" @input="emits('update:searchTerm',$event.target.value)" AUTOCOMPLETE="OFF">
                    <button class="w-[50px]" @click="emits('handleAddUserToMatch')">Add</button>
                </div>
                <div class="shadow bg-white rounded p-[10px]" style="z-index: 10000">
                    <div @click.prevent="emits('handleSelectUser',item.username)" v-for="item in searchedUsers" class="p-[5px] cursor-pointer rounded bg-gray-200 hover:bg-gray-600 hover:text-white mb-[10px]">
                        <p>Userename: {{item.username}}</p>
                        <p>Eamil: {{item.email}}</p>
                        <p>COD Username: {{item.codm_username}}</p>
                    </div>
                </div>
            </div>
            <div>
                <div class="flex gap-1">
                    <input class="!w-[250px] h-[30px] rounded p-[3px]" placeholder="Search user...">
                </div>
            </div>
        </div>
        <div v-if="participants">
            <table class="border w-full text-sm">
                <thead class="bg-black text-white">
                <tr>
                    <th class="p-[5px]">ID</th>
                    <th class="py-[5px]">Username</th>
                    <th class="py-[5px]">Grouped</th>
                    <th class="py-[5px]">Grouped Name</th>
                    <th class="py-[5px]">CODM Username</th>
                    <th class="py-[5px]">U Score</th>
                    <th class="py-[5px]">Ad Score</th>
                    <th class="py-[5px]">Action</th>
                </tr>
                </thead>
                <tbody>
                <Link class="hover:!bg-black hover:!text-white cursor-pointer" as="tr"
                      :href="route('accounts.view_user',[user.id])" v-for="user in participants">
                    <td class="p-[5px] px-[10px]">{{ user.id }}</td>
                    <td class="py-[5px]">{{ user.username }}</td>
                    <td class="py-[5px]">{{ user.username }}</td>
                    <td class="py-[5px]">{{ user.username }}</td>
                    <td class="py-[5px]">{{ user.codm_username }}</td>
                    <td class="py-[5px]">{{ user.user_score }}</td>
                    <td class="py-[5px]">{{ user.moderator_score }}</td>
                    <td class="py-[5px]">Remove</td>
                </Link>
                </tbody>
            </table>
        </div>
    </section>
</template>

<style scoped lang="scss">
button {
    @apply bg-gray-300 ;

    &:hover {
        @apply bg-gray-400 text-white;
    }

    &:active {
        transition: all ease-in-out 0.3ms;
        @apply bg-gray-700 text-white;
    }
}


input,textarea {
    display: block !important;
    width: 100%;
    border: 1px solid lightgray;
    outline: none;
}
</style>
