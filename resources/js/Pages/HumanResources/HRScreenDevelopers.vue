<script setup>
import RenderlessPagination from '@/Components/Pagination/RenderlessPagination.vue';
// import DynamicHeroIcon from '@/Components/Partials/DynamicHeroIcon.vue';
import { useFormAttributeStores } from '@/Stores/FormAttributeStores';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import Toggle from "@/Components/Form/Toggle.vue";
import { storeToRefs } from 'pinia';
import { onMounted } from 'vue';
import { onBeforeMount } from 'vue';
import { computed } from 'vue';

// props
const props = defineProps({
    developers: {
        type: Object,
        required: true,
    },
});

// stores
const form = useFormAttributeStores();
const { sendRequest, setUpData } = form;
const { hiredBoolean } = storeToRefs(form);

// computed

const classesForToggle = computed(() => {
    return {
        container: 'inline-block rounded-full outline-none focus:ring focus:ring-neutral-100 focus:ring-opacity-0',
        toggle: 'flex h-5 w-12 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
        toggleOn: 'bg-neutral-500 border-neutral-100 justify-start text-white',
        toggleOff: 'bg-gray-200 border-gray-200 justify-end text-gray-700',
        toggleOnDisabled: 'bg-gray-300 border-gray-300 justify-start text-gray-400 cursor-not-allowed',
        toggleOffDisabled: 'bg-gray-200 border-gray-200 justify-end text-gray-400 cursor-not-allowed',
        handle: 'inline-block bg-white w-5 h-5 top-0 rounded-full absolute transition-all',
        handleOn: 'left-full transform -translate-x-full',
        handleOff: 'left-0',
        handleOnDisabled: 'bg-gray-100 left-full transform -translate-x-full',
        handleOffDisabled: 'bg-gray-100 left-0',
        label: 'text-center w-8 border-box whitespace-nowrap select-none',
    }
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

// hooks
onBeforeMount(() => {
    setUpData(props.developers);
});


</script>

<template>
    <Head title="Developers" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Developers - for hire</h2>
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
                                            Name Surname
                                        </th>
                                        <th
                                        scope="col"
                                        class="px-6 py-3 text-sm text-center text-gray-500 uppercase">
                                            Experience
                                        </th>
                                        <th
                                        scope="col"
                                        class="px-6 py-3 text-sm text-center text-gray-500 uppercase">
                                            Cost
                                        </th>
                                        <th
                                        scope="col"
                                        class="px-6 py-3 text-sm font-medium text-center text-gray-500 uppercase">
                                            Is busy
                                        </th>
                                        <th
                                        scope="col"
                                        class="px-6 py-3 text-sm font-medium text-gray-500 uppercase text-end">
                                            Hire
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-neutral-300">
                                    <tr v-for="(person, index) in developers.data" :key="person.id">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">
                                        {{ person.name }} {{ person.last_name }}
                                    </td>
                                    <td class="px-6 py-4 font-light whitespace-nowrap">
                                        <div class="text-center capitalize rounded-md"
                                        :class="person.seniority == 'junior' ?
                                        'bg-teal-600 text-slate-50' :  person.seniority === 'middle' ?
                                        'bg-yellow-400 text-gray-800' : 'bg-blue-500 text-slate-50'">
                                            {{ person.seniority }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center text-gray-800 whitespace-nowrap">
                                        {{ person.cost }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center text-gray-800 uppercase text-medium whitespace-nowrap">
                                        {{ person.is_busy }}
                                    </td>
                                    <td class="py-4 pl-6 text-sm font-medium whitespace-nowrap text-end">
                                        <Toggle
                                        v-model="hiredBoolean.data[index].hired"
                                        :classes="classesForToggle"
                                        :true-value="1"
                                        :false-value="0"
                                        @change="sendRequest(person, $event, 'hr.developer.hire', 'developers')" />
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
