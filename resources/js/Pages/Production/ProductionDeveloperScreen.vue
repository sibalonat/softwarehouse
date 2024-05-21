<script setup>
import RenderlessPagination from '@/Components/Pagination/RenderlessPagination.vue';
import DynamicHeroIcon from '@/Components/Partials/DynamicHeroIcon.vue';
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
                                <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Project</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Complexity</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">Is Completed</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">End date</th>
                                    <th scope="col" class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-end">Pending</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr v-for="developer in developers.data" :key="developer.id">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">
                                        {{ developer.name }}
                                    </td>
                                    <!-- 'low', 'medium', 'high' -->
                                    <td class="px-6 py-4 font-light whitespace-nowrap">
                                        <div class="text-center capitalize rounded-md"
                                        :class="developer.complexity == 'low' ?
                                        'bg-teal-600 text-slate-50' :  developer.complexity === 'medium' ?
                                        'bg-yellow-400 text-gray-800' : 'bg-blue-500 text-slate-50'">
                                            {{ developer.complexity }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">
                                        {{ developer.is_completed }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800 text-medium whitespace-nowrap">
                                        {{ developer.end_date }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap text-end">
                                        <DynamicHeroIcon
                                        :name="developer.developer_id || developer.sales_people_id ? 'check' : 'x-circle'"
                                        :size="6"
                                        class="ml-auto text-blue-600" />
                                    </td>
                                    </tr>
                                </tbody>
                                </table>
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
