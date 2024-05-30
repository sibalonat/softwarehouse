<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { ref } from 'vue';
import { reactive } from 'vue';


const props = defineProps({
    cost: Number,
    balance: Number,
    update: String,
    projectsWithDevAndSales: Number,
    projectsWithoutDevAndSales: Number,
    projectsWithoutEndDate: Number,
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
    labels: ['Costs', 'Revenue'],
});

const series = ref([props.cost, props.balance]);

const chartOperationOptions = reactive({
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
    labels: ['Projects finished', 'Projects ongoing', 'Projects without end date'],
});

const OperationSeries = ref([props.projectsWithoutDevAndSales, props.projectsWithDevAndSales, props.projectsWithoutEndDate]);

onMounted(() => {
    setInterval(async () => {
        router.reload({
            only: [
                'cost',
                'balance',
                'update',
                'projectsWithDevAndSales',
                'projectsWithoutDevAndSales',
                'projectsWithoutEndDate'
            ]});
    }, 180000);
});

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
                        <div class="grid grid-cols-2 gap-x-5 mx-auto">
                            <div class="flex flex-col border p-3 rounded-t-md">
                                <h3 class="text-lg font-semibold text-gray-800">Financial Overview</h3>

                                <apexchart type="donut" :options="chartOptions" :series="series"></apexchart>
                            </div>
                            <div class="flex flex-col flex flex-col relative border p-3 rounded-t-md">
                                <h3 class="text-lg font-semibold text-gray-800"> Operation Overview </h3>

                                <apexchart type="donut" :options="chartOperationOptions" :series="OperationSeries"></apexchart>
                            </div>
                        </div>

                        <p class="bg-graybell px-4 py-2 text-sm font-light">
                            Last game update: {{ update }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
