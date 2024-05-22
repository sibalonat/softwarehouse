<script setup>
import RenderlessPagination from '@/Components/Pagination/RenderlessPagination.vue';
import DynamicHeroIcon from '@/Components/Partials/DynamicHeroIcon.vue';
import Accordion from '@/Components/Partials/Menu/Accordion.vue';
import AccordionItem from '@/Components/Partials/Menu/AccordionItem.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    developers: {
        type: Object,
        required: true,
    },
});

//methods
const goToPage = (e) => {
    if (e === props.developers.current_page && e - 1 === props.developers.current_page) {
        return;
    } else {
        const url = props.developers.links[e]?.url;
        router.visit(url);
    }
}

Accordion
AccordionItem


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Developers</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex flex-col">
                        <div class="-m-1.5 overflow-x-auto">
                            <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">

                                <div class="grid grid-cols-4 p-4 gap-x-4">
                                    <p class="flex">
                                        Name
                                    </p>
                                    <p class="flex">
                                        Seniority
                                    </p>
                                    <p class="flex">
                                        Cost
                                    </p>
                                    <p class="flex">
                                        Busy
                                    </p>
                                </div>

                                <div
                                    v-for="developer in developers.data"
                                    :key="developer.id"
                                    class="grid grid-cols-4 p-4 gap-x-4">
                                    <button class="flex">
                                        <p>{{ developer.name }}</p>
                                    </button>
                                    <div class="flex">
                                        <p>{{ developer.seniority }}</p>
                                    </div>
                                    <div class="flex">
                                        <p>{{ developer.cost }}</p>
                                    </div>
                                    <div class="flex">
                                        <p>{{ developer.is_busy }}</p>
                                    </div>
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

                                                </div>
                                            </template>
                                        </AccordionItem>
                                    </Accordion>
                                </div>

                                <div class="w-full px-4 py-3">
                                    <RenderlessPagination :data="developers" @pagination-change-page="goToPage" />
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
