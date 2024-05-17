<script setup>
import { onMounted } from "vue";

import { Link, router, usePage } from "@inertiajs/vue3";
import Dropdown from "./Dropdown.vue";
import NavLink from "@/Components/NavLink.vue";
import { storeToRefs } from "pinia";

import DynamicHeroicon from "./Partials/DynamicHeroIcon.vue";
import { useNavigationStore } from "@/Stores/NavigationStore";
import ApplicationLogo from "./ApplicationLogo.vue";
// import { useNavigationStore } from '@/Stores/NavigationStore';
// properties
const inertia = usePage();
// pinia
const menu = useNavigationStore();
const { NavigateToDashboard } = menu
const { targets } = storeToRefs(menu);

// props
const prop = defineProps({
    open: Boolean,
});

// methods

// hooks
onMounted(() => {

});
</script>
<template>
<div class="fixed top-0 left-0 flex flex-col h-full max-h-full text-left bg-white z-700 v-sid-menu" ref="targets">
    <div class="flex flex-col w-full p-2 mt-0.5 text-neutral-800">
        <button class="p-2" @click="NavigateToDashboard" :class="project ? 'seperationXsm' : 'seperationSm'">
            Logo
        </button>
        <div class="border containerPaddingXs border-neutral-200 containerRoundedBase seperation-base">
            <div class="flex items-center justify-between w-full py-1 pr-2 text-start" :class="project ? 'border-b' : ''" >
                <p class="py-1 pr-2 buttonSecondaryLight buttonLight">
                    {{ $page.props.auth.user.name.charAt(0).toUpperCase() + $page.props.auth.user.name.slice(1) }}
                </p>
                <button
                    v-if="!project"
                    @click="router.get(route('profile.edit'))"
                    class="px-3 py-0.5 text-sm leading-5 text-center border rounded-full cursor-pointer buttonPrimaryOutline" >
                    <DynamicHeroicon name="pencil" :size="3" class="inline" />
                </button>
            </div>
            <div class="flex items-center justify-between w-full containerPaddingXs" v-if="project">
                <p class="">Notifiche</p>
                <button
                    @click="router.get(route('notifications', [project, inertia.props.auth.user.team.id]))"
                    class="px-1 text-sm text-center border rounded-full cursor-pointer buttonDanger buttonSecondary buttonSm"
                    v-if="inertia.props"
                >
                    {{ inertia.props.unreadNotificationsCount }}
                </button>
            </div>
        </div>
    </div>
    <div class="relative flex flex-col flex-1">
        <div class="w-full overflow-hidden h-377">
            <div class="h-full overflow-y-auto">
                <ul class="flex flex-col scroll">
                    <li v-for="link in navLinks" :key="link" class="text-sm">
                        <NavLink
                            :classNames="'py-2'"
                            v-if="!link.param"
                            :href="route(link.route)"
                            :active="route().current(link.route)">
                            <DynamicHeroicon :name="link.icon" :size="7" class="mr-2 bg-icon " />
                            {{ link.name }}
                        </NavLink>
                        <NavLink
                            v-else
                            :classNames="'py-2'"
                            :href="route(link.route, link.param)"
                            :active="route().current(link.route, link.param)">
                            <DynamicHeroicon :name="link.icon" :size="8" class="p-1 mr-2 rounded-md bg-bg-icon" />
                            <span class="uppercase title">
                                {{ link.name }}
                            </span>
                        </NavLink>
                    </li>
                </ul>
                <hr style="border-color: rgba(0, 0, 0, 0.1); margin: 5px;" v-if="!project">
            </div>
        </div>
    </div>
</div>
</template>

<style>
.v-sid-menu {
    width: 100% !important;
}

/* width: 400px */

@media (min-width: 1000px) {
    .v-sid-menu {
        width: 400px !important;
    }
}

.scroll {
    transition: width .3s ease;
}

.v-sid-menu.vsm_white-theme .vsm--link_level-1 .vsm--icon {
    background-color: rgb(241 245 249) !important ;
}

/* .v-sidebar-menu.vsm_white-theme {
    z-index: 1000000 !important;
} */

.v-sid-menu.vsm_white-theme .vsm--link {
    color: rgb(100 116 139) !important;
}

.v-sid-menu .vsm--toggle-btn {
    background-color: #40865c !important;
    color: white !important;
}

.v-sid-menu .title > span:first-child {
    width: 100% !important;
    display: block !important;
    word-wrap: break-word !important;
    white-space: normal !important;
    line-height: normal;
    font-size: 0.9rem;
}
/* v-sidebar-menu vsm_collapsed vsm_white-theme */

.localPopoverButton {
    @apply w-full flex items-center space-x-2 !py-1.5 !px-2
}

.localPopoverButtonIcon {
    @apply mr-2;
}

.v-sid-menu .title {
    text-transform: uppercase;
}
</style>

