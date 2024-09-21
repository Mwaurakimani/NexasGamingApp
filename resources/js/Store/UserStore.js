import {defineStore} from 'pinia'
import {ref} from "vue";


export const useUserStore = defineStore('users', () => {
    const auth_user = ref(null)
})
