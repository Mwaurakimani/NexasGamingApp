import { defineStore } from 'pinia'
import {router, usePage} from "@inertiajs/vue3";  // or however you get the current user

export const useNotificationStore = defineStore('notification', {
    state: () => ({
        notifications: [],     // all incoming notifications
        _channel: null,        // keep track so we don’t double-subscribe
    }),

    actions: {
        subscribe() {
            const page = usePage()
            const userId = page.props.auth.user.id
            if (this._channel || !userId) return

            let channel = window.Echo
                .private(`user.${userId}`)
                .subscribed(() => {
                    console.log(`✅ Subscribed to user.${userId}`)
                })
                .error(error => {
                    console.error(`🚨 Subscription error on user.${userId}:`, error)
                })
                .listen('.UserNotification', payload => {
                    if (router.page.component !== 'games/chess/Index'){
                        alert(payload.message)
                        router.visit(route('game.chess.index',[payload.data.match_id]))
                    }
                })
            this._channel = channel
        },

        unsubscribe() {
            if (!this._channel) return
            window.Echo.leaveChannel(this._channel.name)
            this._channel = null
        },

        markAllRead() {
            this.notifications = []
        }
    }
})
