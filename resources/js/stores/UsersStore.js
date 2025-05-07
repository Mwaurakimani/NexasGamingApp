import { defineStore } from 'pinia'

export const useGameStore = defineStore('game', {
    state: () => ({
        games: [],          // all available challenges
        currentGame: null,  // selected challenge
        onlineUsers: [],    // real-time participants
    }),
    getters: {
        totalGames: (state) => state.games.length,
    },
    actions: {
        setGames(list) {
            this.games = list
        },
        selectGame(game) {
            this.currentGame = game
        },
        addOnlineUser(user) {
            if (!this.onlineUsers.includes(user)) this.onlineUsers.push(user)
        },
    },
})
