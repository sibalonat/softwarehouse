<script setup>
import RenderlessPagination from '@/Components/Pagination/RenderlessPagination.vue';
import DynamicHeroIcon from '@/Components/Partials/DynamicHeroIcon.vue';
import Accordion from '@/Components/Partials/Menu/Accordion.vue';
import AccordionItem from '@/Components/Partials/Menu/AccordionItem.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { useForm } from '@formkit/inertia'
import { computed } from 'vue';

const props = defineProps({
    developers: {
        type: Object,
        required: true,
    },
    projects: {
        type: Object,
        required: true,
    },
});

// properties
const submitForm = ref([]);

// computed
const developerprojects = computed(() => {
    return props.developers.data.map(dev => {
        if (dev.project?.id) {
            return dev.project?.id;
        }
    }).filter(Boolean);
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

const form = useForm()
const submitHandler = (fields, node) => {
    if (fields['project_id'] === null) {
        return;
    }
    form.put(route('production.projects.update', fields['project_id']))(fields, node)
}

const changeHandler = () => {
    submitForm.value.forEach(element => {
        element.node.submit()
    });
}

// check if it can show
const canShow = () => {
    const condition = props.projects.some(el => developerprojects.value.includes(el.value));

    if (props.projects.length === 1) {
        return false;
    } else {
        return !condition;
    }
}


// hooks
onMounted(() => console.log(props.projects));


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
                            <div class="p-10 overflow-hidden">
                                <!-- class="bg-neutral-300" -->

                                <div class="grid grid-cols-5 p-4 gap-x-4 bg-neutral-300">
                                    <p class="flex py-3 text-sm text-gray-500 uppercase text-start">
                                        Name
                                    </p>
                                    <p class="flex py-3 text-sm text-gray-500 uppercase text-start">
                                        Seniority
                                    </p>
                                    <p class="flex py-3 text-sm text-gray-500 uppercase text-start">
                                        Cost
                                    </p>
                                    <p class="flex py-3 text-sm text-gray-500 uppercase text-start">
                                        Busy
                                    </p>
                                    <p class="flex py-3 text-sm text-gray-500 uppercase text-start">
                                        Action
                                    </p>
                                </div>

                                <div
                                    v-for="(developer, index) in developers.data"
                                    :key="developer.id"
                                    class="grid grid-cols-5 p-4 gap-x-4">
                                    <div class="flex pr-6 py-3 text-sm text-gray-500 uppercase text-start">
                                        <p>{{ developer.name }}</p>
                                    </div>
                                    <div class="flex pr-6 py-3 text-sm text-gray-500 uppercase text-start">
                                        <p>{{ developer.seniority }}</p>
                                    </div>
                                    <div class="flex pr-6 py-3 text-sm text-gray-500 uppercase text-start">
                                        <p>{{ developer.cost }}</p>
                                    </div>
                                    <div class="flex pr-6 py-3 text-sm text-gray-500 uppercase text-start">
                                        <p>
                                            {{ developer.is_busy }}
                                        </p>
                                    </div>

                                    <Accordion v-if="!developer.project?.developer_id && canShow()">
                                        <AccordionItem>
                                            <template #accordion-trigger>
                                                <button class="flex items-end justify-between w-full group" >
                                                    Assign project {{ index }}
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
                                                        name="project_id"
                                                        :classes="{
                                                            label: '$reset w-full text-sm font-normal text-neutral-500',
                                                            input: '$reset w-full border-1 rounded-md py-0.7 border-graybell',
                                                            inner: '$reset relative flex item-center shadow-none',
                                                            selectIcon: '$reset hideit',
                                                        }"
                                                        :options="projects" />

                                                        <FormKit
                                                        name="developer_id"
                                                        type="hidden"
                                                        :value="developer.id" />

                                                    </Formkit>

                                                </div>
                                            </template>
                                        </AccordionItem>
                                    </Accordion>
                                    <div class="flex" v-else-if="developer.project?.developer_id">
                                        <p>{{ developer.project.name }}</p>
                                    </div>
                                    <div class="flex" v-else-if="!canShow()">
                                        <p>There are no projects</p>
                                    </div>
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
<style>
.hideit {
    display: none !important;
}
</style>
