import './bootstrap'
import '../css/app.css'
import {createApp, h} from 'vue'
import {createInertiaApp, Head, Link} from '@inertiajs/vue3'
import {resolvePageComponent} from 'laravel-vite-plugin/inertia-helpers'
import {ZiggyVue} from 'ziggy-js'
import {createPinia} from 'pinia'
import clickOutside from './directives/clickOutside'
import GuestDashboardLayout from "@/Layouts/DashboardLayoutsTemplates/GuestDashboardLayout.vue";
import PlayerDashboardLayout from "@/Layouts/DashboardLayoutsTemplates/PlayerDashboardLayout.vue";
import ModeratorDashboardLayout from "@/Layouts/DashboardLayoutsTemplates/ModeratorDashboardLayout.vue";
import ManagerDashboardLayout from "@/Layouts/DashboardLayoutsTemplates/ManagerDashboardLayout.vue";
import AdminDashboardLayout from "@/Layouts/DashboardLayoutsTemplates/AdminDashboardLayout.vue";

//Global Compatibles

//page components -> Dashboard

const pinia = createPinia()
const appName = import.meta.env.VITE_APP_NAME || 'Nexus'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            .use(ZiggyVue)
            .component('Head', Head)
            .component('Link', Link)
            // Register layouts globally
            .component('GuestDashboardLayout', GuestDashboardLayout)
            .component('PlayerDashboardLayout', PlayerDashboardLayout)
            .component('ModeratorDashboardLayout', ModeratorDashboardLayout)
            .component('ManagerDashboardLayout', ManagerDashboardLayout)
            .component('AdminDashboardLayout', AdminDashboardLayout)

        // ✅ Register directive globally
        app.directive('click-outside', clickOutside)

        app.mount(el)
        return app
    },
    progress: {
        color: '#4B5563',
    },
})
