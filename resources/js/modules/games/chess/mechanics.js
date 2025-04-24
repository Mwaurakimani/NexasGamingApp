import config from "@/modules/games/chess/config.js";

export const boardConfig = config

export function handleCheckmate(winner) {
    return `${winner === 'w' ? 'White' : 'Black'} wins!`
}

export function handleOffline() {
    alert('⚠️ You are offline! Leaving the game may result in a forfeit.')
}
