<script setup>
import {usePage} from "@inertiajs/vue3";
import {computed} from "vue";

const role = usePage().props.Dashboards.role ?? 'Guest'
const isGuest = computed(() => role === 'Guest')
</script>
<template>
    <div class="dashboard overflow-hidden" :class="{'dashboard-auth': !isGuest,'dashboard-guest': isGuest}">
        <slot name="sidebar" />
        <div class="content-area h-screen pb-[80px]">
            <slot name="topnav" />
            <section class="main-content">
                <slot />
            </section>
        </div>
        <slot name="mobilenav" />
    </div>
</template>

<style scoped lang="scss">

.dashboard {
    display: grid;
    @apply bg-black text-white min-h-screen w-screen transition-all;

    @media (max-width: 768px) {
        grid-template-columns: 1fr;
    }
}

.content-area {
    .main-content {
        @apply h-full overflow-auto bg-white text-black rounded-t-lg pb-[80px];
    }
}

.dashboard-auth {
    grid-template-columns: 250px 1fr;

    @media (max-width: 768px) {
        grid-template-columns: 1fr;
    }
}

.dashboard-guest {
    grid-template-columns: 1fr;

    @media (max-width: 768px) {
        grid-template-columns: 1fr;
    }
}

</style>
