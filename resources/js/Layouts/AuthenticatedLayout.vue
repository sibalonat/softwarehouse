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
            <nav class="w-full border-b border-gray-100 bg-virtual-blue fix">

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
                        <div
                        v-if="auth.game.name.length > 1"
                        class="items-center hidden px-4 py-1 space-x-4 text-sm rounded-md text-neutral-50 bg-neutral-50/10 md:flex">
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
                        <div class="items-center hidden px-4 py-1 space-x-4 text-sm rounded-md text-neutral-50 bg-neutral-50/10 md:flex">
                            <p>
                                <span class="mr-2 text-xs opacity-70">
                                Budget:
                                </span>
                                {{ auth.game.balance }} €
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-2">

                        <slot name="green-bar-button-right"></slot>
                    </div>
                </div>

            </nav>

            <!-- Page Heading -->
            <header class="mt-4 bg-white shadow" v-if="$slots.header">
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
            <footer class="w-full fixed bottom-0 bg-virtual-blue py-2">
                <div class="mx-auto w-1/3 grid grid grid-cols-3 ">

                    <Link
                    :href="route(link.route)"
                    v-for="link in auth.menu_footer"
                    :key="link"
                    :class="route().current(link.route) ? 'bg-slate-50 text-virtual-blue rounded-md' : 'text-slate-50'"
                    class="py-2 text-center font-semibold text-lg uppercase">
                        {{ link.title }}
                    </Link>

                </div>
            </footer>
        </div>
    </div>
</template>
