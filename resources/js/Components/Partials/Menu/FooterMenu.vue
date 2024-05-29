<script setup>
import Dropdown from "@/Components/Partials/Menu/DropDown.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import DynamicHeroIcon from "../DynamicHeroIcon.vue";

defineProps({
    links: Array,
});

// properties
const openIndex = ref(-1);

// methods
const handleToggle = (index) => {
    openIndex.value = openIndex.value === index ? -1 : index;
};

</script>
<template>
<div class="mx-auto w-1/3 grid grid grid-cols-3 gap-x-4">
    <Dropdown
    v-show="item.children.length"
    v-for="(item, index) in links"
    :key="index"
    :index="index"
    :isOpen="openIndex === index"
    @toggle="handleToggle"
    width="48">
        <template #trigger>
            <div class="flex w-full h-full text-center justify-center">
                <button
                    type="button"
                    class="w-full mx-auto h-full py-2 text-center font-semibold text-lg uppercase transition ease-in-out duration-150"
                    :class="openIndex === index ? 'bg-slate-50 text-virtual-blue rounded-md' : 'text-slate-50'"
                >
                    {{ item.title }}

                    <DynamicHeroIcon
                    :name="openIndex === index ? 'chevron-up' : 'chevron-down'"
                    :size="5"
                    class="ms-4 inline-flex" />

                </button>
            </div>
        </template>

        <template #content>
            <Link :href="route(link.route)" v-for="link in item.children" :key="link"
            class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                {{ link.title }}
            </Link>
        </template>
    </Dropdown>
    <Link
    v-show="!item.children.length"
    v-for="item in links"
    :href="item.route ? route(item.route) : '#'"
    :key="item"
    :class="route().current(item.route) ? 'bg-slate-50 text-virtual-blue rounded-md' : 'text-slate-50'"
    class="py-2 text-center font-semibold text-lg uppercase">
        <DynamicHeroIcon
        :name="item.icon"
        :size="5"
        class="mr-4 inline-flex" />
        {{ item.title }}
    </Link>
</div>
</template>



