import {defineStore} from 'pinia'
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";

export const useUserStore = defineStore('users', {
    state: () => {
        return {
            authUser: ref(usePage().props.auth?.user)
        }
    },
    getters: {
        isSuperAdmin: function (state) {
            return state.authUser?.role_name === "Super Admin"
        },
        isAdmin: function (state) {
            return state.authUser?.role_name === "admin"
        }
    }
})
