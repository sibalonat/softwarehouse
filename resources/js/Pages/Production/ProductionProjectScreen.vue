<script setup>
import RenderlessPagination from '@/Components/Pagination/RenderlessPagination.vue';
import DynamicHeroIcon from '@/Components/Partials/DynamicHeroIcon.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Accordion from '@/Components/Partials/Menu/Accordion.vue';
import AccordionItem from '@/Components/Partials/Menu/AccordionItem.vue';
import { useForm } from '@formkit/inertia';
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    projects: {
        type: Object,
        required: true,
    },
    developers: {
        type: Array,
        required: true,
    },
});

// properties
const form = useForm()
const submitForm = ref([]);

// computed
const developerprojects = computed(() => {
    return props.projects.data.map(project => {
        if (project.developer?.id) {
            return project.developer?.id;
        }
    }).filter(Boolean);
});

//methods
const goToPage = (e) => {
    if (e === props.projects.current_page && e - 1 === props.projects.current_page) {
        return;
    } else {
        const url = props.projects.links[e]?.url;
        router.visit(url);
    }
}

// check if it can show
const canShow = () => {
    const condition = props.developers.some(el => developerprojects.value.includes(el.value));

    if (props.developers.length === 1) {
        return false;
    } else {
        return !condition;
    }
}

const submitHandler = (fields, node) => {
    console.log(fields);
    if (fields['developer_id'] === null) {
        return;
    }
    form.put(route('production.developers.update', { developer: fields['developer_id'] }))(fields, node)
}

const changeHandler = () => {
    submitForm.value.forEach(element => {
        element.node.submit()
    });
}


</script>

<template>
    <Head title="Projects" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Projects</h2>
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
                                            Project
                                        </th>
                                        <th
                                        scope="col"
                                        class="px-6 py-3 text-sm text-center text-gray-500 uppercase">
                                            Complexity
                                        </th>
                                        <th
                                        scope="col"
                                        class="px-6 py-3 text-sm font-medium text-center text-gray-500 uppercase">
                                            Is Completed
                                        </th>
                                        <th
                                        scope="col"
                                        class="px-6 py-3 text-sm text-gray-500 uppercase text-start">
                                            End date
                                        </th>
                                        <th
                                        scope="col"
                                        class="px-6 py-3 text-sm font-medium text-gray-500 uppercase text-end">
                                            Pending
                                        </th>
                                        <th
                                        scope="col"
                                        class="px-6 py-3 text-sm font-medium text-gray-500 uppercase text-end">
                                            Assign
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-neutral-300">
                                    <tr v-for="project in projects.data" :key="project.id">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800 whitespace-nowrap">
                                        {{ project.name }}
                                    </td>
                                    <td class="px-6 py-4 font-light whitespace-nowrap">
                                        <div class="text-center capitalize rounded-md"
                                        :class="project.complexity == 'low' ?
                                        'bg-teal-600 text-slate-50' :  project.complexity === 'medium' ?
                                        'bg-yellow-400 text-gray-800' : 'bg-blue-500 text-slate-50'">
                                            {{ project.complexity }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-center text-gray-800 uppercase whitespace-nowrap">
                                        {{ project.is_completed }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-800 text-medium whitespace-nowrap">
                                        {{ project.end_date }}
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap text-end">
                                        <DynamicHeroIcon
                                        :name="project.developer_id || project.sales_people_id ? 'check' : 'x-circle'"
                                        :size="6"
                                        class="ml-auto text-blue-600" />
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap text-end">
                                        <Accordion v-if="!project.developer?.id && canShow()">
                                            <AccordionItem>
                                                <template #accordion-trigger>
                                                    <button class="flex items-end justify-between w-full group" >
                                                        Assign developer
                                                    </button>
                                                </template>

                                                <template #accordion-content>
                                                    <div class="flex flex-col w-full mt-2 space-y-3">
                                                        <FormKit
                                                        ref="submitForm"
                                                        type="form"
                                                        @submit="submitHandler"
                                                        :actions="false"
                                                        :plugins="[form.plugin]">
                                                            <FormKit
                                                            type="select"
                                                            @change="changeHandler"
                                                            name="developer_id"
                                                            :classes="{
                                                                label: '$reset w-full text-sm font-normal text-neutral-500',
                                                                input: '$reset w-full border-1 rounded-md py-0.7 border-graybell',
                                                                inner: '$reset relative flex item-center shadow-none',
                                                                selectIcon: '$reset hideit',
                                                            }"
                                                            :options="developers" />

                                                            <FormKit
                                                            name="project_id"
                                                            type="hidden"
                                                            :value="project.id" />

                                                        </Formkit>

                                                    </div>
                                                </template>
                                            </AccordionItem>
                                        </Accordion>
                                        <div class="flex" v-else-if="project.developer?.id">
                                            <p>{{ project.developer.name }}</p>
                                        </div>
                                        <div class="flex" v-else-if="!canShow()">
                                            <p>There are no developers</p>
                                        </div>
                                    </td>
                                    </tr>
                                </tbody>
                                </table>
                                <div class="w-full px-4 py-3">
                                    <RenderlessPagination :data="projects" @pagination-change-page="goToPage" />
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
<style>
.hideit {
    display: none !important;
}
</style>
