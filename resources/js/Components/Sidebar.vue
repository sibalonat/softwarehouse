<script setup>
import { onMounted } from "vue";
import MenuLink from "@/Components/MenuLink.vue";
import { storeToRefs } from "pinia";

import DynamicHeroicon from "./Partials/DynamicHeroIcon.vue";
import { useNavigationStore } from "@/Stores/NavigationStore";

import Accordion from "@/Components/Partials/Menu/Accordion.vue";
import AccordionItem from "@/Components/Partials/Menu/AccordionItem.vue";

import HamburgeMenuButton from '@/Components/HamburgeMenuButton.vue';

// properties
// pinia
const menu = useNavigationStore();
const { targets, auth, nav_links } = storeToRefs(menu);
// hooks
onMounted(() => {});

</script>
<template>
<div class="fixed top-0 left-0 flex flex-col h-full max-h-full text-left bg-virtual-blue z-700 v-sid-menu" ref="targets">
    <div class="flex flex-col w-full p-2 mt-0.5">
        <div class="p-3 border border-b-bg-icon seperation-base">
            <div class="flex items-center justify-between w-full px-4 py-1 text-start" >
                <p class="py-1 pr-2 text-bg-icon">
                    {{ auth.user.name.charAt(0).toUpperCase() + auth.user.name.slice(1) }}
                </p>
                <div class="flex mx-auto">

                </div>
                <HamburgeMenuButton class=" lg:-translate-x-2 text-gray-500" />
            </div>
        </div>
    </div>
    <div class="relative flex flex-col flex-1 bg-virtual-blue">
        <div class="w-full overflow-hidden h-377">
            <div class="h-full overflow-y-auto">
                <ul class="flex flex-col p-4 text-white scroll">
                    <li v-for="link in nav_links" :key="link" class="py-2 text-xl">
                        <Accordion v-if="link.children.length">
                            <AccordionItem>
                                <template #accordion-trigger>
                                    <button class="flex items-center justify-between w-full group" v-if="link.children.length" >
                                        <p>
                                            {{ link.title.charAt(0).toUpperCase() + link.title.slice(1) }}
                                        </p>
                                        <DynamicHeroicon name="chevron-down" :size="5" class="icon neutral-x-4" outline />
                                    </button>
                                </template>

                                <template #accordion-content v-if="link.children.length">
                                    <div class="flex flex-col w-full mt-2 space-y-3"
                                    v-if="link.children.length">
                                        <MenuLink
                                            v-for="sublink in link.children"
                                            :key="sublink"
                                            :condition="false"
                                            :href="route(sublink.route)"
                                            :active="route().current(sublink.route)">
                                            <DynamicHeroicon :name="sublink.icon" :size="5" class="mr-2 text-gray-circles " />
                                            {{ sublink.title }}
                                        </MenuLink>
                                    </div>
                                </template>
                            </AccordionItem>
                        </Accordion>

                        <MenuLink
                        v-if="!link.children.length"
                        :href="route(link.route)"
                        :method="link.route === 'logout' ? 'post' : ''"
                        :active="route().current(link.route)">
                        <DynamicHeroicon :name="link.icon" :size="5" class="mr-2 text-gray-circles" />
                            {{ link.title }}
                        </MenuLink>
                    </li>
                </ul>
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

