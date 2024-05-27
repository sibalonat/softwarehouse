<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useNavigationStore } from '@/Stores/NavigationStore';
import { Head } from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';
import { ref } from 'vue';
import { reactive } from 'vue';

const props = defineProps({
    projects: Number,
    salesforce: Number,
    developers: Number,
});

/// pinia
const navigation = useNavigationStore();
const { auth } = storeToRefs(navigation);

// properties
const chartOptions = reactive({
    chart: {
        type: 'donut',
    },
    plotOptions: {
        pie: {
        startAngle: -90,
        endAngle: 90,
        offsetY: 10
        }
    },
    grid: {
        padding: {
        bottom: -80
        }
    },
    labels: ['Projects', 'Sales-Force', 'Developers'],
});

const series = ref([props.projects, props.salesforce, props.developers]);

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="w-1/2 mx-auto">
                            <apexchart type="donut" :options="chartOptions" :series="series"></apexchart>
                        </div>
                        <p class="bg-graybell px-4 py-2">
                            Last game update: {{ auth.user.last_gameplay }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
