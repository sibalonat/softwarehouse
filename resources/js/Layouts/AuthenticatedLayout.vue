<script setup>
import { ref } from 'vue';
import NavLink from '@/Components/NavLink.vue';
import DynamicHeroicon from "@/Components/Partials/DynamicHeroIcon.vue";
import { Link } from '@inertiajs/vue3';
import { useNavigationStore } from '@/Stores/NavigationStore';
import { storeToRefs } from 'pinia';
import Sidebar from '@/Components/Sidebar.vue';
import HamburgeMenuButton from '@/Components/HamburgeMenuButton.vue';


const navigation = useNavigationStore();
const { triggerShow } = navigation;
const { auth, showingSidebar } = storeToRefs(navigation);


</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="border-b border-gray-100 bg-virtual-blue">

                <div class="flex items-center justify-between h-12 px-10 containerBase">
                    <!-- ------------------- -->
                    <div class="flex items-center space-x-3">
                        <HamburgeMenuButton class="-translate-x-2 lg:-translate-x-4" />
                        <div class="items-center hidden px-4 py-1 space-x-2 text-sm rounded-md text-neutral-50 md:flex">
                            <Link :href="route('dashboard')">
                                <DynamicHeroicon
                                name="home"
                                :size="6"
                                class="inline p-1 my-auto ml-2 bg-white rounded-md text-virtual-blue" />
                            </Link>
                        </div>
                        <div class="items-center hidden px-4 py-1 space-x-2 text-sm rounded-md text-neutral-50 bg-neutral-50/10 md:flex">
                            <p><span class="mr-2 text-xs opacity-70">CEO:</span>{{ auth.user.name }} </p>
                            <span class="text-neutral-50 opacity-70">|</span>
                            <Link :href="route('profile.edit')" class="-ml-3">
                                Profilo
                                <DynamicHeroicon
                                name="pencil"
                                :size="5"
                                class="inline p-1 my-auto ml-2 bg-white rounded-md text-virtual-blue" />
                            </Link>
                        </div>
                        <div class="items-center hidden px-4 py-1 space-x-4 text-sm rounded-md text-neutral-50 bg-neutral-50/10 md:flex">
                            <p>
                                <span class="mr-2 text-xs opacity-70">
                                Azienda:
                                </span>
                                {{ auth.game.name }}
                            </p>
                        </div>
                        <div class="items-center hidden px-4 py-1 space-x-4 text-sm rounded-md text-neutral-50 bg-neutral-50/10 md:flex">
                            <p>
                                <span class="mr-2 text-xs opacity-70">
                                Current gameplay:
                                </span>
                                {{ auth.user.current_gameplay }}
                            </p>
                        </div>
                        <div class="items-center hidden px-4 py-1 space-x-4 text-sm rounded-md text-neutral-50 bg-neutral-50/10 md:flex">
                            <p>
                                <span class="mr-2 text-xs opacity-70">
                                Last gameplay:
                                </span>
                                {{ auth.user.last_gameplay }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">
                        <!-- NavLink -->
                        <!-- <div class="flex items-center !px-0.5 !py-0.5 !bg-neutral-200/20 !text-neutral-50 buttonSm border border-neutral-50/50 space-x-1" v-if="project">
                            <DynamicHeroicon name="view-columns" class="mr-0"></DynamicHeroicon>
                            <Link
                                class="!px-3 !py-0.5 !bg-neutral-50/20 !text-neutral-50 buttonSm hover:!bg-neutral-50/25 hover:text-white flex items-center"
                                v-if="giornaleLavori"
                                :href="`${route('contractor.resources', [ project, user.props.auth.user, latestWorkDay ])}?type=generale`"
                            >
                                Giornale Lavori
                            </Link>
                            <Link
                                class="!px-3 !py-0.5 !bg-neutral-50/20 !text-neutral-50 buttonSm hover:!bg-neutral-50/25 hover:text-white flex items-center"
                                v-if="worklog"
                                :href="`${route('dailywork.log', [project, user.props.auth.user])}?type=lavoratori`"
                            >
                                Registro Personale
                            </Link>
                            <Link
                                v-if="isAdmin"
                                class="!px-3 !py-0.5 !bg-neutral-50/20 !text-neutral-50 buttonSm hover:!bg-neutral-50/25 hover:text-white flex items-center"
                                :href="route('mask.repeater', [project, project.masks])"
                            >
                                Scheda Lavoro
                            </Link>

                        </div> -->
                        <!-- <div class="my-auto max-w-fit" v-if="typeDocument !== 'sheet'">
                            <button type="button" @click="openCloseMenu" class="flex items-center buttonSm buttonSecondary" v-if="project">
                                <DynamicHeroicon name="folder" class="mr-2"></DynamicHeroicon>
                                Menu Cartelle
                            </button>
                            <div v-else>
                                <ReturnButton
                                    icon="home"
                                    buttonSize="buttonSm"
                                    :callback="() => !isOnDashboard && router.visit(route('dashboard'))"
                                    :text="isOnDashboard ? 'Pagina progetti' : 'Pagina progetti'"
                                    :buttonType="isOnDashboard ? 'buttonTertiary' : 'buttonSecondary'"
                                    :classNames="
                                        isOnDashboard
                                            ? 'opacity-50 cursor-not-allowed !text-neutral-50 transition-all duration-300 ease-in-out'
                                            : 'buttonSecondary'
                                    "
                                    outline
                                />
                            </div>
                        </div> -->
                        <slot name="green-bar-button-right"></slot>
                    </div>
                </div>

            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Menu -->
            <div class="fixed top-0 left-0 w-screen h-screen transition-all duration-500 ease-in-out z-900" v-if="showingSidebar">
                <div
                    class="w-screen h-full"
                    :class="showingSidebar ? 'bg-neutral-900/50' : 'bg-neutral-900/0 pointer-events-none'"
                    @click="() => (triggerShow())"
                ></div>

                <Sidebar :open="showingSidebar" />
            </div>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
