<script setup>
import RenderlessPagination from '@/Components/Pagination/RenderlessPagination.vue';
import DynamicHeroIcon from '@/Components/Partials/DynamicHeroIcon.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted } from 'vue';

const props = defineProps({
    salesforce: {
        type: Object,
        required: true,
    },
});

//methods
const goToPage = (e) => {
    if (e === props.salesforce.current_page && e - 1 === props.salesforce.current_page) {
        return;
    } else {
        const url = props.salesforce.links[e]?.url;
        router.visit(url);
    }
}


</script>

<template>
    <Head title="Sales-Force" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Sales-Force</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex flex-col">
                        <div class="-m-1.5 overflow-x-auto">
                            <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="p-10 overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-neutral-300">
                                    <tr class="font-semibold">
                                        <th
                                        scope="col"
                                        class="px-6 py-3 text-sm text-gray-500 uppercase text-start">
                                            Name
                                        </th>
                                        <th
                                        scope="col"
                                        class="px-6 py-3 text-sm text-center text-gray-500 uppercase">
                                            Seniority
                                        </th>
                                        <th
                                        scope="col"
                                        class="px-6 py-3 text-sm font-medium text-center text-gray-500 uppercase">
                                            Cost
                                        </th>
                                        <th
                                        scope="col"
                                        class="px-6 py-3 text-sm text-gray-500 uppercase text-end">
                                            Busy
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-neutral-300">
                                    <tr v-for="agent in salesforce.data" :key="agent.id">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">
                                        {{ agent.name }}
                                    </td>
                                    <td class="px-6 py-4 font-light whitespace-nowrap">
                                        <div class="text-center capitalize rounded-md"
                                        :class="agent.experience == 'beginner' ?
                                        'bg-teal-600 text-slate-50' :  agent.experience === 'intermediate' ?
                                        'bg-yellow-400 text-gray-800' : 'bg-blue-500 text-slate-50'">
                                            {{ agent.experience }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center text-gray-800 uppercase whitespace-nowrap">
                                        {{ agent.cost }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap text-end">
                                        <DynamicHeroIcon
                                        :name="agent.is_busy ? 'check' : 'x-circle'"
                                        :size="6"
                                        class="ml-auto text-blue-600" />
                                    </td>
                                    </tr>
                                </tbody>
                                </table>
                                <div class="w-full px-4 py-3">
                                    <RenderlessPagination :data="salesforce" @pagination-change-page="goToPage" />
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
