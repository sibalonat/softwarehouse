<script setup>
import RenderlessPagination from '@/Components/Pagination/RenderlessPagination.vue';
// import DynamicHeroIcon from '@/Components/Partials/DynamicHeroIcon.vue';
import { useFormAttributeStores } from '@/Stores/FormAttributeStores';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Toggle from "@/Components/Form/Toggle.vue";
import { storeToRefs } from 'pinia';

// props
const props = defineProps({
    salesforce: {
        type: Object,
        required: true,
    },
});

useFormAttributeStores;

const form = useFormAttributeStores();
const { sendRequest, setUpData } = form;
const { classesForToggle, hiredBoolean } = storeToRefs(form);

// computed

//methods
const goToPage = (e) => {
    if (e === props.salesforce.current_page && e - 1 === props.salesforce.current_page) {
        return;
    } else {
        const url = props.salesforce.links[e]?.url;
        router.visit(url);
    }
}

// const sendRequest = (c, e) => {
//     let i = 0;
//     i++;
//     if (i > 0) {
//         console.log(c);
//         // router.put(
//         //     route("document.mapp", c),
//         //     {
//         //         e,
//         //     },
//         //     {
//         //         onFinish: (visit) => {
//         //             router.reload({ only: ["category"] });
//         //         },
//         //     }
//         // );
//     }
// };

// hooks
onMounted(() => {
    setUpData(props.salesforce);
});


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Salesforce</h2>
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
                                    <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">
                                        Name Surname
                                    </th>
                                    <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">
                                        Experience
                                    </th>
                                    <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">
                                        Cost
                                    </th>
                                    <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-start">
                                        Is busy
                                    </th>
                                    <th
                                    scope="col"
                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-end">
                                        Hire
                                    </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <tr v-for="(index, person) in salesforce.data" :key="person.id">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">
                                        {{ person.name }} {{ person.last_name }}
                                    </td>
                                    <td class="px-6 py-4 font-light whitespace-nowrap">
                                        <div class="text-center capitalize rounded-md"
                                        :class="person.experience == 'beginner' ?
                                        'bg-teal-600 text-slate-50' :  person.experience === 'intermediate' ?
                                        'bg-yellow-400 text-gray-800' : 'bg-blue-500 text-slate-50'">
                                            {{ person.experience }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800 whitespace-nowrap">
                                        {{ person.cost }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800 text-medium whitespace-nowrap">
                                        {{ person.is_busy }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap text-end">
                                        <Toggle
                                        :classes="classesForToggle"
                                        v-model="hiredBoolean[index].hired"
                                        :true-value="1"
                                        :false-value="0"
                                        @change="sendRequest(person, $event, 'hr.salesforce.hire', 'salesforce')" />
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
