<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import { reactive } from 'vue';

const props = defineProps({
    projects: Number,
    salesforce: Number,
    developers: Number,
});

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
                        <apexchart type="donut" :options="chartOptions" :series="series"></apexchart>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
